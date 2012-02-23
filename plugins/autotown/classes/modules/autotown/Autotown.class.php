<?php

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginAutotown_ModuleAutotown extends Module {
	
	protected $c;
	
	public function Init() {
		$this->c = Config::Get('plugin.autotown');
	}

	
	protected function FetchXML($sIp){
		
		$sPostData = http_build_query(array(
			'address' => '<ipquery><fields><region/><city/><lat/><lng/>'
				."<ip-list><ip>$sIp</ip></ip-list></fields></ipquery>"
		));
		
		$rHandler = curl_init();
		curl_setopt($rHandler, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($rHandler, CURLOPT_POST, true);
		curl_setopt($rHandler, CURLOPT_HEADER, false);
		curl_setopt($rHandler, CURLOPT_URL, 'http://194.85.91.253:8090/geo/geo.html');
		curl_setopt($rHandler, CURLOPT_TIMEOUT, 2);
		curl_setopt($rHandler, CURLOPT_HTTPHEADER, array('Content-Length: '.strlen($sPostData)));
		curl_setopt($rHandler, CURLOPT_POSTFIELDS, $sPostData);
		
		$sResponse = curl_exec($rHandler);
		
		if(curl_errno($rHandler)
		|| strpos($sResponse, '<?xml') === false){
			return;
		}
		
		return $sResponse;
	}
	
	
	public function Get($sIp) {
		
		$cache_key = "autotown_xml_$sIp";
		
		if (!($sXML = $this->Cache_Get($cache_key))) {
			$sXML = $this->FetchXML($sIp);
			if($sXML){
				$this->Cache_Set($sXML, $cache_key, array('autotown'), 60*60*24*14);
			}else{
				return;
			}
		}
		
		$oXML = @simplexml_load_string($sXML);
		
		if(!isset($oXML->ip->city))
			return;
		
		return $oXML->ip;
	}
	
}

?>
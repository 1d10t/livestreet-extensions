<?php

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginAutotown_ModuleAutotown extends Module {
	
	protected $c;
	
	public function Init() {
		$this->c = Config::Get('plugin.autotown');
	}
	
	public function CountyName($sCountryCode){
		return isset($this->c['country_names'][$sCountryCode])
			? $this->c['country_names'][$sCountryCode]
			: $sCountryCode
		;
	}
	
	protected function FetchXML($sIp){
		
		$rHandler = curl_init();
		curl_setopt($rHandler, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($rHandler, CURLOPT_HEADER, false);
		curl_setopt($rHandler, CURLOPT_URL, 'http://ipgeobase.ru:7020/geo?ip='.$sIp);
		curl_setopt($rHandler, CURLOPT_TIMEOUT, 2);
		
		$sResponse = curl_exec($rHandler);
		
		if(curl_errno($rHandler)
		|| strpos($sResponse, '<?xml') === false){
			return;
		}
		
		return $sResponse;
	}
	
	
	public function Get($sIp) {
		
		$cache_key = "autotown-0.1.0_xml_$sIp";
		
		if (!($sXML = $this->Cache_Get($cache_key))) {
			$sXML = $this->FetchXML($sIp);
			if($sXML){
				$this->Cache_Set($sXML, $cache_key, array('autotown'), 60*60*24*14);
			}else{
				return;
			}
		}
		
		$oXML = @simplexml_load_string($sXML);
		
		if(!isset($oXML->ip->country))
			return;
		
		return $oXML->ip;
	}
	
}

?>
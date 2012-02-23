<?php 
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginChdate
extends Plugin
{
	
	protected $aInherits = array(
		'module'	=> array(
			'ModuleTopic'	=> 'PluginChdate_ModuleTopic',
		),
	);
	
	public function Activate() {
		return true;
	}
	
	public function Init() {
	}
	
}

?>
<?php 

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginAutotown extends Plugin {
	
	public function Activate() {
		return extension_loaded('curl');
	}
	
	public function Init() {
	}
	
}

?>
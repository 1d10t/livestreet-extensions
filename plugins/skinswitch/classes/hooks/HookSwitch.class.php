<?php

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginSkinswitch_HookSwitch extends Hook {
	public function RegisterHook() {
		$this->AddHook('viewer_init_start','Skinswitch');
		$this->AddHook('template_body_begin', 'InjectSwitcher');
	}

	public function InjectSwitcher() {
		$oViewer = $this->Viewer_GetLocalViewer();
		$oViewer->Assign('aSkinswitchTemplates', Config::Get('plugin.skinswitch.skins'));
		$oViewer->Assign('aSkinswitchGetParam', Config::Get('plugin.skinswitch.get_param'));
		$oViewer->Assign('aSkinswitchCurrent', Config::Get('view.skin'));
		return $oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__).'piece.skinswitch.tpl');
	}

	public function Skinswitch() {
		$aSkins = Config::Get('plugin.skinswitch.skins');
		if(!$aSkins){
			return;
		}
		$sGetParam = Config::Get('plugin.skinswitch.get_param');
		$sGetValue = getRequest($sGetParam, null, 'get');
		@$sSessValue = &$_SESSION['skinswitch.skin'];
		$bSetSkin = false;
		if(in_array($sGetValue, $aSkins)){
			$sSessValue = $sGetValue;
			$bSetSkin = true;
		}elseif(in_array($sSessValue, $aSkins)){
			$bSetSkin = true;
		}
		if($bSetSkin){
			Config::Set('view.skin', $sSessValue);
		}
	}
}

?>
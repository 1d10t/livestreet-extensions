<?php

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginChdate_HookChdate extends Hook {
	
	
	public function RegisterHook() {
		$this->AddHook('init_action','AssignRequest');
		
		$aHooks = Config::Get('plugin.chdate.template_hooks');
		if(!empty($aHooks) && is_array($aHooks)){
			foreach($aHooks as $sHook){
				$this->AddHook($sHook, 'TopicDateField');
			}
		}
	}
	
	public function AssignRequest(){
		if(isPost('chdate_topic_date_add')){
			$_REQUEST['topic_date_add'] = getRequest('chdate_topic_date_add', '', 'post');
		}
	}
	
	
	public function TopicDateField(){
		if(!$this->Topic_ChdateCan()){
			return;
		}
		$sActionEvent = Router::GetActionEvent();
		$iTopicId = (int) Router::GetParam(0);
		if($sActionEvent == 'edit' && $iTopicId){
			$oTopic = $this->Topic_GetTopicById($iTopicId);
			if($oTopic){
				$_REQUEST['topic_date_add'] = $oTopic->getDateAdd();
			}
		}
		$oViewer = $this->Viewer_GetLocalViewer();
		return $oViewer->fetch(
			Plugin::GetTemplatePath(__CLASS__)
			.'piece.chdate.tpl'
		);
	}
}
?>
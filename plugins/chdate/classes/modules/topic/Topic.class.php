<?php 
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginChdate_ModuleTopic
extends PluginChdate_Inherit_ModuleTopic
{
	
	/**
	 * 
	 * @return bool
	 */
	public function ChdateCan(){
		return $this->User_IsAuthorization() && $this->User_GetUserCurrent()->isAdministrator();
	}
	
	
	/**
	 * {@inheritdoc }
	 * 
	 * @param ModuleTopic_EntityTopic $oTopic
	 * @return bool
	 */
	public function AddTopic(ModuleTopic_EntityTopic $oTopic){
		if($this->ChdateCan()
		&& $sDateAdd = getRequest('chdate_topic_date_add', '', 'post')){
			$oTopic->setDateAdd($sDateAdd);
			unset($_POST['chdate_topic_date_add']);
		}
		return parent::AddTopic($oTopic);
	}
	
	
	/**
	 * {@inheritdoc }
	 * 
	 * @param ModuleTopic_EntityTopic $oTopic
	 * @return bool
	 */
	public function UpdateTopic(ModuleTopic_EntityTopic $oTopic){
		if($this->ChdateCan()
		&& $sDateAdd = getRequest('chdate_topic_date_add', '', 'post')){
			$oTopic->setDateAdd($sDateAdd);
			unset($_POST['chdate_topic_date_add']);
		}
		return parent::UpdateTopic($oTopic);
	}
	
}

?>
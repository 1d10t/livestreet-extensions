<?php

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}
 
class PluginAutotown_HookAddTown extends Hook {   
	
	public function RegisterHook() {
		$this->AddHook('module_user_add_after', 'AddTown', __CLASS__);
	}
	
	
	public function AddTown($aVars) {
		$oUser = &$aVars['result'];
		if(!$oUser){
			return;
		}
		/**
		 * Получаем свежую запись из базы
		 */
		$oUser = $this->User_GetUserById($oUser->getId());
		$sIp = $oUser->getIpRegister();
		/**
		 * Спрашиваем у ipgeobase.ru откуда IP
		 */
		$oResponse = $this->PluginAutotown_Autotown_Get($sIp);
		if(!isset($oResponse->city))
			return;
		/**
		 * Выставляем полученные значения юзеру в профиль
		 */
		$oUser->setProfileCountry('Россия');
		$oUser->setProfileRegion((string)$oResponse->region);
		$oUser->setProfileCity((string)$oResponse->city);
		/**
		 * Добавляем релейшны страны 
		 */
		if ($oUser->getProfileCountry()) {
			if (!($oCountry=$this->User_GetCountryByName($oUser->getProfileCountry()))) {
				$oCountry=Engine::GetEntity('User_Country');
				$oCountry->setName($oUser->getProfileCountry());
				$this->User_AddCountry($oCountry);
			}
			$this->User_SetCountryUser($oCountry->getId(),$oUser->getId());
		}
		/**
		 * Добавляем релейшны города 
		 */
		if ($oUser->getProfileCity()) {
			if (!($oCity=$this->User_GetCityByName($oUser->getProfileCity()))) {
				$oCity=Engine::GetEntity('User_City');
				$oCity->setName($oUser->getProfileCity());
				$this->User_AddCity($oCity);
			}
			$this->User_SetCityUser($oCity->getId(),$oUser->getId());
		}
		/**
		 * Обновляем пользователя
		 */
		$this->User_Update($oUser);
	}
	
}


?>
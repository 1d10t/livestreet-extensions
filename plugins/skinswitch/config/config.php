<?php 
if (!class_exists('Config')) {
	die('Hacking attemp!');
}

$config['get_param'] = 'pa-pap-americano';


//$config['skins'] = array('new', 'developer');
$config['skins'] = array_map(
	'basename',
	glob(
		dirname(Config::Get('path.smarty.template')).'/*',
		GLOB_ONLYDIR
	)
);

return $config;

?>
<?php

require_once 'G://programfiles//symfony-1.4.18//lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
	public function setup()
	{
		$this->enablePlugins('sfDoctrinePlugin');
		$this->enablePlugins('sfPHPUnit2Plugin');
		$this->enablePlugins('sfDoctrineGuardPlugin');
		$this->enablePlugins('sfFormExtraPlugin');
	}

	static protected $zendLoaded = false;

	static public function registerZend()
	{
		if (self::$zendLoaded)
		{
			return;
		}

		set_include_path(sfConfig::get('sf_lib_dir').'/vendor'.PATH_SEPARATOR.get_include_path());
		require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader/Autoloader.php';
		Zend_Loader_Autoloader::getInstance();
		self::$zendLoaded = true;
	}
}

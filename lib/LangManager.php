<?php

namespace App\Lang;

use App\Lang\Qtranslate;
use App\Lang\WPML;

defined('ABSPATH') OR exit;

class LangManager{

	public static $instance = null;
	public static $langProvider = null;

	public function __construct() {

		if ( function_exists('icl_object_id') ) {

			self::$langProvider = WPML::getInstance();

		}else if(function_exists('qtranxf_getLanguage')){

			self::$langProvider = Qtranslate::getInstance();

		}
	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function getTemplate(){
		return self::$langProvider->getTemplate();
	}

	public function getLanguages(){
		return self::$langProvider->getLanguages();
	}

	public function getCurrentLang(){
		return self::$langProvider->getCurrentLang();
	}

	public function getDefaultLanguage(){
		return self::$langProvider->getDefaultLanguage();
	}

	public function translate(){
		return self::$langProvider->translate();
	}

	public function getProvider(){
		return self::$langProvider;
	}
}

?>
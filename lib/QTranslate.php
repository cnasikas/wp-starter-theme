<?php

namespace App\Lang;

use App\Lang\Lang;

defined('ABSPATH') OR exit;

class QTranslate extends Lang{

	public function __construct() {}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function getTemplate(){

		if(!function_exists('qtranxf_generateLanguageSelectCode'))
			return '';

		qtranxf_generateLanguageSelectCode('text');
	}

	public function getLanguages(){

		if(!function_exists('qtranxf_getSortedLanguages'))
			return array();

		return qtranxf_getSortedLanguages();
	}

	public function getCurrentLang(){

		if(!function_exists('qtranxf_getLanguage'))
			return '';

		return qtranxf_getLanguage();
	}

	public function getDefaultLanguage(){
		
		global $q_config;

		return $q_config['default_language'];
	}

	public function translate($content = ''){

		if(function_exists('qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage')){

			return qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage($content);
		}

		return $content;
	}

}

?>
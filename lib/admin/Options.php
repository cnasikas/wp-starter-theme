<?php

namespace App\Admin;

defined('ABSPATH') OR exit;

class Options{

	protected static $instance = null;

	public function __construct() {
		
	}

	public function init(){

		$this->addThemeOptions();

	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function addThemeOptions(){

		if( function_exists('acf_add_options_page') ) {
	
			acf_add_options_page(array(
				'page_title' 	=> 'Theme Options',
				'menu_title'	=> 'Theme Options',
				'menu_slug' 	=> 'theme-general-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> true
			));
			
		}

	}

}

?>
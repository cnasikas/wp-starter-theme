<?php

namespace App\Image;

defined('ABSPATH') OR exit;

class Image{

	protected static $instance = null;

	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		
	}

	public function addSizes(){

	}

	public function removeDimensionAttributes($html) {
	   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
	   return $html;
	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

?>
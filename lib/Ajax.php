<?php

namespace App\Ajax;

defined('ABSPATH') OR exit;

class Ajax{

	protected static $instance = null;

	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		
		$this->setActions();

	}

	public function setActions(){

	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function echoHTMLTemplate($template){
		ob_start();
		echo $template;
		echo ob_get_clean();
		die();
	}

	public function echoToJSON($data){
		echo json_encode($data);
	}
}

?>
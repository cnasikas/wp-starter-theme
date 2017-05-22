<?php

namespace App\View;

defined('ABSPATH') OR exit;

class View{

	protected static $instance = null;

	protected function __construct() {}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

?>
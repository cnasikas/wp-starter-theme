<?php

namespace App\Lang;

defined('ABSPATH') OR exit;

abstract class Lang{

	public static $instance = null;

	abstract protected function getTemplate();
	abstract protected function getDefaultLanguage();
	abstract protected function getLanguages();
	abstract protected function getCurrentLang();
	abstract protected function translate();
}

?>
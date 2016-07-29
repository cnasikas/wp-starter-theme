<?php

use App\Theme\Theme;

defined('ABSPATH') OR exit;

define('APP_TXTD', 'app_txtd');
define('APP_PREFIX', '_app_');

//library main paths and urls
 
define("APP_LIB_PATH", get_stylesheet_directory() . '/');
define("APP_LIB_URL", get_stylesheet_directory_uri() . '/');
define("APP_CSS_URL", APP_LIB_URL.'assets/css/');
define("APP_SCRIPT_URL", APP_LIB_URL.'assets/js/');
define("APP_IMG_URL", APP_LIB_URL.'assets/img/');
define("APP_TEMPLATE", 'templates/');
define("APP_TEMPLATE_PATH", APP_LIB_PATH . 'templates/');

/* WPML */

define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
define('ICL_DONT_LOAD_LANGUAGES_JS', true);

require_once('lib/srand.php');
require_once('lib/Ajax.php');
require_once('lib/Comments.php');
require_once('lib/CustomEntities.php');
require_once('lib/Image.php');
require_once('lib/Lang.php');
require_once('lib/Menu.php');
require_once('lib/Helper.php');
require_once('lib/QTranslate.php');
require_once('lib/WPML.php');
require_once('lib/LangManager.php');
require_once('lib/admin/PanelFilter.php');
require_once('lib/admin/Admin.php');
require_once('lib/admin/Options.php');
require_once('lib/Theme.php');
require_once('lib/helpers.php');

$theme = Theme::getInstance()->init();

?>
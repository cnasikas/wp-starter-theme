<?php

namespace App\Theme;

use App\Admin\Admin;
use App\Admin\Options;
use App\Comments\Comments;
use App\Menu\Menu;
use App\Image\Image;
use App\Lang\LangManager;

defined('ABSPATH') OR exit;

class Theme{

	const VERSION = '1.0.0';

	protected static $slug = '_app_';
	protected static $prefix = '_app_';
	protected static $textDomain = APP_TXTD;

	protected static $instance = null;
	protected static $autoLoader = null;
	
	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		
		$this->setActions();
		$this->setFilters();

		Admin::getInstance()->init();
		//Options::getInstance()->init();
		//DB::getInstance()->init();
		//CustomEntities::getInstance()->init();
		//Ajax::getInstance()->init();
		Comments::getInstance()->init();
		Menu::getInstance()->init();

	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function getSlug() {
		return $this->slug;
	}

	public static function getPrefix() {
		return $this->prefix;
	}

	public static function getTextDomain() {
		return $this->textDomain;
	}

	private function setActions(){

		add_action('after_setup_theme', array($this, 'afterThemeSetup'), 16);
		add_action('after_switch_theme', array($this, 'onThemeActivation'));
		add_action('switch_theme', array($this, 'onThemeDeactivation'));
		add_action( 'init', array($this, 'removeEmojicons'));
	}

	private function onThemeSetupActions(){

		add_action('init', array($this, 'cleanUpHTMLHead'));
		add_action( 'wp_enqueue_scripts', array($this, 'enqueueScriptsAndStyles'), 1);
		add_action('wp_head', array($this, 'wpHead'));
		add_action('wp_footer', array($this, 'wpFooter'), 19);
	}

	private function setFilters(){

		add_filter( 'upload_mimes', array($this, 'setMimeTypes') );
		add_filter( 'use_default_gallery_style', '__return_false' );
		//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	}

	public function removeEmojicons(){

		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		add_filter( 'tiny_mce_plugins', array($this, 'removeEmojiconsTinymce') );

	}

	public function removeEmojiconsTinymce($plugins){

		return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : $plugins;

	}

	private function onThemeSetupFilters(){
		add_filter('the_generator', array($this, 'rssVersion'));
	}

	public function onThemeActivation(){

		

	}

	public function onThemeDeactivation(){

		

	}

	public function afterThemeSetup(){

		$this->loadTextDomain();
		$this->addThemeSupports();
		$this->onThemeSetupActions();
		$this->onThemeSetupFilters();
		Image::getInstance()->addSizes();

	}

	public function wpHead(){
		//echo $this->dynamicCSS();
	}

	public function wpFooter(){

	}

	private function loadTextDomain(){

		load_theme_textdomain( self::$textDomain, APP_LIB_PATH . 'languages' );

	}

	private function addThemeSupports(){

		add_theme_support( 'post-thumbnails');
		add_theme_support( 'menus' );
		add_theme_support( 'woocommerce' );
	}

	public function cleanUpHTMLHead(){
	
		global $sitepress;

		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

		if($sitepress)
			remove_action( 'wp_head', array($sitepress, 'meta_generator_tag' ) );

	}

	public function rssVersion(){ return ''; }

	public function enqueueScriptsAndStyles(){

		if ( !is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', ( '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js' ), false, '1.11.1', true );
			wp_enqueue_script( 'jquery' );
		}

		if(WP_DEBUG === true){

			wp_enqueue_style( 'normalize', APP_CSS_URL . 'normalize.css', array(), false, 'all' );

			$cache_buster = date("YmdHi", filemtime( APP_LIB_PATH . 'assets/css/main.css'));
			wp_enqueue_style( 'main', APP_CSS_URL . 'main.css', array(), $cache_buster, 'all' );
			
			wp_enqueue_script( 'modernizr', APP_SCRIPT_URL . 'vendor/modernizr-2.8.3.min.js', array(), '2.8.3', false );
			
			$cache_buster = date("YmdHi", filemtime( APP_LIB_PATH . 'assets/js/plugins.js'));
			wp_enqueue_script( 'plugins', APP_SCRIPT_URL . 'plugins.js', array(), $cache_buster, true );
			
			$cache_buster = date("YmdHi", filemtime( APP_LIB_PATH . 'assets/js/main.js'));
			wp_enqueue_script( 'main', APP_SCRIPT_URL . 'main.js', array(), $cache_buster, true );
			
		}else{

			$cache_buster = date("YmdHi", filemtime( APP_LIB_PATH . 'assets/css/app.min.css'));
			wp_enqueue_style( 'main', APP_CSS_URL . 'app.min.css', array(), $cache_buster, 'all' );

			$cache_buster = date("YmdHi", filemtime( APP_LIB_PATH . 'assets/js/app.min.js'));
			wp_enqueue_script( 'main', APP_SCRIPT_URL . 'app.min.js', array(), $cache_buster, true );
		}

		wp_localize_script( 'main', 'app_options', $this->getJSVariables());

	}

	public function setMimeTypes($types){

		$types['svg'] = 'image/svg+xml';
	    $types['svgz'] = 'image/svg+xml';

	    return $types;

	}

	private function dynamicCSS(){

		$css = '';

		$css =  preg_replace( '/\s+/', ' ', $css );

		$css = "<!-- Dynamic css -->\n<style type=\"text/css\">\n" . $css . "\n</style>";

		return $css;

	}

	private function getJSVariables(){

		$app_options_js = array(
			'site_name' => esc_js(get_bloginfo( 'name' )),
			'ajax_url' => esc_url(add_query_arg(array('lang' => LangManager::getInstance()->getCurrentLang()), admin_url( 'admin-ajax.php' ))),
			'theme_base' => APP_LIB_URL,
			'lang' => esc_js(LangManager::getInstance()->getCurrentLang()),
		);

		return $app_options_js;

	}

}

?>
<?php

namespace App\Theme;

use App\Admin\Admin;
use App\Admin\Options;
use App\Comments\Comments;
use App\Menu\Menu;
use App\Image\Image;
use App\Lang\LangManager;
use App\Assets;
use App\Trackbacks\Trackbacks;

defined('ABSPATH') OR exit;

class Theme{

	const VERSION = '1.0.0';

	protected static $slug = '_app_';
	protected static $prefix = '_app_';
	protected static $textDomain = APP_TXTD;

	protected static $instance = null;
	protected static $autoLoader = null;

	private static $addJQueryFallback = false;

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
		Trackbacks::getInstance()->init();

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
		add_filter('emoji_svg_url', '__return_false');
		add_filter('the_generator', '__return_false');
		//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

		$this->relativeURLs();

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
		Menu::getInstance()->init();

	}

	public function wpHead(){
		$this->jqueryLocalFallback();
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
		add_theme_support('title-tag');
		add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
		add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
	}

	public function cleanUpHTMLHead(){

		global $sitepress;

		remove_action( 'wp_head', 'wp_generator');
		remove_action( 'wp_head', 'rsd_link');
		remove_action( 'wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'start_post_rel_link', 10);
		remove_action('wp_head', 'parent_post_rel_link', 10);
		remove_action('wp_head', 'adjacent_posts_rel_link', 10);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
		remove_action('wp_head', 'wp_shortlink_wp_head', 10);
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
  	remove_action('wp_head', 'rest_output_link_wp_head', 10);

		if($sitepress)
			remove_action( 'wp_head', array($sitepress, 'meta_generator_tag' ) );

	}

	public function rssVersion(){ return ''; }

	public function enqueueScriptsAndStyles(){

		wp_deregister_script( 'wp-embed' );

		$this->registerJQuery();

		wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);
		wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);

		wp_localize_script( 'main', 'app_options', $this->getJSVariables());

	}

	/* https://github.com/roots/soil */

	public function registerJQuery() {

	  $jquery_version = wp_scripts()->registered['jquery']->ver;

	  wp_deregister_script('jquery');

	  wp_register_script(
	    'jquery',
	    'https://code.jquery.com/jquery-' . $jquery_version . '.min.js',
	    [],
	    null,
	    true
	  );

	  add_filter('script_loader_src', array($this, 'jqueryLocalFallback'), 10, 2);
	}

	/* https://github.com/roots/soil */

	public function jqueryLocalFallback($src = '', $handle = null) {

	  if (self::$addJQueryFallback) {
	    echo '<script>(window.jQuery && jQuery.noConflict()) || document.write(\'<script src="' . self::$addJQueryFallback .'"><\/script>\')</script>' . "\n";
	    self::$addJQueryFallback = false;
	  }

	  if ($handle === 'jquery') {
	    self::$addJQueryFallback = apply_filters('script_loader_src', \includes_url('/js/jquery/jquery.3.2.1.min.js'), 'jquery-fallback');
	  }

	  return $src;
	}

	public function setMimeTypes($types){

		$types['svg'] = 'image/svg+xml';
	    $types['svgz'] = 'image/svg+xml';

	    return $types;

	}

	/* https://github.com/roots/soil */

	public function addFilters($tags, $function, $priority = 10, $accepted_args = 1) {
	  foreach ((array) $tags as $tag) {
	    add_filter($tag, $function, $priority, $accepted_args);
	  }
	}

	/* https://github.com/roots/soil */

	public function rootRelativeURL($input) {

	  if (is_feed()) {
	    return $input;
	  }

	  $url = parse_url($input);
	  if (!isset($url['host']) || !isset($url['path'])) {
	    return $input;
	  }
	  $site_url = parse_url(network_home_url());  // falls back to home_url

	  if (!isset($url['scheme'])) {
	    $url['scheme'] = $site_url['scheme'];
	  }
	  $hosts_match = $site_url['host'] === $url['host'];
	  $schemes_match = $site_url['scheme'] === $url['scheme'];
	  $ports_exist = isset($site_url['port']) && isset($url['port']);
	  $ports_match = ($ports_exist) ? $site_url['port'] === $url['port'] : true;

	  if ($hosts_match && $schemes_match && $ports_match) {
	    return wp_make_link_relative($input);
	  }
	  return $input;
	}

	/* https://github.com/roots/soil */

	public function relativeURLs(){

		if (is_admin() || isset($_GET['sitemap']) || in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'])) {
		  return;
		}

		$root_rel_filters = apply_filters('soil/relative-url-filters', [
		  'bloginfo_url',
		  'the_permalink',
		  'wp_list_pages',
		  'wp_list_categories',
		  'wp_get_attachment_url',
		  'the_content_more_link',
		  'the_tags',
		  'get_pagenum_link',
		  'get_comment_link',
		  'month_link',
		  'day_link',
		  'year_link',
		  'term_link',
		  'the_author_posts_link',
		  'script_loader_src',
		  'style_loader_src'
		]);

		$this->addFilters($root_rel_filters, array($this, 'rootRelativeURL'));

		add_filter('wp_calculate_image_srcset', function ($sources) {
		  foreach ($sources as $source => $src) {
		    $sources[$source]['url'] = $this->rootRelativeURL($src['url']);
		  }
		  return $sources;
		});

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

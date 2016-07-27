<?php

namespace App\Admin;

defined('ABSPATH') OR exit;

class Admin{

	protected static $instance = null;
	protected static $createdBy = array('name' => 'name', 'url' => 'http://site.com/');

	public function __construct() {
		//self::$autoLoader = new RLP_AutoLoader();
	}

	public function init(){
		
		$this->setActions();
		$this->setFilters();

	}

	public function setActions(){
		add_action( 'login_enqueue_scripts', array($this, 'loginLogo') );
		add_action('admin_menu', array($this, 'removeMenus'), 999);
		add_action( 'wp_before_admin_bar_render', array($this, 'manageAdminBar') );
		add_action( 'admin_init', array($this, 'removeDashboardMetaBoxes') );
		add_action('admin_head', array($this,'addStyles') );
	}

	public function setFilters(){
		add_filter( 'login_headerurl', array($this, 'loginLogoURL'));
		add_filter( 'login_headertitle', array($this, 'loginLogoURLTitle'));
		add_filter( 'plugin_action_links', array($this, 'disablePluginDeactivationLink'), 10, 4 );
		add_filter('admin_footer_text', array($this, 'customizeFooter'));
	}

	public function removeMenus() {

		remove_menu_page('edit-comments.php');

		if ( !current_user_can('manage_options') ) {
	 		remove_menu_page('themes.php');
	 		remove_menu_page('plugins.php');
	 		remove_menu_page('tools.php');
		}

		remove_submenu_page( 'themes.php', 'theme-editor.php' );
		remove_submenu_page( 'themes.php', 'customize.php' );
		remove_submenu_page( 'themes.php', 'customize.php?return=' . get_admin_url() . 'plugins.php');
		remove_submenu_page( 'plugins.php', 'plugin-editor.php');

	}

	public function disablePluginDeactivationLink( $actions, $plugin_file, $plugin_data, $context ) {
	
		// Remove edit link for all plugins
		if ( array_key_exists( 'edit', $actions ) )
			unset( $actions['edit'] );

		// Remove deactivate link for important plugins
		if ( array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, array(
			
		)))
		
		unset( $actions['deactivate'] );
		return $actions;
	}

	public function manageAdminBar() {

		if ( !current_user_can('manage_options') ) {

			global $wp_admin_bar;

			$wp_admin_bar->remove_menu('comments');

		}
	}

	public function removeDashboardMetaBoxes() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
        remove_meta_box( 'wpseo_meta', 'post', 'normal' ); // Yoast Metabox
	}

	public function addStyles(){
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin.css', false );
	}

	public function customizeFooter() {
    	echo 'Created by <a href="' . self::$createdBy['url'] . '">' . self::$createdBy['name'] . '</a>';
    }

	public function loginLogo(){

		echo '<style type="text/css">
					body.login div#login h1 a {
					background-image: url('. APP_IMG_URL . 'login-logo.png);
				}

		  	</style>';

	}

	public function loginLogoURL() {
		return get_bloginfo( 'url' );
	}

	public function loginLogoURLTitle() {
		return get_option('blogname');
	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

?>
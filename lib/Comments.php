<?php

namespace App\Comments;

defined('ABSPATH') OR exit;

class Comments{

	protected static $instance = null;

	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		
		$this->setActions();
		$this->setFilters();

	}

	public function setActions(){

		add_action('admin_init', array($this, 'disableCommentsPostTypesSupport'));
		add_action('admin_init', array($this, 'disableCommentsAdminMenuRedirect'));
		add_action('admin_init', array($this, 'disableCommentsDashboard'));
		add_action('init', array($this, 'disableCommentsAdminBar'));
	}

	public function setFilters(){
		add_filter('comments_open', array($this, 'disableCommentsStatus'), 20, 2);
		add_filter('pings_open', array($this, 'disableCommentsStatus'), 20, 2);
		add_filter('comments_array', array($this, 'disableCommentsHideExistingComments'), 10, 2);
	}

	public function disableCommentsPostTypesSupport() {
		$post_types = get_post_types();
		foreach ($post_types as $post_type) {
			if(post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}

	public function disableCommentsAdminMenuRedirect() {
		global $pagenow;
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url()); exit;
		}
	}

	public function disableCommentsDashboard() {
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	}

	public function disableCommentsAdminBar() {
		if (is_admin_bar_showing()) {
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		}
	}

	// Close comments on the front-end
	public function disableCommentsStatus() {
		return false;
	}

	function disableCommentsHideExistingComments($comments) {
		$comments = array();
		return $comments;
	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

?>
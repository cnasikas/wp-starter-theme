<?php

namespace App\CustomEntities;

defined('ABSPATH') OR exit;

class CustomEntities{

	protected static $instance = null;

	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		
		$this->setActions();

	}

	public function setActions(){

		add_action( 'init', array($this, 'registerCustomPostTypes'), 0);
		add_action( 'init', array($this, 'registerTaxonomies'), 1);
	}

	public function registerCustomPostTypes(){

		/*

		$labels = array(
			'name'               => _x( 'Books', 'post type general name', 'APP_TXTD' ),
			'singular_name'      => _x( 'Book', 'post type singular name', 'APP_TXTD' ),
			'menu_name'          => _x( 'Books', 'admin menu', 'APP_TXTD' ),
			'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'APP_TXTD' ),
			'add_new'            => _x( 'Add New', 'book', 'APP_TXTD' ),
			'add_new_item'       => __( 'Add New Book', 'APP_TXTD' ),
			'new_item'           => __( 'New Book', 'APP_TXTD' ),
			'edit_item'          => __( 'Edit Book', 'APP_TXTD' ),
			'view_item'          => __( 'View Book', 'APP_TXTD' ),
			'all_items'          => __( 'All Books', 'APP_TXTD' ),
			'search_items'       => __( 'Search Books', 'APP_TXTD' ),
			'parent_item_colon'  => __( 'Parent Books:', 'APP_TXTD' ),
			'not_found'          => __( 'No books found.', 'APP_TXTD' ),
			'not_found_in_trash' => __( 'No books found in Trash.', 'APP_TXTD' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'book' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'			 => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')
		);

		register_post_type( 'book', $args );

		*/
	}

	public function registerTaxonomies(){

		/*

		$labels = array(
			'name'              => _x( 'Genres', 'taxonomy general name' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Genres' ),
			'all_items'         => __( 'All Genres' ),
			'parent_item'       => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item'         => __( 'Edit Genre' ),
			'update_item'       => __( 'Update Genre' ),
			'add_new_item'      => __( 'Add New Genre' ),
			'new_item_name'     => __( 'New Genre Name' ),
			'menu_name'         => __( 'Genre' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'rewrite'           => array( 'slug' => 'genre' ),
		);

		register_taxonomy( 'genre', array( 'book' ), $args );
		
		*/

	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

?>
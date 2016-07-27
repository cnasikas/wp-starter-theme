<?php

namespace App\DB;

use WP_Query;

defined('ABSPATH') OR exit;

class DB{

	protected static $instance = null;

	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		$this->setActions();
		$this->setFilters();
	}

	public function setActions(){

	}

	public function setFilters(){
		//add_filter( 'pre_get_posts', array($this, 'queryModify'));
	}

	public function getPosts($args = array(), $wpQuery = true){

		$defaults = array(
			'order' => 'DESC',
			'orderby' => 'date',
			'post_type' => 'post',
			'posts_per_page' => -1
		);

		$args = wp_parse_args($args, $defaults);

		return $wpQuery ? new WP_Query($args) : get_posts($args); 
	}

	public function getLatestPost($post_type = 'post', $wpQuery = true){

		$args = array(
			'order' => 'DESC',
			'orderby' => 'date',
			'post_type' => $post_type,
			'posts_per_page' => 1
		);

		return $wpQuery ? new WP_Query($args) : get_posts($args); 
	}

	public function getPageSiblings($wp_query = true){

		global $post;

		$args = array(
			'order' => 'ASC',
			'orderby' => 'date',
			'child_of' => $post->post_parent,
			'parent' => $post->post_parent
		);

		if($wp_query){

			$args['post_type'] = 'page';
			$args['post_parent'] = $post->ID;
			$args['order'] = 'ASC';
			$args['orderby'] = 'menu_order';

			return new WP_Query($args); 
		}

	    return get_pages($args);
	}

	public function getPageSiblingsPagination(){

		global $post;

	    $siblings = $this->getPageSiblings(false);

	    foreach ($siblings as $key=>$sibling){
	        if ($post->ID == $sibling->ID){
	            $ID = $key;
	        }
	    }

	    $before_id = isset($siblings[$ID-1]) ? $siblings[$ID-1] : 0;
	    $after_id = isset($siblings[$ID+1]) ? $siblings[$ID+1] : 0;

	    $closest = array(
	    	'before'=> $before_id,
	    	'after'=> $after_id
	    );

	    return $closest;

	}
	
	/* http://wordpress.stackexchange.com/questions/125554/get-image-description */

	public function getAttachment( $attachment_id ) {

		$attachment = get_post( $attachment_id );

		return array(
		    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		    'caption' => $attachment->post_excerpt,
		    'description' => $attachment->post_content,
		    'href' => get_permalink( $attachment->ID ),
		    'src' => $attachment->guid,
		    'title' => $attachment->post_title
		);
	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

?>
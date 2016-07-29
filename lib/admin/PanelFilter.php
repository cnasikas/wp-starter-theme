<?php

namespace App\Admin;

defined('ABSPATH') OR exit;

class PanelFilter{

	protected static $instance = null;

	public function __construct($args = array()) {
		
		$defaults = array(
			'posts' => array(),
			'filters' => array()
		);

		$this->args = wp_parse_args($args, $defaults);

	}

	public function init(){
		
		$this->setActions();

	}

	public function setActions(){

		add_action('restrict_manage_posts', array($this, 'customPostFilter'));

	}

	public function customPostFilter(){

		//https://wordpress.stackexchange.com/questions/578/adding-a-taxonomy-filter-to-admin-list-for-a-custom-post-type

		global $typenow;

		if(in_array($typenow, $this->args['posts'])){


			foreach ($this->args['filters'] as $tax_slug) {

	            $tax_obj = get_taxonomy($tax_slug);
	            $tax_name = $tax_obj->labels->name;

	            $terms = get_terms($tax_slug);

	            echo '<select name="' . $tax_slug . '" id="' . $tax_slug . '" class="postform">';

		            echo '<option value="">Show All ' . $tax_name . '</option>';

		            foreach ($terms as $term) {
		                
		                echo '<option value=' . $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
		            }

		        echo "</select>";
	        }

		}

	}

}

?>
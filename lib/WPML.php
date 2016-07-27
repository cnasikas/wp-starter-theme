<?php

namespace App\Lang;

use App\Lang\Lang;

defined('ABSPATH') OR exit;

class WPML extends Lang{

	public function __construct() {}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function getTemplate(){
	
		$html = '';
		
			
		$languages = $this->getLanguages();
		$class = '';
		
		$html .= '<ul class="lang clearfix">';
		
		if(1 < count($languages)){
			
			foreach($languages as $l){
			
			  $class = '';
			   
			  if($l['active']){
				$class = 'active';
			  }
			  
			  $lang_code = ($l['language_code'] == 'el') ? 'gr' : $l['language_code'];
			  
			  $html .= '<li class="' . $class . '"><a href="' . $l['url'] . '">' . $lang_code . '</a></li>';
			  
			}
		}
		  
		$html .= '</ul>';
		$html .= '</div>';

		return $html;
		
	}

	public function getDefaultLanguage() {

		global $sitepress;

		if (isset($sitepress)) {

			return $sitepress->get_default_language();

		} else {

			return substr(get_bloginfo ( 'language' ), 0, 2);

		}
	}

	public function getLanguages(){

		if(function_exists('icl_get_languages'))
			return icl_get_languages('skip_missing=1');

		return array();
	}

	public function getCurrentLang(){

		global $sitepress;

		if (isset($sitepress)) {

			return $sitepress->get_current_language();

		}

		return '';

	}

	public function getLocale($locale){
		global $sitepress;

		if (isset($sitepress)) {

			return $sitepress->get_locale($local);

		}

		return 'en_US';
	}

	public function getCurrentLocale(){
		return $this->getLocale(ICL_LANGUAGE_CODE);
	}

	public function translate($content = ''){
		return $content;
	}

	public function postID($id){
		global $post;
		// make this work for any post type
		if ( isset($post->post_type) ) {
			$post_type = $post->post_type;
		} else {
			$post_type = 'post';
		}

		if(function_exists('icl_object_id')) {
			return icl_object_id($id, $post_type,true);
		} else {
			return $id;
		}
	}

	public function pageID($id){
		
		if(function_exists('icl_object_id')) {
			
			return icl_object_id($id,'page',true, getShortDefaultWPLanguage());
		} else {
			return $id;
		}
	}

	public function categoryID($id){

		if(function_exists('icl_object_id')) {
			return icl_object_id($id,'category',true);
		} else {
			return $id;
		}
	}

	public function categoryIDCustom($id){

		if(function_exists('icl_object_id')) {
			return icl_object_id($id,'category',true, getShortDefaultWPLanguage());
		} else {
			return $id;
		}
	}

	//a dream
	public function taxonomyID($id, $taxonomy){
		if(function_exists('icl_object_id')) {
			return icl_object_id($id, $taxonomy,true);
		} else {
			return $id;
		}
	}

	public function tagID($id){
		if(function_exists('icl_object_id')) {
			return icl_object_id($id,'post_tag',true);
		} else {
			return $id;
		}
	}

	public function originalPostID($id){

		global $post;

		// make this work with custom post types
		if ( isset($post->post_type) ) {
			$post_type = $post->post_type;
		} else {
			$post_type = 'post';
		}

		if(function_exists('icl_object_id')) {
			return icl_object_id($id, $post_type,true, getShortDefaultWPLanguage());
		} else {
			return $id;
		}
	}

	public function originalPostIDCustom($post){
		
		if ( isset($post->post_type) ) {
			$post_type = $post->post_type;
		} else {
			$post_type = 'post';
		}
		
		if(function_exists('icl_object_id')) {
			return icl_object_id($post->ID, $post_type,true, getShortDefaultWPLanguage());
		} else {
			return $post->ID;
		}
		
	}

}

?>
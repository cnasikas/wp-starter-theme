<?php

namespace App\Menu;

use Walker_Nav_Menu;

defined('ABSPATH') OR exit;

class Menu{

	protected static $instance = null;

	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		
		$this->register();

	}

	public function setActions(){

		
	}

	public function register(){
		register_nav_menu( 'primary', 'Header Menu' );
	}

	public function getMenuTemplate($args = array()){

		$defaults = array(
			'theme_location'  => 'main_menu',
            'container' => false,
			'menu_class' => 'main-menu',
            'depth' => 0,
            'echo' => false,
        );

		$args = wp_parse_args($args, $defaults);

		if(!has_nav_menu($args['theme_location']))
			return '';

		$menu = wp_nav_menu($args);

    	return $menu;
	}

	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

class MenuWalker extends Walker_Nav_Menu {

    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) {
            $element->classes[] = 'header-menu-parent'; //enter any classname you like here!
        }
        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
	    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';


		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
		        if ( ! empty( $value ) ) {
		                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
		                $attributes .= ' ' . $attr . '="' . $value . '"';
		        }
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;


		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

?>
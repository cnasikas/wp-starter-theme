<?php

namespace App\Shortcodes;

defined('ABSPATH') OR exit;

class Shortcodes{

	protected static $instance = null;

	public function __construct() {
		//self::$autoLoader = new App_AutoLoader();
	}

	public function init(){
		
		$this->set();
		$this->setActions();
		$this->setFilters();

	}
	
	public static function getInstance() {

		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function setActions(){
		//add_action( 'admin_print_footer_scripts', array($this, 'setQuicktags') );
	}

	private function setFilters(){
		//add_filter('the_content', array($this, 'clean'));
	}
	
	private function set(){
		//add_shortcode('my_shortcode', array($this, 'myShortcode'));
	}
	
	public function setQuicktags() {
		/*
		if ( wp_script_is( 'quicktags' ) ) {
		?>
		<script type="text/javascript">
		QTags.addButton( 'my_shortcode', 'my_shortcode', '[my_shortcode]', '[/my_shortcode]' );
		</script>
		<?php
		}
		*/

	}

	public function myShortcode($atts, $content = null){
		return $content;
	}
	
	public function clean($content) {
 
		// array of custom shortcodes requiring the fix 
		$block = join("|",array("my_shortcode"));
	 
		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
			
		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
	 
		return $rep;
 
	}
}

?>
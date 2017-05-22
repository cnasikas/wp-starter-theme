<?php

namespace App\Trackbacks;

defined('ABSPATH') OR exit;

/* https://github.com/roots/soil */

class Trackbacks{

  protected static $instance = null;

  public function __construct() {
    //self::$autoLoader = new RLP_AutoLoader();
  }

  public function init(){
    
    $this->setActions();
    //$this->setFilters();
  }

  public function setActions(){
    add_filter('xmlrpc_methods', array($this, 'filter_xmlrpc_method'), 10, 1);
    add_filter('xmlrpc_methods', array($this, 'filter_xmlrpc_method'), 10, 1);
    add_filter('wp_headers', array($this, 'filter_headers'), 10, 1);
    add_filter('rewrite_rules_array', array($this, 'filter_rewrites'));
    add_filter('bloginfo_url', array($this, 'kill_pingback_url'), 10, 2);
    add_action('xmlrpc_call', array($this, 'kill_xmlrpc'));

  }

  /**
   * Disable pingback XMLRPC method
   */

  public function filter_xmlrpc_method($methods) {
    unset($methods['pingback.ping']);
    return $methods;
  }
  /**
   * Remove pingback header
   */
  public function filter_headers($headers) {
    if (isset($headers['X-Pingback'])) {
      unset($headers['X-Pingback']);
    }
    return $headers;
  }

  /**
   * Kill trackback rewrite rule
   */
  public function filter_rewrites($rules) {
    foreach ($rules as $rule => $rewrite) {
      if (preg_match('/trackback\/\?\$$/i', $rule)) {
        unset($rules[$rule]);
      }
    }
    return $rules;
  }

  /**
   * Kill bloginfo('pingback_url')
   */
  public function kill_pingback_url($output, $show) {
    if ($show === 'pingback_url') {
      $output = '';
    }
    return $output;
  }

  /**
   * Disable XMLRPC call
   */
  public function kill_xmlrpc($action) {
    if ($action === 'pingback.ping') {
      wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
    }
  }

  public static function getInstance() {

    if (null == self::$instance) {
      self::$instance = new self;
    }

    return self::$instance;
  }
}

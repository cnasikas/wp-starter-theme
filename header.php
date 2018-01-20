<?php

use App\Menu\Menu;

defined('ABSPATH') OR exit;

$menu = new Menu();

?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="<?php echo home_url(); ?>" />
		<meta name="keywords" content="">
		<meta name="classification" content="">
		<meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="msapplication-tap-highlight" content="no" />
		<link rel="icon" href="<?php echo APP_IMG_URL; ?>favicon-32x32.png" sizes="32x32" />
        <link rel="icon" href="<?php echo APP_IMG_URL; ?>favicon-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="<?php echo APP_IMG_URL; ?>favicon-192x192.png" />
        <meta name="msapplication-TileImage" content="<?php echo APP_IMG_URL; ?>favicon-192x192.png" />
        <meta name="msapplication-TileColor" content="#FFFFFF">
		<?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
            <!--[if lt IE 9]>
                <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser.</a></p>
            <![endif]-->
        <header class="banner">
          <div class="container">
            <nav class="nav-primary">
              <?php echo $menu->getMenuTemplate(['theme_location' => 'primary_navigation']); ?>
            </nav>
          </div>
        </header>
        <div class="wrap container" role="document">
            <div class="content row">
                <main class="main">

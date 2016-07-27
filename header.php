<?php

use App\Lang\LangManager;

defined('ABSPATH') OR exit;

$langManager = LangManager::getInstance();

?>
<!DOCTYPE html>
<html class="no-js" lang="<?php echo $langManager->getCurrentLang(); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<base href="<?php echo home_url(); ?>" />
		<meta name="keywords" content="">
		<meta name="classification" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="msapplication-tap-highlight" content="no" />
		<link rel="apple-touch-icon" href="<?php echo APP_IMG_URL; ?>apple-touch-icon.png">
        <link rel="icon" href="<?php echo APP_IMG_URL; ?>favicon.png">
        <!--[if IE]>
            <link rel="shortcut icon" href="<?php echo APP_IMG_URL; ?>favicon.ico">
        <![endif]-->
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="<?php echo APP_IMG_URL; ?>win8-tile-icon.png">
        <title><?php wp_title(''); ?></title>
		<?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser.</a></p>
    <![endif]-->
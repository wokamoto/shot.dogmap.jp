<?php
wp_deregister_script('jquery');
wp_enqueue_script(
  'jquery',
  'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
  array(),
  '1.7.1');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title><?php bloginfo('name'); ?><?php wp_title('&raquo;', true, 'left'); ?> </title>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<!--
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="alternate stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" title="original" />
-->
<?php wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head> 
<body <?php body_class(); ?>>
<div id="wrap">
<div id="header"><h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1></div>
<div id="content">
<div id="mainNav">
<div class="menu">
<ul>
<li class="page_item"><a href="<?php echo get_option('home'); ?>/">Home</a></li>
<li class="page_item"><?php pb_random_post("Random"); ?></li>
<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
<?php if (false) { ?>
<li class="page_item"><a href="<?php bloginfo('rss2_url'); ?>">RSS</a></li>
<?php } ?>
</ul>
</div>
</div>

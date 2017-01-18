<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/Blog">

<div id="page" class="site">

	<?php get_template_part( 'menu' ); // Loads the menu.php template file. ?>

	<header id="masthead" class="site-header" itemscope itemtype="http://schema.org/WPHeader">
		<div class="container">

			<div class="page-header">
				<?php satu_page_title(); ?>
			</div>

		</div>
	</header>

	<div id="content" class="site-content">
		<div class="container">

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<title><?php the_title(); ?> | <?php bloginfo('name') ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	

<?php
wp_nav_menu([
    'theme_location' => 'primary',
    'container'      => false,
    'menu_class'     => 'navbar',
]);
?> 
<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package thrive-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php thrive_html_class(); ?>>
	<head>
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="yandex-verification" content="079ad3c653c7c146">
		<meta name="google-site-verification" content="qru4JAh1lV7MfZ-yILC_Eh-rQX_3hzYxbE2fAWYsmyc">
		<meta
			http-equiv="Content-Security-Policy"
			content="
				base-uri 'self';
				default-src 'none';
				connect-src 'self';
				font-src 'self' fonts.googleapis.com;
				img-src 'self';
				script-src 'self' mc.yandex.ru www.googletagmanager.com;
				style-src 'self' 'unsafe-inline';
			"
		>
		<?php echo TemplateMain::wp_head(); ?>
		<?php // wp_head(); ?>
		<?php thrive_amp_permalink(); ?>
		<!-- Legal Header -->
	</head>
	<body <?php body_class( '' ); ?>>
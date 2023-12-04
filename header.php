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
		<meta http-equiv="Content-Security-Policy" content="default-src 'none'; script-src 'self'; connect-src 'self'; img-src 'self' 'unsafe-inline'; style-src 'self';base-uri 'self';form-action 'self';">
		<?php echo TemplateMain::wp_head(); ?>
		<?php // wp_head(); ?>
		<?php thrive_amp_permalink(); ?>
		<!-- Legal Header -->
	</head>
	<body <?php body_class( '' ); ?>>
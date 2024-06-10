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
<html <?php WPMLMain::language_attributes(); ?>>
	<head> 
		<!-- manual start -->
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="yandex-verification" content="079ad3c653c7c146">
		<meta name="google-site-verification" content="qru4JAh1lV7MfZ-yILC_Eh-rQX_3hzYxbE2fAWYsmyc">
		<!-- manual end -->
		<!-- Yoast SEO manual start -->
		<title><?php echo YoastMain::get_seo_title() ?></title>
		<!-- Yoast SEO manual end -->
		<!-- Multisite Hreflang start -->
		<?php echo MultisiteHreflang::prepare_hreflang(); ?>
		<!-- Multisite Hreflang end -->
		<!-- Template start -->
		<?php echo TemplateMain::wp_head(); ?>
		<!-- Template end -->
		<!-- Legal Header -->
	</head>
	<body <?php body_class( '' ); ?>>
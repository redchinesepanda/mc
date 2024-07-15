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
		<meta name="google-site-verification" content="2dAywc7Sx2HoaFUblkGSpagh3bqZc4-BBhS6tQ2WB40" />
		<meta name="google-site-verification" content="5DLHAOxxRfrKYK3wIUaq0xciDnh6pb9Lv9MJQLhAV2E" />
		<meta name="google-site-verification" content="KmZVf5Emmz8s9HLvmrqcExlPZwHfYZrdAF0KMD1D2RY" />
		<meta name="google-site-verification" content="CrvtIqKDtaSvdPanDaB0sgmPewuoJIqFrZ5QDPhostw" />
		<meta name="google-site-verification" content="fcqNvu0qA7WE-eyxfNul5kC9y_c1lWQvGzDc5b06uQg" />
		<meta name="google-site-verification" content="ENyrRmbmfl3ahc_MEpiV_hGL1RaiTnppypL6xaxk2_c" />
		<meta name="google-site-verification" content="mEkrJzr2kWNt0bwY4KBe-esDddNfY6LHIHoQwqgXUAA" />
		<meta name="google-site-verification" content="cHXNqzAYzXW9xQcJ_3XkMxaOlOY2RjHWtYOzqq7-mX0" />
		<meta name="google-site-verification" content="uL_MOpGHjVJdTC0wYE5IpCP_DVbLdMZNH9QnAjaOdes" />
		<meta name="google-site-verification" content="xsV_rhcHpVkCE0BOHIGgCEeHPDJ2yBVtlNkOBjaSpxU" />
		<meta name="google-site-verification" content="Y2Opq8gGQS9XXahYuxOsrMaQ3UoJTQFjarZttw-zaTs" />
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
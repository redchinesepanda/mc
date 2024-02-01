
<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-theme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

?>

<section class="legal-section-footer">
	<?php echo BaseFooter::render_footer(); ?>

	<?php echo OopsMain::render(); ?>

	<?php echo OopsCookie::render(); ?>

	<?php echo OopsAge::render(); ?>
</section>

<?php

// global $wp_filter;

// LegalDebug::debug( [
// 	$wp_filter['wp_footer'],
// ] )

?>

<?php wp_footer(); ?>

</body>
</html>

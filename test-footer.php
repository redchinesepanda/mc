
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
	<?php echo BaseFooter::render(); ?>

	<?php echo OopsMain::render(); ?>

	<?php echo OopsCookie::render(); ?>

	<?php echo OopsAge::render(); ?>
</section>

<?php //wp_footer(); ?>

</body>
</html>

<?php

/*

Template Name: Single Legal Blog & Attachment
Template Post Type: post

*/

get_header();

?>
<section class="legal-header">
	<?php echo BaseHeader::render(); ?>
</section>
<section class="legal-content">
	<?php echo BonusTemplateSingle::render(); ?>
</section>
<section class="legal-footer">
	<?php echo BaseFooter::render(); ?>
</section>
<?php

get_footer();

?>
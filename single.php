<?php

/*

Template Name: Single Legal Blog & Attachment
Template Post Type: post

*/

get_header();

?>
<section class="legal-section-header">
	<?php echo BaseHeader::render(); ?>
</section>
<section class="legal-section-content">
	<?php echo BonusTemplateSingle::render(); ?>
</section>
<section class="legal-section-author">
	<?php echo ReviewAuthor::render(); ?>
</section>
<section id="theme-bottom-section" class="legal-section-footer">
	<?php echo BaseFooter::render(); ?>
</section>
<?php

get_footer();

?>
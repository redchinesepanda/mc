<?php

get_header();

?>
<section class="legal-section-header">
	<?php echo BaseHeader::render(); ?>
</section>
<section class="legal-section-breadcrumbs">
	<?php echo LegalBreadcrumbsMain::render(); ?>
</section>
<section class="legal-section-anchors">
	<?php echo ReviewAnchors::render(); ?>
</section>
<section class="legal-section-group">
	<?php echo ReviewGroup::render(); ?>
</section>
<section class="legal-section-content">
	<?php echo ReviewTemplatePage::render(); ?>
</section>
<section id="theme-bottom-section" class="legal-section-author">
	<?php echo ReviewAuthor::render(); ?>
</section>
<section class="legal-section-footer">
	<?php echo BaseFooter::render(); ?>

	<?php echo OopsMain::render(); ?>

	<?php echo OopsCookie::render(); ?>

	<?php echo OopsAge::render(); ?>
</section>
<?php

get_footer();

?>
<!-- Legal Bonus -->
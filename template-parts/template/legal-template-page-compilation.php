<?php

get_header();

?>
<section class="legal-section-header">
	<?php echo BaseHeader::render(); ?>
</section>
<section class="legal-section-breadcrumbs">
	<?php echo LegalBreadcrumbsMain::render(); ?>
</section>
<section class="legal-section-about">
	<?php echo CompilationAbout::render(); ?>
</section>
<?php echo CompilationPage::render(); ?>
<section id="theme-bottom-section" class="legal-section-author">
	<?php echo ReviewAuthor::render(); ?>
</section>
<?php

get_footer();

?>
<!-- MC Page Compilation -->
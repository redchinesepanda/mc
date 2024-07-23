<?php

get_header();

global $wp_query;

LegalDebug::debug( [
	'template' => 'legal-template-notfound.php-1',

	'is_page_template' => is_page_template( '404.php' ),

	'is_404' => is_404(),

	'query_vars' => $wp_query->query_vars,
] );

?>
<section class="legal-section-header">
	<?php echo BaseHeader::render(); ?>
</section>
<section class="legal-section-content">
	<?php echo NotFoundMain::render(); ?>
</section>
<?php

get_footer();

?>
<!-- MC Not Found -->
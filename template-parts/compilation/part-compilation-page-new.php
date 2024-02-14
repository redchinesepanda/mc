<section class="legal-section-group">
	<?php echo ReviewGroup::render(); ?>
</section>
<section class="legal-section-anchors">
	<?php echo ReviewAnchors::render(); ?>
</section>
<section class="legal-section-content">
	<div class="legal-compilation-page">
		<div class="legal-compilation-page-main">
			<?php echo ReviewContent::render(); ?>

			<div id="theme-bottom-section" class="legal-section-author">
				<?php echo ReviewAuthor::render(); ?>
			</div> 
		</div>
		<div class="legal-compilation-page-sidebar"></div>
	</div>
</section>
<section class="legal-section-offers">
	<?php echo ReviewOffers::prepare_offers_bottom(); ?>
</section>
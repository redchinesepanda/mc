<section class="legal-section-content">
	<div class="legal-compilation-page">
		<div class="legal-compilation-page-main">
			<div class="legal-section-group">
				<?php echo ReviewGroup::render(); ?>
			</div>
			<div class="legal-section-anchors">
				<span class="legal-to-top"></span>
				<?php // echo ReviewAnchors::render(); ?>
			</div>

			<?php echo ReviewContent::render(); ?>

			<div id="theme-bottom-section" class="legal-section-author">
				<?php echo ReviewAuthor::render_block(); ?>
			</div>
			<div class="legal-section-offers">
				<?php echo ReviewOffers::prepare_offers_bottom(); ?>
			</div>
		</div>
		<div class="legal-compilation-page-sidebar"></div>
	</div>
</section>
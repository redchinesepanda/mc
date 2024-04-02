<section class="legal-section-review-about-top">
	<?php echo ReviewAbout::render_about(); ?>
</section>
<section class="legal-section-content">
	<div class="legal-review-page">
		<div class="legal-review-page-main">
			<div class="legal-section-group">
				<?php echo ReviewGroup::render(); ?>
			</div>
			<div class="legal-section-anchors">
				<?php echo ReviewAnchors::render_section(); ?>
			</div>

			<?php echo ReviewContent::render(); ?>

			<div id="theme-bottom-section" class="legal-section-author">
				<?php echo ReviewAuthor::render_block(); ?>
			</div>
		</div>
		<div class="legal-review-page-sidebar">
			<?php echo ReviewAbout::render_bonus(); ?>
		</div>
		<div class="legal-section-offers">
			<?php echo ReviewOffers::prepare_offers_bottom(); ?>
		</div>
	</div>
</section>
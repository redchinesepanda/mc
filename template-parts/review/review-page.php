<section class="legal-section-review-about-top">
	<?php echo ReviewAbout::render_about(); ?>
</section>
<section class="legal-section-anchors">
	<?php echo ReviewAnchors::render(); ?>
</section>
<section class="legal-section-group">
	<?php echo ReviewGroup::render(); ?>
</section>
<section class="legal-section-review-content">
	<div class="legal-bonus-single">
		<div class="legal-bonus-main">
			<?php echo ReviewContent::render(); ?>
		</div>
	</div>
</section>
<section class="legal-section-offers">
	<?php echo ReviewOffers::prepare_offers_bottom(); ?>
</section>
<section class="legal-section-review-about-bottom">
	<?php echo ReviewAbout::render_about_bottom(); ?>
</section>
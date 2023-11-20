<section class="legal-section-review-about">
	<?php echo ReviewAbout::prepare_about(); ?>
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
<section class="legal-section-review-aboyt-footer">
	<?php echo ReviewAbout::render_footer(); ?>
</section>
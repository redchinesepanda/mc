<section class="legal-section-about">
	<?php echo ReviewAnchors::render(); ?>
</section>
<section class="legal-section-anchors">
	<?php echo ReviewAnchors::render(); ?>
</section>
<section class="legal-section-group">
	<?php echo ReviewGroup::render(); ?>
</section>
<section class="legal-section-content">
	<div class="legal-bonus-single">
		<div class="legal-section-anchors">
			<?php echo ReviewAnchors::render(); ?>
		</div>
		<div class="legal-section-group">
			<?php echo ReviewGroup::render(); ?>
		</div>
		<div class="legal-bonus-main">
			<?php echo ReviewContent::render(); ?>
		</div>
	</div>
</section>
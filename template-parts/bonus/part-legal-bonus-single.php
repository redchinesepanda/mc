<div class="legal-bonus-single">
	<?php echo BonusDuration::render(); ?>
	<div class="legal-bonus-main">
		<?php echo BonusSummary::render(); ?>

		<?php echo BonusFeatured::render(); ?>

		<?php echo BonusContent::render(); ?>

		<?php echo BonusCategories::render(); ?>

		<?php echo BonusRelated::render_preview_categories(); ?>

		<?php echo BonusRelated::render_preview_tags(); ?>
	</div>
</div>
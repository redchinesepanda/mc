<div class="legal-bonus-single">
	<?php echo BonusDuration::render(); ?>
	<div class="legal-bonus-main">
		<?php echo BonusSummary::render(); ?>

		<?php echo BonusFeatured::render(); ?>

		<?php echo BonusContent::render(); ?>

		<?php echo BonusCategories::render(); ?>

		<?php echo BonusRelated::render_categories(); ?>
	</div>
	<div class="legal-bonus-sidebar">
		<?php echo BonusRelated::render_tags(); ?>
	</div>
</div>
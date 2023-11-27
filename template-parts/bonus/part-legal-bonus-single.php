<div class="legal-bonus-single">
	<?php echo BonusDuration::render(); ?>

	<?php echo BonusRelated::render_preview_actual(); ?>
	<div class="legal-bonus-main">
		<?php echo BonusSummary::render(); ?>

		<?php echo BonusFeatured::render(); ?>

		<?php echo BonusContent::render(); ?>

		<div class="legal-bonus-button">
			<?php echo BonusAbout::render_button(); ?>
		</div>

		<?php echo BonusCategories::render(); ?>

		<?php echo BonusRelated::render_preview_categories(); ?>

		<?php echo BonusRelated::render_preview_other(); ?>
	</div>
</div>
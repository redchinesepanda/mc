<div class="legal-bonus-about-wrapper">
	<div class="legal-bonus-about">
		<div class="bonus-about-data">
			<h1 class="about-data-title"><?php echo $args[ 'title' ] ?></h1>
			<span class="about-data-description"><?php echo $args[ 'description' ] ?></span>
		</div>
		<div class="bonus-about-action">
			<img class="about-action-logo" src="<?php echo $args[ 'logo' ][ 'src' ] ?>" alt="<?php echo $args[ 'logo' ][ 'alt' ] ?>" width="130">
			<?php echo BonusAbout::render_button(); ?>
		</div>
	</div>
	<div class="legal-bonus-about-overlay1"></div>
	<div class="legal-bonus-about-overlay2"></div>
	<div class="legal-bonus-about-overlay3"></div>
</div>
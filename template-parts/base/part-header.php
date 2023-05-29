<?php if ( !empty( $args ) ) : ?>
	<div class="legal-header-menu">
		<div class="hamburger-menu">
			<input id="toggle-state" type="checkbox" />
			<label class="toggle-button" for="toggle-state"></label>
		</div>
		<?php echo $args; ?>
	</div>
<?php endif; ?>
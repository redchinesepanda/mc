<div class="wrap">
	<h1 id="edit-site">Edit Site: <?php echo $args[ 'title' ]; ?></h1>
	<p class="edit-site-actions">
		<a href="<?php echo $args[ 'href-visit' ]; ?>">Visit</a> | <a href="<?php echo $args[ 'href-dashboard' ]; ?>">Dashboard</a>
	</p>
	<?php network_edit_site_nav( $args[ 'network-edit-site-nav' ] ); ?>
	<form method="post" action="edit.php?action=mcsiteinfoupdate">
		<?php wp_nonce_field( $args[ 'nonce' ] ); ?>
		<input type="hidden" name="id" value="<?php echo $args[ 'id' ]; ?>" />
		<table class="form-table">
			<?php foreach ( $args[ 'options' ] as $option ) : ?>
				<tr>
					<th scope="row"><label for="<?php echo $option[ 'name' ]; ?>"><?php echo $option[ 'label' ]; ?></label></th>
					<td><input name="<?php echo $option[ 'name' ]; ?>" class="regular-text" type="text" id="<?php echo $option[ 'name' ]; ?>" value="<?php echo $option[ 'value' ]; ?>" /></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
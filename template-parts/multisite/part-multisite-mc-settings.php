<div class="wrap">
	<h1 id="edit-site">Edit Site: <?php echo $args[ 'title' ]; ?></h1>
	<p class="edit-site-actions">
		<a href="<?php echo $args[ 'href-visit' ]; ?>">Visit</a> | <a href="<?php echo $args[ 'href-dashboard' ]; ?>">Dashboard</a>
	</p>
	<?php network_edit_site_nav( $args[ 'network-edit-site-nav' ] ); ?>
	<form method="post" action="edit.php?action=mishaupdate">
		<?php wp_nonce_field( 'mc-check' . $args[ 'id' ] ); ?>
		<input type="hidden" name="id" value="<?php echo $args[ 'id' ]; ?>" />
		<table class="form-table">
			<tr>
				<th scope="row"><label for="mc_blog_language">MC Blog Language</label></th>
				<td><input name="mc_blog_language" class="regular-text" type="text" id="mc_blog_language" value="<?php echo $args[ 'mc-blog-language' ]; ?>" /></td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
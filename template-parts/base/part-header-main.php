<?php if ( !empty( $args ) ) : ?>
	<div class="legal-header-wrapper">
		<div class="legal-header">
			<?php echo BaseHeader::render_logo( $args[ 'logo' ] ); ?>
			<div class="legal-header-control">
			</div>
			<?php if ( !empty( $args[ 'items' ] ) ) : ?>
				<div class="legal-menu">
					<?php foreach( $args[ 'items' ] as $item ) : ?>
						<?php echo BaseHeader::render_item( $item ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?> 
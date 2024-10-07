<?php
/**
 * @var $icons
 */
?>
<!-- <div class="mc-icon-picker"> -->
	<h3>Choose icon</h3>

	<a href="#" class="themify-icons-close_lightbox">
		<i class="ti-close"></i>
	</a>

	<div class="themify-icons-lightbox_container">

		<ul class="tf-icons-font-group">
			<?php foreach( $args[ 'categories' ] as $category ) : ?>
				<li>
					<a href="#ti_picker-<?php echo $category['key']; ?>" class="external-link"><?php echo $category['label']; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php foreach( $args[ 'categories' ] as $category ) : ?>
			<section id="ti_picker-<?php echo $category['key']; ?>">
				<h2 class="page-header"><?php echo $category['label']; ?></h2>
				<div class="row">
					<?php foreach( $category['icons'] as $icon_key => $icon_label ) : ?>
						<a href="#" data-icon="<?php echo $icon_key; ?>">
							<i class="<?php echo $icon_key; ?>" aria-hidden="true"></i>
							<?php echo $icon_label; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>

	</div>
	
	<!-- .themify-icons-lightbox_container -->
<!-- </div> -->
<!-- <div id="TI_Picker_overlay"></div> -->
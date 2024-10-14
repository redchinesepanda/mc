<?php
/**
 * @var $icons
 */
?>
<div class="mc-icon-picker">
	<h2>Choose icon</h2>
	<ul class="icon-picker-categories">
		<?php foreach( $args[ 'categories' ] as $category ) : ?>
			<li>
				<a class="picker-categories-item" href="#category-<?php echo $category[ 'key' ]; ?>"><?php echo $category[ 'label' ]; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php foreach( $args[ 'categories' ] as $category ) : ?>
		<section id="category-<?php echo $category[ 'key' ]; ?>" class="picker-category">
			<h3 class="picker-category-header"><?php echo $category[ 'label' ]; ?></h3>
			<div class="picker-category-items">
				<?php foreach( $category[ 'icons' ] as $icon_name ) : ?>
					<a class="category-item" href="#" data-category="<?php echo $category[ 'key' ]; ?>" data-icon="<?php echo $category[ 'prefix' ]; ?>-<?php echo $icon_name; ?>">
						<i class="<?php echo $category[ 'key' ]; ?> <?php echo $category[ 'prefix' ]; ?>-<?php echo $icon_name; ?>" aria-hidden="true"></i>
						<?php echo $icon_name; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endforeach; ?>
</div> 
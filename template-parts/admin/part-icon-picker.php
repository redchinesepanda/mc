<?php
/**
 * @var $icons
 */
?>
<h3>Choose icon</h3>
<ul class="icon-picker-categories">
	<?php foreach( $args[ 'categories' ] as $category ) : ?>
		<li>
			<a class="picker-categories-item" href="#category-<?php echo $category[ 'key' ]; ?>"><?php echo $category[ 'label' ]; ?></a>
		</li>
	<?php endforeach; ?>
</ul>
<?php foreach( $args[ 'categories' ] as $category ) : ?>
	<section id="category-<?php echo $category[ 'key' ]; ?>">
		<h2 class="picker-category-header"><?php echo $category[ 'label' ]; ?></h2>
		<div class="picker-category-items">
			<?php foreach( $category[ 'icons' ] as $icon_name ) : ?>
				<a href="#" data-icon="<?php echo $icon_name; ?>">
					<i class="<?php echo $icon_name; ?>" aria-hidden="true"></i>
					<?php echo $icon_name; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
<?php endforeach; ?>
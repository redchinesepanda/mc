<div class="container__svg-before-text-block page404">
	<div class="svg-before-text-block">
		<div class="svg-oops-smile"></div>
		<h1 class="block-groups_title"><?php echo $args[ 'title' ]; ?></h1>
	</div>
	<p><?php echo $args[ 'description' ]; ?></p>
	<div class="menu-avaible-404">
		<?php foreach( $args['languages'] as $lang ) : ?>
			<a class='lang-avaible lang-item' href="<?php echo $lang['href']; ?>" target="_blank">
				<div class="lang-image locale-<?php echo $lang['id']; ?>"></div>
				<div class="lang-title">
					<?php echo $lang['title']; ?>
				</div>
			</a>
		<?php endforeach; ?>
		<a class='lang-current lang-item' href="#" target="_blank">
			<div class="lang-image locale-<?php echo $args['active']['id']; ?>"></div>
				<div class="lang-title">
					<?php echo $args['active']['title']; ?>
				</div>
			</div>
		</a>
	</div>
</div>

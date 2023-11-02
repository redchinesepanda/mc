<?php

LegalDebug::debug( [
	'load_template' => 'part-legal-forecast-preview.php',

	'args' => $args,
] );

?>
<div class="legal-forecast-list">
	<?php foreach( $args[ 'items' ] as $item ) : ?>
		<div class="legal-forecast-block">
			<a href="<?php echo $item[ 'href' ] ?>" class="block-prewiew chimaev-kosta">
				<span><?php echo $item[ 'date' ] ?></span>
			</a>
			<a href="<?php echo $item[ 'href' ] ?>" class="legal-forecast-block-title underline"><?php echo $item[ 'title' ] ?></a>
		</div>
	<?php endforeach; ?>

	<div class="legal-forecast-block">
		<a href="https://match.center/kz/chimaev-kosta/" class="block-prewiew chimaev-kosta">
			<p>21 октября 2023</p>
		</a>
		<a href="https://match.center/kz/chimaev-kosta/" class="legal-forecast-block-title underline">Чимаев – Коста: прогнозы и коэффициенты</a>
	</div>

	<div class="legal-forecast-block">
		<a href="https://match.center/kz/tips/mma/mahachev-oliveira-2-boj/" class="block-prewiew mahachev-oliveira">
			<p>21 октября 2023</p>
		</a>
		<a href="https://match.center/kz/tips/mma/mahachev-oliveira-2-boj/" class="legal-forecast-block-title underline">Махачев – Оливейра 2: коэффициенты и ставки на реванш</a>
	</div>

	<div class="legal-forecast-block">
		<a href="https://match.center/kz/chimaev-kosta/" class="block-prewiew chimaev-kosta">
			<p>21 октября 2023</p>
		</a>
		<a href="https://match.center/kz/chimaev-kosta/" class="legal-forecast-block-title underline">Чимаев – Коста: прогнозы и коэффициенты</a>
	</div>

	<div class="legal-forecast-block">
		<a href="https://match.center/kz/tips/mma/mahachev-oliveira-2-boj/" class="block-prewiew mahachev-oliveira">
			<p>21 октября 2023</p>
		</a>
		<a href="https://match.center/kz/tips/mma/mahachev-oliveira-2-boj/" class="legal-forecast-block-title underline">Махачев – Оливейра 2: коэффициенты и ставки на реванш</a>
	</div>
</div>
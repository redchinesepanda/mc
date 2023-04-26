<?php

class ReviewBonus
{
	public static function register()
	{
		$handler = new self();

		add_filter( 'the_content', [ $handler, 'get' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_bonus' ] );
	}

	const BONUS_CLASS = [
		'bonus' => 'legal-bonus',

		'title' => 'legal-bonus-title',

		'description' => 'legal-bonus-description',

		'content' => 'legal-bonus-content',
	];

	public static function get( $content )
	{
		$dom = new DomDocument();

		$dom->load( $content );

		$xpath = new DomXPath( $dom );

		// $productRaw = $data->getElementsByTagName('li');

		// $productPrice = $productRaw[1]->getElementsByTagName('li');

		// $productPrice = $xpath->query('.//li[contains(@class, \'itemtwo\')]', $productRaw[1])->item(1)->nodeValue;
		
		$expression = './/li[contains(@class, \'' . self::BONUS_CLASS[ 'bonus' ] . '\')]';

		$nodes = $xpath->query( $expression );

		// $nodes = $xpath->query( '//*[contains(@class=' . self::BONUS_CLASS[ 'bonus' ] . ')]' );

		LegalDebug::debug( [
			'class' => self::BONUS_CLASS[ 'bonus' ],

			'$expression' => $expression,

			'$nodes' => $nodes,
		] );

		return $content;
	}

	public static function style_formats_bonus( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Bonus',

				'items' => [
					[
						'title' => 'Bonus Title',
						
						'selector' => 'p',

						'classes' => self::BONUS_CLASS[ 'bonus' ] . ' ' . self::BONUS_CLASS[ 'title' ],
					],

					[
						'title' => 'Bonus Description',
						
						'selector' => 'p',

						'classes' => self::BONUS_CLASS[ 'bonus' ] . ' ' . self::BONUS_CLASS[ 'description' ],
					],

					[
						'title' => 'Bonus Content',
						
						'selector' => 'p,ul,ol,img',

						'classes' => self::BONUS_CLASS[ 'bonus' ] . ' ' . self::BONUS_CLASS[ 'content' ],
					],
				],
			],
		] );
	}
}

?>
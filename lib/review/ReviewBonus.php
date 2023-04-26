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
		// $dom = new DOMDocument();

		// $dom->loadHTML( $content, LIBXML_NOERROR );

		// $xpath = new DOMXPath( $dom );

		// $expression = './/*[contains(@class, \'legal-bonus\')]';

		// $nodes = $xpath->query( $expression );

		// LegalDebug::debug( [
		// 	'class' => self::BONUS_CLASS[ 'bonus' ],

		// 	'$expression' => $expression,

		// 	'$nodes' => $nodes,
		// ] );

		// if ( $nodes->length == 0 ) {
		// 	return $content;
		// }

		// foreach ( $nodes as $node ) {
		// 	$bonus = $dom->createElement( 'div' );
	
		// 	$bonus->setAttribute( 'class', self::BONUS_CLASS[ 'bonus' ] );
	
		// 	$template = self::render( [] );
	
		// 	self::appendHTML( $bonus, $template );
	
		// 	$node->parentNode->replaceChild( $bonus, $node );

		// 	// $node->parentNode->removeChild( $node );
		// }

		return $content;

		// return $dom->saveHTML();
	}

	public static function appendHTML(DOMNode $parent, $source) {
		$tmpDoc = new DOMDocument();

		$tmpDoc->loadHTML( $source );

		foreach ( $tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node ) {
			$node = $parent->ownerDocument->importNode($node, true);

			$parent->appendChild( $node );
		}
	}

	const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-bonus.php';

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE, false, $args );

        $output = ob_get_clean();

        return $output;
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
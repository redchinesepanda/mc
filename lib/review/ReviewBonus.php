<?php

class ReviewBonus
{
	public static function register()
	{
		$handler = new self();

		add_filter( 'the_content', [ $handler, 'get_content' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_bonus' ] );
	}

	const BONUS_CLASS = [
		'bonus' => 'legal-bonus',

		'billet' => 'legal-billet',

		'title' => 'legal-bonus-title',

		'description' => 'legal-bonus-description',

		'content' => 'legal-bonus-content',
	];

	public static function get_content( $content )
	{
		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		$xpath = new DOMXPath( $dom );

		$expression = './/*[contains(@class, \'legal-bonus\')]';

		$nodes = $xpath->query( $expression );

		// LegalDebug::debug( [
		// 	'class' => self::BONUS_CLASS[ 'bonus' ],

		// 	'$expression' => $expression,

		// 	'$nodes' => $nodes,
		// ] );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		$bonus = null;

		$replace = null;

		$last = $nodes->length - 1;

		foreach ( $nodes as $id => $node ) {
			$class = $node->getAttribute( 'class' );

			$permission_title = ( strpos( $class, self::BONUS_CLASS[ 'title' ] ) !== false );

			$permission_description = ( strpos( $class, self::BONUS_CLASS[ 'description' ] ) !== false );

			$permission_content = ( strpos( $class, self::BONUS_CLASS[ 'content' ] ) !== false );

			$permission_last = ( $id == $last );

			if ( !empty( $bonus ) && ( $permission_title || $permission_last ) ) {
				$template = self::render( $args );
		
				self::appendHTML( $bonus, $template );

				$node->parentNode->replaceChild( $bonus, $replace );
			}

			if ( $permission_title ) {

				$bonus = $dom->createElement( 'div' );

				$bonus->setAttribute( 'class', self::check( $class ) );

				$args = [];

				$args[ 'title' ] = $node->nodeValue;

				$args[ 'class' ] = $class;

				$replace = $node;
			}

			if ( $permission_description ) {
				$args[ 'description' ] = $node->nodeValue;
			}

			if ( $permission_content ) {
				$args[ 'content' ][] = $node->nodeValue;
			}

			if ( $permission_description || $permission_content ) {
				$node->parentNode->removeChild( $node );
			}
		}

		// return $content;

		return $dom->saveHTML();
	}

	public static function appendHTML(DOMNode $parent, $source) {
		$tmpDoc = new DOMDocument();

		// LegalDebug::debug( [
		// 	'$source' => $source,
		// ] );

		$tmpDoc->loadHTML( $source, LIBXML_NOERROR );

		foreach ( $tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node ) {
			$node = $parent->ownerDocument->importNode($node, true);

			$parent->appendChild( $node );
		}
	}

	public static function check( $class )
	{
		$result = self::BONUS_CLASS[ 'bonus' ];

		if ( strpos( $class, self::BONUS_CLASS[ 'billet' ] ) !== false ) {
			$result = self::BONUS_CLASS[ 'billet' ];
		}

		return $result;
	}

	public static function get( $args )
	{
		$class = self::check( $args[ 'class' ] );

		$args[ 'src' ] = '';

		$args[ 'review' ] = [
			'href' => '',

			'text' => '',
		];
		$args[ 'get' ] = [
			'href' => '',

			'text' => '',
		];

		return $args;
	}

	const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-bonus.php';

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get( $args ) );

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
						'title' => 'Billet Title',
						
						'selector' => 'p',

						'classes' => self::BONUS_CLASS[ 'billet' ] . ' ' . self::BONUS_CLASS[ 'title' ],
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
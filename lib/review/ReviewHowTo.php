<?php

class ReviewHowTo
{
	public static function register()
    {
        $handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_howto' ] );
    }

	const CSS_CLASS = [
		'base' => 'legal-howto',

        'title' => 'legal-howto-title',

        'content' => 'legal-howto-content',
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		return $xpath->query( './/*[contains(@class, \'' . self::CSS_CLASS[ 'base' ] . '\')]' );
	}

	public static function parse ( $nodes )
	{
		// LegalDebug::debug( [
		// 	'function' => 'parse',

		// 	'$nodes' => count( $nodes ),
		// ] );

		$items = [];

		$item = [];

		foreach ( $nodes as $id => $node ) {
			if ( $node->nodeType === XML_TEXT_NODE ) {
				LegalDebug::debug( [
					'function' => 'parse',

					'$node->nodeType' => $node->nodeType,
					
					'nodeType' => 'DOMText',
				] );

				// $item[ 'text' ] = ToolEncode::encode( $node->textContent );
			} else {
				// $children = $node->getElementsByTagName( 'li' );
				
				// if ( $children->length != 0 ) {
				// 	$item[ 'items' ] = self::parse( $children );
				// }

				LegalDebug::debug( [
					'function' => 'parse',

					'$node->nodeType' => $node->nodeType,
					
					'nodeType' => 'Not DOMText',
				] );
			}

			// LegalDebug::debug( [
			// 	'function' => 'parse',

			// 	'$id' => $id,
	
			// 	'textContent' => ToolEncode::encode( $node->textContent ),
			// ] );

			// // $children = $node->getElementsByTagName( 'li' );

			// if ( $node->hasChildNodes() ) {
			// // if ( $children->length != 0 ) {
			// 	$item[ 'items' ] = self::parse( $node->childNodes );
				
			// 	// $item[ 'items' ] = self::parse( $children );
			// }

			// if ( !empty( $node->textContent ) ) {
			// 	// $item[ 'text' ] = ToolEncode::encode( $node->textContent );

			// 	// foreach ( $node->childNodes as $child ) {
			// 	// 	if ( $child->nodeType === XML_TEXT_NODE ) {
			// 	// 		$item[ 'text' ] = ToolEncode::encode( $node->textContent );
			// 	// 	}
			// 	// }
			// }

			if ( !empty( $item ) ) {
				$items[] = $item;

				$item = [];
			}
		}

		return $items;
	}

	public static function get_schema_data()
	{
        if ( !ReviewMain::is_front() ) {
			return [];
		}

        $post = get_post();

        if ( empty( $post ) ) {
            return [];
        }

		$dom = LegalDOM::get_dom( $post->post_content );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return [];
		}

		$items = [];

		$item = null;

		$index = 1;

		$last = $nodes->length - 1;

		foreach ( $nodes as $id => $node ) {
			// LegalDebug::debug( [
			// 	'function' => 'get_schema_data',

			// 	'$id' => $id,

			// 	'$node' => ToolEncode::encode( $node->textContent ),
			// ] );

            $class = explode( ' ', $node->getAttribute( 'class' ) );

			$permission_title = ( in_array( self::CSS_CLASS[ 'title' ], $class ) );

			$permission_content = ( in_array( self::CSS_CLASS[ 'content' ], $class ) );

			$permission_last = ( $id == $last );			

			// if ( $node->hasChildNodes() ) {
			// 	$item[ 'itemListElement' ] = self::parse( $node->childNodes );
			// } else {
			// 	$item[ 'itemListElement' ][] = [
			// 		'@type' => 'HowToDirection',

			// 		'position' => $id,

			// 		'text' => ToolEncode::encode( $node->textContent ),
			// 	];
			// }

			if ( !empty( $item ) && $permission_content ) {
                $node->removeAttribute( 'class' );

                // LegalDOM::clean( $node );

                // $item[ 'acceptedAnswer' ][ 'text' ] .= ToolEncode::encode( $dom->saveHTML( $node ) );

				// $item[ 'itemListElement' ] = self::parse( $node->childNodes );
				
				$item[ 'itemListElement' ] = self::parse( $node->getElementsByTagName( 'li' ) );
			}

			if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
                $items[] = $item;

				$index++;

                $item = null;
			}

			if ( $permission_title ) {
				$item = [
					'@type' => 'HowToSection',
	
					'name' => ToolEncode::encode( $node->textContent ),
	
					'position' => $index,
	
					'itemListElement' => [],
				];

				// LegalDebug::debug( [
				// 	'function' => 'get_schema_data',
	
				// 	'$item' => $item,
				// ] );
			}
		}

		return $items;
	}

	public static function schema()
    {
		$items = self::get_schema_data();

		LegalDebug::debug( [
			'function' => 'schema',

			'$items' => $items,
		] );

        return [
			"@context" => "https://schema.org",

			"@type" => "HowTo",
			
			"name" => "How to claim the Betfred new customer bonus:",

			"step" => [
				[
					"@type" => "HowToSection",
					"name" => "Preparation",
					"position" => "1",
					"itemListElement" => [
						[
							"@type" => "HowToStep",
							"position" => "1",
							"itemListElement" => [
								[
									"@type" => "HowToDirection",
									"position" => "1",
									"text" => "Before placing your first bet, make a minimum deposit of £10 within 7 days of registering, using a debit card. Note: payment restrictions apply. "
								],
								[
									"@type" => "HowToDirection",
									"position" => "2",
									"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pulvinar nibh id nibh molestie, scelerisque interdum metus venenatis."
								],
								[
									"@type" => "HowToDirection",
									"position" => "3",
									"text" => "Nam pellentesque eu nisl id congue."
								],
								[
									"@type" => "HowToDirection",
									"position" => "4",
									"text" => "Maecenas in vulputate ipsum.",
								],
							],
						],
						[
							"@type" => "HowToStep",
							"position" => "2",
							"itemListElement" => [
								[
									"@type" => "HowToDirection",
									"position" => "1",
									"text" => "Place your first bet. The first bet must be £10 or more on any qualifying sportsbook markets at odds of evens or greater.",
								],
							],
						],
					]
				],
			],

			"totalTime" => "P2D",
        ];
    }

	public static function style_formats_howto( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'HowTo Schema.org',

				'items' => [
					[
						'title' => 'HowTo Title',
						
						'selector' => 'p',

						'classes' => self::CSS_CLASS[ 'base' ] . ' ' . self::CSS_CLASS[ 'title' ],
					],

					[
						'title' => 'HowTo Content',
						
						'selector' => 'ul,ol',

						'classes' => self::CSS_CLASS[ 'base' ] . ' ' . self::CSS_CLASS[ 'content' ],
					],
				],
			],
		] );
	}
}

?>
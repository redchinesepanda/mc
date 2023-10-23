<?php

class ReviewHowTo
{
	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_howto' ] );
	}

	public static function register()
    {
        // $handler = new self();
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
		$items = [];

		$item = [];

		foreach ( $nodes as $id => $node ) {
			if ( $node->hasChildNodes() ) {

				// $item[ 'text' ] = ToolEncode::encode( $node->childNodes->item( 0 )->textContent );
				
				$item[] = ToolEncode::encode( $node->childNodes->item( 0 )->textContent );

				// LegalDebug::debug( [
				// 	'function' => 'parse',
	
				// 	'$node->hasChildNodes()' => $node->hasChildNodes(),

				// 	'text' => $item[ 'text' ],
				// ] );
			}

			$children = $node->getElementsByTagName( 'li' );
			
			if ( $children->length != 0 ) {
				// $item[ 'items' ] = self::parse( $children );
				
				$item = array_merge( $item, self::parse( $children ) );

				// LegalDebug::debug( [
				// 	'function' => 'parse',
	
				// 	'$children->length' => $children->length,

				// 	'items' => $item[ 'items' ],
				// ] );
			}

			if ( !empty( $item ) ) {
				$items[] = $item;

				$item = [];
			}
		}

		return $items;
	}

	public static function get_schema_data()
	{
        if ( !ReviewMain::check() ) {
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
				
				$item[ 'items' ] = self::parse( $node->getElementsByTagName( 'li' ) );
			}

			if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
                $items[] = $item;

				$index++;

                $item = null;
			}

			if ( $permission_title ) {
				// $item = [
				// 	'@type' => 'HowToSection',
	
				// 	'name' => ToolEncode::encode( $node->textContent ),
	
				// 	'position' => $index,
	
				// 	'itemListElement' => [],
				// ];
				
				$item = [
					'name' => ToolEncode::encode( $node->textContent ),
	
					'items' => [],
				];

				// LegalDebug::debug( [
				// 	'function' => 'get_schema_data',
	
				// 	'HowToSection' => ToolEncode::encode( $node->textContent ),
				// ] );
			}
		}

		return $items;
	}

	public static function schema()
    {
		if ( !ReviewMain::check() )
        {
            return [];
        }

		$HowToSections = self::get_schema_data();

		// LegalDebug::debug( [
		// 	'function' => 'schema',

		// 	'$HowToSections' => $HowToSections,
		// ] );

		$steps = [];

		foreach ( $HowToSections as $HowToSectionID => $HowToSection ) {
			$items = [];

			$HowToSteps = $HowToSection[ 'items' ];
			
			foreach ( $HowToSteps as $HowToStepID => $HowToStep ) {
				$directions = [];

				foreach ( $HowToStep as $HowToDirectionID => $HowToDirection ) {
					$directions[] = [
						'@type' => 'HowToDirection',

						'position' => ( $HowToDirectionID + 1 ),

						'text' => $HowToDirection,
					];
				}

				if ( !empty ( $directions ) ) {
					$items[] = [
						'@type' => 'HowToStep',
	
						'position' => ( $HowToStepID + 1 ),
	
						'itemListElement' => $directions,
					];
				}
			}

			if ( !empty ( $items ) ) {
				$steps[] = [
					'@type' => 'HowToSection',
	
					'name' => $HowToSection[ 'name' ],
	
					'position' => ( $HowToSectionID + 1 ),
	
					'itemListElement' => $items,
				];
			}
		}

		if ( empty( $steps ) ) {
			return [];
		}

        return [
			"@context" => "https://schema.org",

			"@type" => "HowTo",
			
			"name" => "How to claim the Betfred new customer bonus:",

			"step" => $steps,

			"totalTime" => "PT5M",
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
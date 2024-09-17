<?php

class ReviewListHowTo
{
	const CLASSES = [
		'default' => 'mc-list-howto',

		'unordered' => 'mc-list-howto-unordered',

        'title' => 'mc-list-howto-title',

        'content' => 'mc-list-howto-content',
	];

	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_howto' ] );
	}

	public static function get_node_classess( $node )
	{
		return explode( ' ', $node->getAttribute( 'class' ) );
	}

	public static function get_permission_title( $node )
	{
		return in_array( self::CLASSES[ 'title' ], self::get_node_classess( $node ) );
	}

	public static function get_permission_content( $node )
	{
		return in_array( self::CLASSES[ 'content' ], self::get_node_classess( $node ) );
	}

	public static function get_permission_last( $node )
	{
		$nextSibling = $node->nextSibling;

		if ( ! empty( $nextSibling ) )
		{
			return in_array( self::CLASSES[ 'default' ], self::get_node_classess( $nextSibling ) );
		}

		return true;
	}

	public static function get_howto_items( $nodes )
	{
		$howto_items = [];

		$howto_item = null;

		$index = 1;

		$last = $nodes->length - 1;

		foreach ( $nodes as $id => $node )
		{
			// LegalDebug::debug( [
			// 	'function' => 'get_schema_data',

			// 	'$id' => $id,

			// 	'$node' => ToolEncode::encode( $node->textContent ),
			// ] );

            // $class = explode( ' ', $node->getAttribute( 'class' ) );

			// $permission_title = (  );

			// $permission_content = ( in_array( self::CLASSES[ 'content' ], $class ) );

			// $permission_last = ( $id == $last );			

			// if ( $node->hasChildNodes() ) {
			// 	$item[ 'itemListElement' ] = self::parse( $node->childNodes );
			// } else {
			// 	$item[ 'itemListElement' ][] = [
			// 		'@type' => 'HowToDirection',

			// 		'position' => $id,

			// 		'text' => ToolEncode::encode( $node->textContent ),
			// 	];
			// }

			if ( self::get_permission_title() )
			{
				// $howto_item[ 'title' ] = ToolEncode::encode( $node->textContent );

				$howto_item[ 'questions' ][] = $howto_item_question;

				$howto_item_question = [];
				
				$howto_item_question[ 'title' ] = ToolEncode::encode( $node->textContent );
			}

			if ( self::get_permission_content() )
			{
                // $howto_item[ 'content' ] = ToolEncode::encode( $node->textContent );
                
				$howto_item_question[ 'content' ] = ToolEncode::encode( $node->textContent );

				// $node->removeAttribute( 'class' );

                // LegalDOM::clean( $node );

                // $item[ 'acceptedAnswer' ][ 'text' ] .= ToolEncode::encode( $dom->saveHTML( $node ) );

				// $item[ 'itemListElement' ] = self::parse( $node->childNodes );
				
				// $item[ 'items' ] = self::parse( $node->getElementsByTagName( 'li' ) );
			}

			if ( self::get_permission_last() )
			{
				$howto_items[] = $howto_item;

				$howto_item = [];

				LegalDOM::appendHTML( $node, self::render( $howto_item ) );
			}

			try
			{
				$node->parentNode->removeChild( $node );
			}
			catch ( DOMException $e )
			{
				LegalDebug::debug( [
					'ReviewListHowTo' => 'get_howto_items-1',

					'node' => substr( $node->textContent, 0, 30 ),

					'message' => $e->getMessage(),
				] );
			}

			// if ( !empty( $item ) && ( $permission_title || $permission_last ) )
			// {
            //     $items[] = $item;

			// 	$index++;

            //     $item = null;
			// }

			// if ( $permission_title )
			// {
			// 	// $item = [
			// 	// 	'@type' => 'HowToSection',
	
			// 	// 	'name' => ToolEncode::encode( $node->textContent ),
	
			// 	// 	'position' => $index,
	
			// 	// 	'itemListElement' => [],
			// 	// ];
				
			// 	$item = [
			// 		'name' => ToolEncode::encode( $node->textContent ),
	
			// 		'items' => [],
			// 	];

			// 	// LegalDebug::debug( [
			// 	// 	'function' => 'get_schema_data',
	
			// 	// 	'HowToSection' => ToolEncode::encode( $node->textContent ),
			// 	// ] );
			// }
		}

		LegalDebug::debug( [
			'ReviewListHowTo' => 'get_howto_items-2',

			'howto_items-count' => count( $howto_items ),

			'howto_items' => $howto_items,
		] );

		return $howto_items;
	}

	public static function get_nodes_howto( $dom )
	{
		return LegalDOM::get_nodes( $dom, '//*[contains(@class, \'' . self::CLASSES[ 'default' ] . '\')]' );
	}

	public static function get_howto()
	{
        if ( ! ReviewMain::check() )
		{
			return [];
		}

        $post = get_post();

        if ( empty( $post ) )
		{
            return [];
        }

		$dom = LegalDOM::get_dom( $post->post_content );

        $nodes = self::get_nodes_howto( $dom );

		if ( $nodes->length == 0 )
		{
			return [];
		}

		return self::get_howto_items( $nodes );
	}

	public static function style_formats_howto( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'HowTo',

				'items' => [
					[
						'title' => 'Список HowTo Заголовок Нумерованый',
						
						'selector' => 'p',

						'classes' => implode( ' ', [
                            self::CLASSES[ 'default' ],
                            
                            self::CLASSES[ 'title' ]
                        ] ),
					],

					[
						'title' => 'Список HowTo Заголовок Маркированный',
						
						'selector' => 'p',

						'classes' => implode( ' ', [
                            self::CLASSES[ 'default' ],
							
                            self::CLASSES[ 'unordered' ],
                            
                            self::CLASSES[ 'title' ],
                        ] ),
					],

					[
						'title' => 'Список HowTo Содержимое',
						
						'selector' => 'p',

						'classes' => implode( ' ', [
                            self::CLASSES[ 'default' ],
                            
                            self::CLASSES[ 'content' ],
                        ] ),
					],
				],
			],
		] );
	}
}

?>
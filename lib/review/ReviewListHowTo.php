<?php

class ReviewListHowTo
{
	const CLASSES = [
		'default' => 'mc-list-howto',

		'unordered' => 'mc-list-howto-unordered',

        'title' => 'mc-list-howto-title',

        'content' => 'mc-list-howto-content',
	];

	public static function check_contains_list_howto()
    {
        return LegalComponents::check_contains( self::CLASSES[ 'default' ] );
    }

    public static function register()
    {
		if ( self::check_contains_list_howto() )
		{
			$handler = new self();
	
			add_filter( 'the_content', [ $handler, 'modify_content' ] );
	
			// add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
		}
    }

	public static function get_node_classess( $node )
	{
		if ( $node->hasAttributes() )
		{
			// LegalDebug::debug( [
			// 	'ReviewHowTo' => 'get_node_classess',

			// 	'class' => $node->getAttribute( 'class' ),
			// ] );

			return explode( ' ', $node->getAttribute( 'class' ) );
		}

		return [];
	}

	public static function check_title( $node )
	{
		return in_array( self::CLASSES[ 'title' ], self::get_node_classess( $node ) );
	}

	public static function check_content( $node )
	{
		return in_array( self::CLASSES[ 'content' ], self::get_node_classess( $node ) );
	}

	public static function check_item_complete( $dom, $node )
	{
		// $nextSibling = $node->nextSibling;
		
		$nextSibling = LegalDOM::get_next_element( $dom, $node );

		// LegalDebug::debug( [
        //     'ReviewListHowTo' => 'get_permission_last-1',

		// 	'nextSibling' => $nextSibling,

		// 	'get_next_element' => LegalDOM::get_next_element( $dom, $node ),

		// 	'textContent' => substr( $nextSibling->textContent, 0, 30 ),
		// ] );

		if ( ! empty( $nextSibling ) )
		{
			// LegalDebug::debug( [
			// 	'ReviewListHowTo' => 'get_permission_last-2',

			// 	'CLASSES' => self::CLASSES[ 'default' ],

			// 	'get_node_classess' => self::get_node_classess( $nextSibling ),
	
			// 	'in_array' => ( ! in_array( self::CLASSES[ 'default' ], self::get_node_classess( $nextSibling ) ) ),
			// ] );

			return ! in_array( self::CLASSES[ 'default' ], self::get_node_classess( $nextSibling ) );
		}

		return true;
	}

	public static function check_question_complete( $dom, $node )
	{
		$nextSibling = LegalDOM::get_next_element( $dom, $node );

		if ( ! empty( $nextSibling ) )
		{
			return in_array( self::CLASSES[ 'title' ], self::get_node_classess( $nextSibling ) );
		}

		return false;
	}

	public static function insertBeforeHTML( $dom, $html, $node )
	{
		$fragment = $dom->createDocumentFragment();
		
		$fragment->appendXML( $html );
		
		$node->insertBefore( $fragment );
	}

	public static function get_howto_items( $dom, $nodes )
	{
		$howto_items = [];

		$howto_item = [];

		$howto_item_question = [];

		foreach ( $nodes as $id => $node )
		{
			// LegalDebug::debug( [
			// 	'ReviewListHowTo' => 'get_howto_items-1',

			// 	// 'node' => $node,

			// 	'textContent' => substr( $node->textContent, 0, 30 ),

			// 	'check_title' => self::check_title( $node ),

			// 	'check_content' => self::check_content( $node ),

			// 	'check_question_complete' => self::check_question_complete( $dom, $node ),

			// 	'check_item_complete' => self::check_item_complete( $dom, $node ),
			// ] );

			if ( self::check_title( $node ) )
			{
				// $howto_item[ 'title' ] = ToolEncode::encode( $node->textContent );

				// if ( ! empty( $howto_item_question ) )
				// {
					// $howto_item[ 'questions' ][] = $howto_item_question;
				// }
				
				$howto_item_question[ 'title' ] = ToolEncode::encode( $node->textContent );
			}

			// LegalDebug::debug( [
			// 	'ReviewListHowTo' => 'get_howto_items-2',

			// 	'howto_item_question' => $howto_item_question,
			// ] );

			if ( self::check_content( $node ) )
			{
                // $howto_item[ 'content' ] = ToolEncode::encode( $node->textContent );
                
				$howto_item_question[ 'content' ] = ToolEncode::encode( $node->textContent );
			}

			// LegalDebug::debug( [
			// 	'ReviewListHowTo' => 'get_howto_items-3',

			// 	'howto_item_question' => $howto_item_question,
			// ] );

			if (
				self::check_question_complete( $dom, $node )

				|| self::check_item_complete( $dom, $node )
			)
			{
				$howto_item[ 'questions' ][] = $howto_item_question;
			}

			if ( self::check_item_complete( $dom, $node ) )
			{
				// $howto_item[ 'questions' ][] = $howto_item_question;

				// $howto_item_question = [];

				$howto_items[] = $howto_item;

				$html = self::render_list_howto( $howto_item );

				LegalDebug::debug( [
					'ReviewListHowTo' => 'get_howto_items-4',

					'html' => $html,
				] );

				self::insertBeforeHTML( $dom, $html, $node ); 

				$howto_item = [];

				// LegalDOM::appendHTML( $node, self::render( $howto_item ) );
			}

			// LegalDebug::debug( [
			// 	'ReviewListHowTo' => 'get_howto_items-4',

			// 	'howto_item_question' => $howto_item_question,
			// ] );

			try
			{
				$node->parentNode->removeChild( $node );
			}
			catch ( DOMException $e )
			{
				LegalDebug::debug( [
					'ReviewListHowTo' => 'get_howto_items-5',

					'node' => substr( $node->textContent, 0, 30 ),

					'message' => $e->getMessage(),
				] );
			}
		}

		// LegalDebug::debug( [
		// 	'ReviewListHowTo' => 'get_howto_items-2',

		// 	'howto_items-count' => count( $howto_items ),

		// 	'howto_items' => $howto_items,
		// ] );

		return $howto_items;
	}

	public static function get_nodes_howto( $dom )
	{
		return LegalDOM::get_nodes( $dom, '//*[contains(@class, \'' . self::CLASSES[ 'default' ] . '\')]' );
	}

	public static function set_howto( $dom )
	{
        $post = get_post();

        if ( empty( $post ) )
		{
            return [];
        }

        $nodes = self::get_nodes_howto( $dom );

		// LegalDebug::debug( [
		// 	'ReviewListHowTo' => 'set_howto-1',

		// 	'nodes' => $nodes,
		// ] );

		if ( $nodes->length == 0 )
		{
			return [];
		}

		self::get_howto_items( $dom, $nodes );
	}

	public static function modify_content( $content )
	{
		if ( ! ReviewMain::check() )
		{
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

		self::set_howto( $dom );

		return $dom->saveHTML( $dom );
	}

	const TEMPLATE = [
        'default' => LegalMain::LEGAL_PATH . '/template-parts/review/review-list-howto.php',
    ];

	public static function render_list_howto( $args )
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'default' ], $args );
    }

	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_howto' ] );
	}

	public static function style_formats_howto( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Список HowTo',

				'items' => [
					[
						'title' => 'Заголовок Нумерованый',
						
						'selector' => 'p',

						'classes' => implode( ' ', [
                            self::CLASSES[ 'default' ],
                            
                            self::CLASSES[ 'title' ]
                        ] ),
					],

					[
						'title' => 'Заголовок Маркированный',
						
						'selector' => 'p',

						'classes' => implode( ' ', [
                            self::CLASSES[ 'default' ],
							
                            self::CLASSES[ 'unordered' ],
                            
                            self::CLASSES[ 'title' ],
                        ] ),
					],

					[
						'title' => 'Содержимое',
						
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
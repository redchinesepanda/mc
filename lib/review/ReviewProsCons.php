<?php

class ReviewProsCons
{
    const CSS = [
        'review-pros-cons' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-pros-cons.css',

			'ver' => '1.0.2',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

    public static function register()
    {
        $handler = new self();

        add_filter( 'the_content', [ $handler, 'get_content' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_pros' ] );
    }

	public static function permission_debug( $permissions )
	{
		$text = [];

		foreach ( $permissions as $key => $value )
		{
			if ( $value )
			{
				$text[ $key ] = 'true';
			} else
			{
				$text[ $key ] = 'false';
			}
		}

		return $text;
	}

	public static function get_node_permission( $node )
	{
		$class = [];

		// $not_empty = false;

		if ( !empty( $node ) )
		{
			$class = explode( ' ', $node->getAttribute( 'class' ) );

			// $not_empty = !empty( $node->textContent );

			// LegalDebug::debug( [
			// 	'textContent' => substr( $node->textContent, 0, 30 ),
	
			// 	'not_empty' => !empty( $node->textContent ) ? 'true' : 'false',
	
			// 	'node' => $node,
			// ] );
		}

		return [
			'title' => in_array( self::CSS_CLASS[ 'title' ], $class ),

			'pros_title' => in_array( self::CSS_CLASS[ 'pros' ], $class ),

			'cons_title' => in_array( self::CSS_CLASS[ 'cons' ], $class ),

			'content' => in_array( self::CSS_CLASS[ 'content' ], $class ),

			// 'not_empty' => $not_empty,
		];
	}

	public static function get_permission_replace( $current, $previous, $next )
	{
		$default = $previous[ 'cons_title' ] && $current[ 'content' ] && $next[ 'pros_title' ];

		$half_pros = $previous[ 'pros_title' ] && $current[ 'content' ] && $next[ 'pros_title' ];

		$half_cons = $previous[ 'cons_title' ] && $current[ 'content' ] && $next[ 'cons_title' ];

		$last = !$next[ 'title' ] && !$next[ 'content' ];

		$case_content = $current[ 'content' ] && $next[ 'content' ];

		// $not_empty = $current[ 'not_empty' ];

		// LegalDebug::debug( [
		// 	'get_permission_replace' => self::permission_debug( [
		// 		'default' => $default,

		// 		'half_pros' => $half_pros,

		// 		'half_cons' => $half_cons,

		// 		'last' => $last,

		// 		'case_content' => $case_content, 
		// 	] ),
		// ] );

		// return ( $default || $half_pros || $half_cons || $last ) && $not_empty; 
		
		return $default || $half_pros || $half_cons || $last || $case_content; 
	}

	const TAG_TITLE = [
		'h3',
	];

	public static function get_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		// $body = $dom->getElementsByTagName( 'body' )->item( 0 );

		// LegalDebug::debug( [
		// 	'class' => 'ReviewProsCons',

		// 	'function' => 'get_content',
			
		// 	'body' => substr( $body->textContent, 0, 30 ),
		// ] );

		$containers = [];

		foreach ( $nodes as $id => $node )
		{
			$permission_node = self::get_node_permission( $node );

			$permission_previous = self::get_node_permission( $nodes->item( $id - 1 ) );

			$permission_next = self::get_node_permission( $nodes->item( $id + 1 ) );

			$permission_replace = self::get_permission_replace( $permission_node, $permission_previous, $permission_next );

			// LegalDebug::debug( [
			// 	'function' => 'get_content',

			// 	'textContent' => substr( $node->textContent, 0, 30 ),

			// 	'permission_replace' => self::permission_debug( [ 'permission_replace' => $permission_replace ] ),

			// 	// 'permission_previous' => self::permission_debug( $permission_previous ),

			// 	// 'permission_node' => self::permission_debug( $permission_node ),

			// 	// 'permission_next' => self::permission_debug( $permission_next ),
			// ] );

			if ( $permission_node[ 'pros_title' ] )
			{
				$type = 'pros';

				$container[ $type ][ 'title' ][ 'text' ] = ToolEncode::encode( $node->textContent );
			}

			if ( $permission_node[ 'cons_title' ] )
			{
				$type = 'cons';

				$container[ $type ][ 'title' ][ 'text' ] = ToolEncode::encode( $node->textContent );
			}

			if ( $permission_node[ 'pros_title' ] || $permission_node[ 'cons_title' ] )
			{
				// LegalDebug::debug( [
				// 	'nodeName' => $node->nodeName,
				// ] );

				$tag = $node->nodeName;

				$container[ $type ][ 'title' ][ 'tag' ] = 'div';

				if ( in_array( $tag, self::TAG_TITLE ) )
				{
					$container[ $type ][ 'title' ][ 'tag' ] = $tag;
				}
			}

			if ( $permission_node[ 'content' ] )
			{
				$node->removeAttribute( 'class' );

				$container[ $type ][ 'content' ] = ToolEncode::encode( $dom->saveHTML( $node ) );
			}

			if ( $permission_replace )
			{
				$containers[] = $container;

				// LegalDebug::debug( [
				// 	'container' => $container,
				// ] );

				$element = $dom->createElement( 'div' );

        		$element->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );

				foreach ( $container as $type => $args )
				{
					$item = $dom->createElement( 'div' );

					$item_class = $type == 'pros' ? self::CSS_CLASS[ 'pros' ] : self::CSS_CLASS[ 'cons' ];
					
					$item->setAttribute( 'class', self::CSS_CLASS[ 'pros-item' ] . ' ' . $item_class );

					LegalDOM::appendHTML( $item, self::render( $args ) );

					$element->appendChild( $item );
				}

				try
				{
					// $body->replaceChild( $element, $node );
					
					$node->parentNode->replaceChild( $element, $node );
					
					// $dom->replaceChild( $element, $node );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'class' => 'ReviewProsCons',

						'function' => 'get_content,replaceChild',

						'element' => substr( $element->textContent, 0, 30 ),

						'node' => substr( $node->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}

				$container = [];
			}
			else
			{
				try
				{
					// $body->removeChild( $node );
					
					$node->parentNode->removeChild( $node );
					
					// $dom->removeChild( $node );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'class' => 'ReviewProsCons',

						'function' => 'get_content,removeChild',

						'node' => substr( $node->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}
			}
		}

		// LegalDebug::debug( [
		// 	'containers' => $containers,
		// ] );

		return $dom->saveHTML( $dom );
	}

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( '//*[contains(@class, \'' . self::CSS_CLASS[ 'container' ] . '\')]' );

		return $nodes;
	}

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-pros-cons.php';

    public static function render( $args )
    {
		if ( !ReviewMain::check() ) {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE, false, $args );

        $output = ob_get_clean();

        return $output;
    }

	const CSS_CLASS = [
		'container' => 'legal-pros-cons',

		'pros-item' => 'pros-cons-item',

		'pros' => 'legal-pros',

		'cons' => 'legal-cons',

		'title' => 'legal-title',

		'content' => 'legal-content',
	];

    public static function style_formats_pros( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Pros & Cons',

				'items' => [
					[
						'title' => 'Pros Title',
						
						'selector' => 'p,h3',

						'classes' => self::CSS_CLASS[ 'container' ] . ' ' . self::CSS_CLASS[ 'title' ] . ' ' . self::CSS_CLASS[ 'pros' ],
					],

					[
						'title' => 'Cons Title',
						
						'selector' => 'p,h3',

						'classes' => self::CSS_CLASS[ 'container' ] . ' ' . self::CSS_CLASS[ 'title' ] . ' ' . self::CSS_CLASS[ 'cons' ],
					],

					[
						'title' => 'Pros & Cons Content',
						
						'selector' => 'ul',

						'classes' => self::CSS_CLASS[ 'container' ] . ' ' . self::CSS_CLASS[ 'content' ],
					],
				],
			],
		] );
	}
}

?>
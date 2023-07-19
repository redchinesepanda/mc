<?php

class ReviewProsCons
{
    const CSS = [
        'review-pros-cons' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-pros-cons.css',

			'ver' => '1.0.0',
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

		// $not_empty = $current[ 'not_empty' ];

		// LegalDebug::debug( [
		// 	'get_permission_replace' => self::permission_debug( [
		// 		'default' => $default,

		// 		'half_pros' => $half_pros,

		// 		'half_cons' => $half_cons,

		// 		'last' => $last,

		// 		'not_empty' => $not_empty,
		// 	] ),
		// ] );

		// return ( $default || $half_pros || $half_cons || $last ) && $not_empty; 
		
		return $default || $half_pros || $half_cons || $last; 
	}

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

		$body = $dom->getElementsByTagName( 'body' )->item( 0 );

		$containers = [];

		foreach ( $nodes as $id => $node )
		{
			$permission_node = self::get_node_permission( $node );

			$permission_previous = self::get_node_permission( $nodes->item( $id - 1 ) );

			$permission_next = self::get_node_permission( $nodes->item( $id + 1 ) );

			$permission_replace = self::get_permission_replace( $permission_node, $permission_previous, $permission_next );

			LegalDebug::debug( [
				'function' => 'get_content',

				'textContent' => substr( $node->textContent, 0, 30 ),

				'permission_replace' => self::permission_debug( [ 'permission_replace' => $permission_replace ] ),

				// 'permission_previous' => self::permission_debug( $permission_previous ),

				// 'permission_node' => self::permission_debug( $permission_node ),

				// 'permission_next' => self::permission_debug( $permission_next ),
			] );

			if ( $permission_node[ 'pros_title' ] )
			{
				$type = 'pros';

				$container[ $type ][ 'title' ] = ToolEncode::encode( $node->textContent );
			}

			if ( $permission_node[ 'cons_title' ] )
			{
				$type = 'cons';

				$container[ $type ][ 'title' ] = ToolEncode::encode( $node->textContent );
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

				$body->replaceChild( $element, $node );

				$container = [];
			} else {
				$body->removeChild( $node );
			}
		}

		// LegalDebug::debug( [
		// 	'containers' => $containers,
		// ] );

		return $dom->saveHTML();
	}

	// public static function get_content_2( $content )
	// {
    //     if ( !ReviewMain::check() ) {
	// 		return $content;
	// 	}

	// 	$dom = LegalDOM::get_dom( $content );

    //     $nodes = self::get_nodes( $dom );

	// 	if ( $nodes->length == 0 ) {
	// 		return $content;
	// 	}

	// 	$item = null;

	// 	$last = $nodes->length - 1;

    //     $args = [];

	// 	$container = null;

    //     // $container = $dom->createElement( 'div' );

    //     // $container->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );

	// 	foreach ( $nodes as $id => $node ) {
    //         $class = explode( ' ', $node->getAttribute( 'class' ) );

	// 		$permission_title = ( in_array( self::CSS_CLASS[ 'title' ], $class ) );

	// 		$permission_pros_title = ( in_array( self::CSS_CLASS[ 'pros' ], $class ) );

	// 		$permission_content = ( in_array( self::CSS_CLASS[ 'content' ], $class ) );

	// 		$permission_last = ( $id == $last || !empty( $node->nextSibling ) );

	// 		// LegalDebug::debug( [
	// 		// 	'class' => $class,

	// 		// 	'permission' => self::permission_debug( [
	// 		// 		'permission_title' => $permission_title,
	
	// 		// 		'permission_pros_title' => $permission_pros_title,
	
	// 		// 		'permission_content' => $permission_content,
	// 		// 	] ),

	// 		// 	'permission_title' => $permission_title ? 'true' : 'false',

	// 		// 	'permission_pros_title' => $permission_pros_title ? 'true' : 'false',

	// 		// 	'permission_content' => $permission_content ? 'true' : 'false',

	// 		// 	'permission_last' => $permission_last ? 'true' : 'false',

	// 		// 	// 'container' => $container,
	// 		// ] );

	// 		if ( $permission_content ) {
	// 			$node->removeAttribute( 'class' );

    //             $args[ 'content' ] = ToolEncode::encode( $dom->saveHTML( $node ) );
	// 		}

	// 		if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
				
	// 			LegalDOM::appendHTML( $item, self::render( $args ) );

    //             $container->appendChild( $item );

    //             $item = null;
	// 		}

    //         if ( !empty( $container ) && $permission_last ) {
	// 			// LegalDebug::debug( [
	// 			// 	'action' => 'replace',
	// 			// ] );

    //             $node->parentNode->replaceChild( $container, $node );
    //         } else {
	// 			// LegalDebug::debug( [
	// 			// 	'action' => 'remove',
	// 			// ] );

    //             $node->parentNode->removeChild( $node );
    //         }

	// 		if ( $permission_pros_title ) {
	// 			$container = $dom->createElement( 'div' );

    //     		$container->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );
	// 		}

	// 		if ( $permission_title ) {

	// 			$item = $dom->createElement( 'div' );

    //             $class = self::CSS_CLASS[ 'pros' ];

    //             if ( strpos( $node->getAttribute( 'class' ), self::CSS_CLASS[ 'cons' ] ) !== false ) {
    //                 $class = self::CSS_CLASS[ 'cons' ];
    //             }

	// 			$item->setAttribute( 'class', self::CSS_CLASS[ 'pros-item' ] . ' ' . $class );

	// 			$args = [];
				
	// 			$args[ 'title' ] = ToolEncode::encode( $node->textContent );
	// 		}
	// 	}

	// 	return $dom->saveHTML();
	// }

	// public static function get_content( $content )
	// {
    //     if ( !ReviewMain::check() ) {
	// 		return $content;
	// 	}

	// 	$dom = LegalDOM::get_dom( $content );

    //     $nodes = self::get_nodes( $dom );

	// 	if ( $nodes->length == 0 ) {
	// 		return $content;
	// 	}

	// 	$item = null;

	// 	$last = $nodes->length - 1;

    //     $args = [];

    //     $container = $dom->createElement( 'div' );

    //     $container->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );

	// 	foreach ( $nodes as $id => $node ) {
    //         $class = explode( ' ', $node->getAttribute( 'class' ) );

	// 		$permission_title = ( in_array( self::CSS_CLASS[ 'title' ], $class ) );

	// 		$permission_content = ( in_array( self::CSS_CLASS[ 'content' ], $class ) );

	// 		$permission_last = ( $id == $last );

	// 		if ( $permission_content ) {
	// 			$node->removeAttribute( 'class' );

    //             $args[ 'content' ] = ToolEncode::encode( $dom->saveHTML( $node ) );
	// 		}

	// 		if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
				
	// 			LegalDOM::appendHTML( $item, self::render( $args ) );

    //             $container->appendChild( $item );

    //             $item = null;
	// 		}

    //         if ( $permission_last ) {
    //             $node->parentNode->replaceChild( $container, $node );
    //         } else {
    //             $node->parentNode->removeChild( $node );
    //         }

	// 		if ( $permission_title ) {

	// 			$item = $dom->createElement( 'div' );

    //             $class = self::CSS_CLASS[ 'pros' ];

    //             if ( strpos( $node->getAttribute( 'class' ), self::CSS_CLASS[ 'cons' ] ) !== false ) {
    //                 $class = self::CSS_CLASS[ 'cons' ];
    //             }

	// 			$item->setAttribute( 'class', self::CSS_CLASS[ 'pros-item' ] . ' ' . $class );

	// 			$args = [];
				
	// 			$args[ 'title' ] = ToolEncode::encode( $node->textContent );
	// 		}
	// 	}

	// 	return $dom->saveHTML();
	// }

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/*[contains(@class, \'' . self::CSS_CLASS[ 'container' ] . '\')]' );

		return $nodes;
	}

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-pros-cons.php';

    public static function render( $args )
    {
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
						
						'selector' => 'p',

						'classes' => self::CSS_CLASS[ 'container' ] . ' ' . self::CSS_CLASS[ 'title' ] . ' ' . self::CSS_CLASS[ 'pros' ],
					],

					[
						'title' => 'Cons Title',
						
						'selector' => 'p',

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
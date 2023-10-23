<?php

class ReviewBonus
{
	const CSS = [
        'review-bonus' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-bonus.css',

			'ver' => '1.1.9',
		],

        'review-billet' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-billet.css',

            'ver' => '1.1.0',
        ],
    ];
 
    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		ReviewMain::register_inline_style( self::BONUS_CLASS[ 'bonus' ], self::inline_style() );
    }

	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_bonus' ] );
	}

	public static function register()
	{
		$handler = new self();

		add_filter( 'the_content', [ $handler, 'get_content' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
	}

	const BONUS_CLASS = [
		'bonus' => 'legal-bonus',

		'billet' => 'legal-billet',

		'title' => 'legal-bonus-title',

		'description' => 'legal-bonus-description',

		'content' => 'legal-bonus-content',

		'item' => 'legal-bonus-content-item',

		'review' => 'no-review',

		'height' => 'no-height',

		'image' => 'no-image',

		'large' => 'logo-large',
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );
		
		// $nodes = $xpath->query( '//body/*[contains(@class, \'legal-bonus\')]' );
		
		$nodes = $xpath->query( '//*[contains(@class, \'legal-bonus\')]' );

		return $nodes;
	}

	public static function get_shortcode_args( $text )
	{
		$regex = '/(\w+)\s*=\s*"(.*?)"/';

		preg_match_all($regex, $text, $matches);

		$args = [];

		foreach ( $matches[1] as $key => $value )
		{
			$args[ $value ] = $matches[2][ $key ];
		}

		return $args;
	}

	public static function get_shortcode( $node )
	{
		$args = [];

		$previousSibling = $node->previousSibling;

		if ( !empty( $previousSibling ) )
		{
			if ( strpos( $node->textContent, '[/billet-mega' ) === false )
			{
				if ( strpos( $node->textContent, '[billet-mega' ) !== false )
				{
					$args = self::get_shortcode_args( $node->textContent );
				} else 
				{
					$args = self::get_shortcode( $previousSibling );
				}
			}
		}

		return $args;
	}

	public static function get_node_atts( $node )
	{
		$class = [];

		if ( !empty( $node ) )
		{
			$class = explode( ' ', $node->getAttribute( 'class' ) );
		}

		return [
			'review' => in_array( self::BONUS_CLASS[ 'review' ], $class ),

			'height' => in_array( self::BONUS_CLASS[ 'height' ], $class ),

			'image' => in_array( self::BONUS_CLASS[ 'image' ], $class ),

			'large' => in_array( self::BONUS_CLASS[ 'large' ], $class ),
		];
	}

	public static function get_node_permission( $node )
	{
		$class = [];

		if ( !empty( $node ) )
		{
			$class = explode( ' ', $node->getAttribute( 'class' ) );
		}

		return [
			'title' => in_array( self::BONUS_CLASS[ 'title' ], $class ),

			'description' => in_array( self::BONUS_CLASS[ 'description' ], $class ),

			'content' => in_array( self::BONUS_CLASS[ 'content' ], $class ),

			'billet' => in_array( self::BONUS_CLASS[ 'billet' ], $class ),
		];
	}
	
	public static function get_permission_replace( $current, $next )
	{
		$title_title = $current[ 'title' ] && $next[ 'title' ];

		$description_title = $current[ 'description' ] && $next[ 'title' ];

		$content_title = $current[ 'content' ] && $next[ 'title' ];

		$last = !$next[ 'title' ] && !$next[ 'description' ] && !$next[ 'content' ];
		
		return $title_title || $description_title || $content_title || $last; 
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

		// $body = $dom->getElementsByTagName( 'body' )->item( 0 );

		$bonus = null;

		$replace = null;

		$last = $nodes->length - 1;

		$index = 0;

		$containers = [];

		$args = [];

		foreach ( $nodes as $id => $node )
		{
			$class = $node->getAttribute( 'class' );

			$permission_node = self::get_node_permission( $node );

			$permission_next = self::get_node_permission( $nodes->item( $id + 1 ) );

			$permission_replace = self::get_permission_replace( $permission_node, $permission_next );

			$atts = self::get_node_atts( $node );

			if ( $permission_node[ 'title' ] )
			{
				$tag = 'div';

				if ( in_array( $node->nodeName, [ 'p' ] ) )
				{
					$tag = 'p';
				}

				$id = 0;

				$shortcode_args = self::get_shortcode( $node );
	
				if ( !empty( $shortcode_args[ 'id' ] ) )
				{
					$id = $shortcode_args[ 'id' ];
				}

				$args = [
					'title' => [
						'text' => ToolEncode::encode( $node->textContent ),
					
						'tag' => $tag,
					],

					'atts' => $atts,

					'class' => $class,

					'index' => $index,

					'id' => $id,
				];
			}

			if ( $permission_node[ 'description' ] )
			{
				$node->removeAttribute( 'class' );
				
				$args[ 'description' ][] = ToolEncode::encode( $dom->saveHTML( $node ) );
			}

			if ( $permission_node[ 'content' ] )
			{
				$args[ 'content' ][] = ToolEncode::encode( $dom->saveHTML( $node ) );
			}if ( !empty( $args ) && $permission_replace )
			{
				$item = $dom->createElement( 'div' );

				$item_class = [
					$permission_node[ 'billet' ] ? self::BONUS_CLASS[ 'billet' ] : self::BONUS_CLASS[ 'bonus' ],

					'item-' . $index,
				];

				if ( $args[ 'atts' ][ 'height' ] ) {
					$item_class[] = self::BONUS_CLASS[ 'height' ];
				}

				if ( $args[ 'atts' ][ 'image' ] ) {
					$item_class[] = self::BONUS_CLASS[ 'image' ];
				}

				$item->setAttribute( 'class', implode( ' ', $item_class ) );

				$item_html = '';
				
				if ( $permission_node[ 'billet' ] ) {
					$item_html = self::render_billet( $args );
				} else {
					$item_html = self::render_bonus( $args );
				}
				
				LegalDOM::appendHTML( $item, ToolEncode::encode( $item_html ) );

				// try
				// {
				// 	$body->replaceChild( $item, $node );
				// } catch ( DOMException $e )
				// {
				// 	LegalDebug::debug( [
				// 		'ReviewCounter::get_content > replaceChild DOMException',
				// 	] );
				// }

				try
				{
					$node->parentNode->replaceChild( $item, $node );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'class' => 'ReviewBonus',

						'function' => 'get_content,replaceChild',

						'node' => substr( $node->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}

				$index++;
			}
			else
			{
				// try
				// {
				// 	$body->removeChild( $node );
				// } catch ( DOMException $e )
				// {
				// 	LegalDebug::debug( [
				// 		'ReviewCounter::get_content > removeChild DOMException',
				// 	] );
				// }

				try
				{
					$node->parentNode->removeChild( $node );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'class' => 'ReviewBonus',

						'function' => 'get_content,removeChild',

						'node' => substr( $node->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}
			}
		}

		return $dom->saveHTML( $dom );
	}

	public static function get_image_size( $url )
	{
		$result = getimagesize( $url );

		return [
			'width' => $result[ 0 ],

			'height' => $result[ 1 ],
		];
	}

	public static function get_bonus( $args )
	{
		$id = 0;

		if ( !empty( $args[ 'id' ] ) )
		{
			$id = $args[ 'id' ];
		} else 
		{
			$post = get_post();

			$id = $post->ID;
		}

		$class = 'legal-default';

		$src = '';

		$title_text = '';

		$group = get_field( ReviewAbout::FIELD, $id );
		
		if ( $group )
		{
			$class = $group[ 'about-font' ];

			if ( !$args[ 'atts' ][ 'image' ] )
			{
				if ( $args[ 'atts' ][ 'large' ] )
				{
					$src = $group[ 'about-logo-mega' ];

					if ( !$src )
					{
						$src = $group[ 'about-logo' ];
					}
				} else
				{
					$src = $group[ 'about-logo-square' ];
				}
			}

			if ( !$args[ 'atts' ][ 'large' ] )
			{
				$title_text = $group[ 'about-title' ];
			}
		}

		return [
			'index' => $args[ 'index' ],

			'class' => $class,

			'src' => $src,

			'title' => [
				'href' => self::check_url_review( $id ),

				'text' => $title_text,
			],

			'name' => $args[ 'title' ],

			'get' => [
				'href' => self::check_url_afillate( $id ),

				'text' => __( ReviewMain::TEXT[ 'claim-bonus' ], ToolLoco::TEXTDOMAIN ),
			],

			'content' => ( !empty( $args[ 'content' ] ) ? $args[ 'content' ] : '' ),
		];

		return [];
	}

	const TEMPLATE = [
		'bonus' => LegalMain::LEGAL_PATH . '/template-parts/review/review-bonus.php',

		'billet' => LegalMain::LEGAL_PATH . '/template-parts/review/review-billet.php',
	];

    public static function render_bonus( $args )
    {
		if ( !ReviewMain::check() )
        {
            return '';
        }

		ob_start();

        load_template( self::TEMPLATE[ 'bonus' ], false, self::get_bonus( $args ) );

        $output = ob_get_clean();

        return $output;
    }

	const GROUP = [
		'title' => 'about-title',

		'bonus' => 'about-bonus',

		'description' => 'about-description',

		'logo' => 'about-logo',

		'logo-square' => 'about-logo-square',

		'background' => 'about-background',

		'font' => 'about-font',

		'rating' => 'about-rating',

		'afillate' => 'about-afillate',

		'review' => 'about-review',
	];

    public static function inline_style() {
		$group = get_field( ReviewAbout::FIELD );
        
        if( $group )
		{
			if ( !empty( $group[ self::GROUP[ 'background' ] ] ) )
			{
				return '.legal-billet .billet-review {
					background-color: ' . $group[ self::GROUP[ 'background' ] ] . ';
				}';
			}
		}

		return '';
	}

    public static function check_url_review( $id )
	{
		$group = get_field( ReviewAbout::FIELD, $id );
        
        if( $group ) {
			$review = $group[ self::GROUP[ 'review' ] ];

			if ( $review ) {
				return $review;
			}
		}

		return self::check_url_afillate( $id );
	}

    public static function check_url_afillate( $id )
	{
		$group = get_field( ReviewAbout::FIELD, $id );
        
        if( $group ) {
			$afillate = $group[ self::GROUP[ 'afillate' ] ];
			
			if ( $afillate ) {
				return $afillate;
			}
		}

		return ( OopsMain::check_oops() ? '#' : '' );
	}

    public static function get_billet( $args )
	{
		$id = 0;

		if ( !empty( $args[ 'id' ] ) )
		{
			$id = $args[ 'id' ];
		} else 
		{
			$post = get_post();

			$id = $post->ID;
		}

		$group = get_field( ReviewAbout::FIELD, $id );
        
		return [
			'class' => !empty( $group[ 'about-font' ] ) ? $group[ 'about-font' ] : 'legal-default',

			'image' => [
				'src' => ( !empty( $group[ self::GROUP[ 'logo' ] ] ) ? $group[ self::GROUP[ 'logo' ] ] : '' ),

				'alt' => $group[ self::GROUP[ 'title' ] ],
			],
			'review' => [
				'href' => self::check_url_review( $id ),

				'text' => __( ReviewMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ),

				'disabled' => $args[ 'atts' ][ 'review' ],
			],

			'title' => [
				'text' => $args[ 'title' ][ 'text' ],

				'tag' => $args[ 'title' ][ 'tag' ],
			],

			'description' => ( !empty( $args[ 'description' ] ) ? $args[ 'description' ] : '' ),

			'get' => [
				'href' => self::check_url_afillate( $id ),

				'text' => __( ReviewMain::TEXT[ 'get-bonus' ], ToolLoco::TEXTDOMAIN ),
			],
		];
	}

    public static function render_billet( $args )
    {
		if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'billet' ], false, self::get_billet( $args ) );

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
						
						'selector' => 'h3,p',

						'classes' => self::BONUS_CLASS[ 'bonus' ] . ' ' . self::BONUS_CLASS[ 'title' ],
					],

					[
						'title' => 'Bonus Content',
						
						'selector' => 'p,ul,ol,img',

						'classes' => self::BONUS_CLASS[ 'bonus' ] . ' ' . self::BONUS_CLASS[ 'content' ],
					],

					[
						'title' => 'Billet Title',
						
						'selector' => 'h3,p',

						'classes' => self::BONUS_CLASS[ 'billet' ] . ' ' . self::BONUS_CLASS[ 'title' ],
					],

					[
						'title' => 'Billet Description',
						
						'selector' => 'p,ul,ol',

						'classes' => self::BONUS_CLASS[ 'billet' ] . ' ' . self::BONUS_CLASS[ 'description' ],
					],

					[
						'title' => 'No Review',
						
						'selector' => 'h3,p',

						'classes' => self::BONUS_CLASS[ 'review' ],
					],

					[
						'title' => 'No Height',
						
						'selector' => 'h3,p',

						'classes' => self::BONUS_CLASS[ 'height' ],
					],

					[
						'title' => 'No Image',
						
						'selector' => 'h3,p',

						'classes' => self::BONUS_CLASS[ 'image' ],
					],

					[
						'title' => 'Logo Large',
						
						'selector' => 'h3,p',

						'classes' => self::BONUS_CLASS[ 'large' ],
					],
				],
			],
		] );
	}
}

?>
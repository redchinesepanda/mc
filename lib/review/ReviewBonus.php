<?php

class ReviewBonus
{
	const CSS = [
        'review-bonus' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-bonus.css',

			'ver' => '1.1.4',
		],

        'review-billet' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-billet.css',

            'ver' => '1.0.9',
        ],
    ];
 
    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		// LegalDebug::debug( [
		// 	'check' => ( ReviewMain::check() ? 'true' : 'false' ),
		// ] );
		
		if ( ReviewMain::check() ) {
			$name = 'review-inline';

			wp_register_style( $name, false, [], true, true );
			
			wp_add_inline_style( $name, self::inline_style() );
			
			wp_enqueue_style( $name );
		}
    }

	public static function register()
	{
		$handler = new self();

		add_filter( 'the_content', [ $handler, 'get_content' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_bonus' ] );

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
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		// $nodes = $xpath->query( './/*[contains(@class, \'legal-bonus\')]' );
		
		$nodes = $xpath->query( '//body/*[contains(@class, \'legal-bonus\')]' );

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
			// LegalDebug::debug( [
			// 	'function' => 'get_shortcode',

			// 	'textContent' => substr( $node->textContent, 0, 10 ),
			// ] );

			if ( strpos( $node->textContent, '[/billet-mega' ) === false )
			{
				if ( strpos( $node->textContent, '[billet-mega' ) !== false )
				{
					$args = self::get_shortcode_args( $node->textContent );
	
					// LegalDebug::debug( [
					// 	'function' => 'get_shortcode',
			
					// 	'args' => $args,
					// ] );
				} else 
				{
					$args = self::get_shortcode( $previousSibling );
				}
			}
		}

		return $args;
	}

	public static function get_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

		$nodes = self::get_nodes( $dom );

		// LegalDebug::debug( [
		// 	'length' => $nodes->length,
		// ] );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		$body = $dom->getElementsByTagName( 'body' )->item(0);

		$bonus = null;

		$replace = null;

		$last = $nodes->length - 1;

		// $test_node = $nodes->item( 0 );

		// LegalDebug::debug( [
		// 	'function' => 'get_content',

		// 	'textContent' => substr( $test_node->textContent, 0, 30 ),

		// 	'get_shortcode' => self::get_shortcode( $test_node ),
		// ] );

		foreach ( $nodes as $id => $node )
		{
			$class = $node->getAttribute( 'class' );

			$permission_title = ( strpos( $class, self::BONUS_CLASS[ 'title' ] ) !== false );

			$permission_description = ( strpos( $class, self::BONUS_CLASS[ 'description' ] ) !== false );

			$permission_content = ( strpos( $class, self::BONUS_CLASS[ 'content' ] ) !== false );

			$permission_last = ( $id == $last );

			$no_review = self::check_no_review( $class );
			
			$no_height = self::check_no_height( $class );

			if ( $permission_description ) {
				$node->removeAttribute( 'class' );
				
				// $args[ 'description' ] = ToolEncode::encode( $node->textContent );
				
				$args[ 'description' ][] = ToolEncode::encode( $dom->saveHTML( $node ) );
			}

			if ( $permission_content ) {
				// $node->removeAttribute( 'class' );

				$args[ 'content' ][] = ToolEncode::encode( $dom->saveHTML( $node ) );
			}

			if ( !empty( $bonus ) && ( $permission_title || $permission_last ) ) {
				$template = '';

				// LegalDebug::debug( [
				// 	'function' => 'get_content',
					
				// 	'args' => $args,
				// ] );

				// if ( $bonus->getAttribute( 'class' ) == self::BONUS_CLASS[ 'billet' ] ) {
				
				if ( strpos( $bonus->getAttribute( 'class' ), self::BONUS_CLASS[ 'billet' ] ) !== false ) {
					$template = self::render_billet( $args );
				} else {
					$template = self::render_bonus( $args );
				}
				
				LegalDOM::appendHTML( $bonus, ToolEncode::encode( $template ) );
				
				$body->replaceChild( $bonus, $replace );
			}

			if ( $permission_title ) {

				$bonus = $dom->createElement( 'div' );

				$class_bonus = self::check( $class );

				if ( $no_height ) {
					$class_bonus .= ' ' . self::BONUS_CLASS[ 'height' ];
				}

				$bonus->setAttribute( 'class', $class_bonus );

				// $bonus->setAttribute( 'class', self::check( $class ) );

				$args = [];
				
				$args[ 'title' ] = [
					'text' => ToolEncode::encode( $node->textContent ),
					
					'tag' => in_array( $node->nodeName, [ 'p' ] ) ? 'div' : $node->nodeName,
				];

				$args[ 'class' ] = $class;

				$args[ 'no-review' ] = $no_review;

				$replace = $node;
			}

			if ( $permission_title )
			{
				$shortcode_args = self::get_shortcode( $node );
	
				if ( !empty( $shortcode_args[ 'id' ] ) )
				{
					// LegalDebug::debug( [
					// 	'textContent' => substr( $node->textContent, 0, 30 ),
	
					// 	'shortcode_args' => $shortcode_args,
					// ] );

					$args[ 'id' ] = $shortcode_args[ 'id' ];
				}
			}

			if ( $permission_description || $permission_content ) {
				$body->removeChild( $node );
			}
		}

		return $dom->saveHTML();
	}

	public static function check( $class )
	{
		$result = self::BONUS_CLASS[ 'bonus' ];

		if ( strpos( $class, self::BONUS_CLASS[ 'billet' ] ) !== false ) {
			$result = self::BONUS_CLASS[ 'billet' ];
		}

		return $result;
	}

	public static function check_no_review( $class )
	{
		return ( strpos( $class, self::BONUS_CLASS[ 'review' ] ) !== false ? true : false );
	}

	public static function check_no_height( $class )
	{
		return ( strpos( $class, self::BONUS_CLASS[ 'height' ] ) !== false ? true : false );
	}

	public static function get_bonus( $args )
	{
		// LegalDebug::debug( [
		// 	'function' => 'get_bonus',

		// 	'$args' => $args,
		// ] );

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
		
		// if ( $group ) {
			return [
				'class' => ( !empty( $group[ 'about-font' ] ) ? $group[ 'about-font' ] : 'legal-default' ),

				'src' => ( !empty( $group[ 'about-logo-square' ] ) ? $group[ 'about-logo-square' ] : '' ),

				'title' => [
					'href' => self::check_url_review( $id ),

					'text' => ( !empty( $group[ 'about-title' ] ) ? $group[ 'about-title' ] : '' ),

					// 'text' => $group[ 'about-prefix' ] . ' ' . $group[ 'about-title' ] . ' ' . $group[ 'about-suffix' ],
				],

				'name' => $args[ 'title' ],

				'get' => [
					'href' => self::check_url_afillate( $id ),

					'text' => __( 'Claim Bonus', ToolLoco::TEXTDOMAIN ),
				],

				'content' => ( !empty( $args[ 'content' ] ) ? $args[ 'content' ] : '' ),
			];
		// }

		return [];
	}

	const TEMPLATE = [
		'bonus' => LegalMain::LEGAL_PATH . '/template-parts/review/review-bonus.php',

		'billet' => LegalMain::LEGAL_PATH . '/template-parts/review/review-billet.php',
	];

    public static function render_bonus( $args )
    {
		// LegalDebug::debug( [
		// 	'function' => 'render_bonus',

		// 	'$args' => $args,

		// 	'self::get_bonus( $args )' => self::get_bonus( $args ),
		// ] );

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
        
        // if( $group ) {
			return [
				'class' => !empty( $group[ 'about-font' ] ) ? $group[ 'about-font' ] : 'legal-default',

				'src' => ( !empty( $group[ self::GROUP[ 'logo' ] ] ) ? $group[ self::GROUP[ 'logo' ] ] : '' ),

				'review' => [
					'href' => self::check_url_review( $id ),

					'text' => __( 'Review', ToolLoco::TEXTDOMAIN ),

					'disabled' => $args[ 'no-review' ],
				],

				'title' => [
					'text' => $args[ 'title' ][ 'text' ],

					'tag' => $args[ 'title' ][ 'tag' ],
				],

				'description' => ( !empty( $args[ 'description' ] ) ? $args[ 'description' ] : '' ),

				'get' => [
					'href' => self::check_url_afillate( $id ),

					'text' => __( 'Get Bonus', ToolLoco::TEXTDOMAIN ),
				],
			];
		// }

		// return [];
	}

    public static function render_billet( $args )
    {
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
				],
			],
		] );
	}
}

?>
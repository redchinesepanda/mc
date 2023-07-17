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

            'ver' => '1.0.6',
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
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		// $nodes = $xpath->query( './/*[contains(@class, \'legal-bonus\')]' );
		
		$nodes = $xpath->query( '//body/*[contains(@class, \'legal-bonus\')]' );

		return $nodes;
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

		foreach ( $nodes as $id => $node ) {

			$class = $node->getAttribute( 'class' );

			$permission_title = ( strpos( $class, self::BONUS_CLASS[ 'title' ] ) !== false );

			$permission_description = ( strpos( $class, self::BONUS_CLASS[ 'description' ] ) !== false );

			$permission_content = ( strpos( $class, self::BONUS_CLASS[ 'content' ] ) !== false );

			$permission_last = ( $id == $last );

			$no_review = self::check_no_review( $class );

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

				if ( $bonus->getAttribute( 'class' ) == self::BONUS_CLASS[ 'billet' ] ) {
				
				// if ( strpos( $bonus->getAttribute( 'class' ), self::BONUS_CLASS[ 'billet' ] ) !== false ) {
					$template = self::render_billet( $args );
				} else {
					$template = self::render_bonus( $args );
				}
				
				LegalDOM::appendHTML( $bonus, ToolEncode::encode( $template ) );
				
				$body->replaceChild( $bonus, $replace );
			}

			if ( $permission_title ) {

				$bonus = $dom->createElement( 'div' );

				$bonus->setAttribute( 'class', self::check( $class ) );

				// if ( $no_review ) {

				// }

				$args = [];
				
				$args[ 'title' ] = ToolEncode::encode( $node->textContent );

				$args[ 'class' ] = $class;

				$args[ 'no-review' ] = $no_review;

				$replace = $node;
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

	public static function get_bonus( $args )
	{
		$group = get_field( ReviewAbout::FIELD );

		// LegalDebug::debug( [
		// 	'function' => 'get_bonus',

		// 	'$args' => $args,
		// ] );
		
		// if ( $group ) {
			return [
				'class' => ( !empty( $group[ 'about-font' ] ) ? $group[ 'about-font' ] : 'legal-default' ),

				'src' => ( !empty( $group[ 'about-logo-square' ] ) ? $group[ 'about-logo-square' ] : '' ),

				'title' => [
					'href' => self::check_url_review(),

					'text' => ( !empty( $group[ 'about-title' ] ) ? $group[ 'about-title' ] : '' ),

					// 'text' => $group[ 'about-prefix' ] . ' ' . $group[ 'about-title' ] . ' ' . $group[ 'about-suffix' ],
				],

				'name' => $args[ 'title' ],

				'get' => [
					'href' => self::check_url_afillate(),

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

    public static function check_url_review()
	{
		$group = get_field( ReviewAbout::FIELD );
        
        if( $group ) {
			$review = $group[ self::GROUP[ 'review' ] ];

			if ( $review ) {
				return $review;
			}
		}

		return self::check_url_afillate();
	}

    public static function check_url_afillate()
	{
		$group = get_field( ReviewAbout::FIELD );
        
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
		$group = get_field( ReviewAbout::FIELD );

		LegalDebug::debug( [
			'function' => 'get_billet',

			'$args' => $args,
		] );

		$css_font = !empty( $group[ 'about-font' ] ) ? $group[ 'about-font' ] : 'legal-default';

		$css_no_review = !empty( $args[ 'no-review' ] ) ? self::BONUS_CLASS[ 'review' ] : '';
        
        // if( $group ) {
			return [
				'class' => $css_font . ' ' . $css_no_review,

				'src' => ( !empty( $group[ self::GROUP[ 'logo' ] ] ) ? $group[ self::GROUP[ 'logo' ] ] : '' ),

				'review' => [
					'href' => self::check_url_review(),

					'text' => __( 'Review', ToolLoco::TEXTDOMAIN ),

					'disabled' => $args[ 'no-review' ],
				],

				'title' => $args[ 'title' ],

				'description' => ( !empty( $args[ 'description' ] ) ? $args[ 'description' ] : '' ),

				'get' => [
					'href' => self::check_url_afillate(),

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
				],
			],
		] );
	}
}

?>
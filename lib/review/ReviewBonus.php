<?php

class ReviewBonus
{
	const CSS = [
        'review-bonus' => LegalMain::LEGAL_URL . '/assets/css/review/review-bonus.css',

        'review-billet' => LegalMain::LEGAL_URL . '/assets/css/review/review-billet.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register_inline_style()
    {
		$name = 'review-inline';

        wp_register_style( $name, false, [], true, true );
		
		wp_add_inline_style( $name, self::inline_style() );
		
		wp_enqueue_style( $name );
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
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/*[contains(@class, \'legal-bonus\')]' );

		return $nodes;
	}

	public static function get_content( $content )
	{
		if ( !ReviewMain::is_front() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

		$nodes = self::get_nodes( $dom );

		LegalDebug::debug( [
			'length' => $nodes->length,
		] );

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

			// legalDebug::debug( [
			// 	'function' => 'get_content',

			// 	'$node->textContent' => substr( $node->textContent, 0, 10 ),

			// 	'$class' => $class,

			// 	'$permission_title' => ( $permission_title ? 'true' : 'false' ),
				
			// 	'$permission_description' => ( $permission_description ? 'true' : 'false' ),

			// 	'$permission_content' => ( $permission_content ? 'true' : 'false' ),

			// 	'$permission_last' => ( $permission_last ? 'true' : 'false' ),
			// ] );

			if ( $permission_description ) {
				
				$args[ 'description' ] = ToolEncode::encode( $node->textContent );
			}

			if ( $permission_content ) {
				$node->removeAttribute( 'class' );

				$args[ 'content' ][] = ToolEncode::encode( $dom->saveHTML( $node ) );
			}

			if ( !empty( $bonus ) && ( $permission_title || $permission_last ) ) {
				$template = '';

				// LegalDebug::debug( [
				// 	'function' => 'get_content',
		
				// 	'$args' => $args,
				// ] );

				if ( $bonus->getAttribute( 'class' ) == self::BONUS_CLASS[ 'billet' ] ) {
					$template = self::render_billet( $args );
				} else {
					$template = self::render_bonus( $args );
				}
				
				LegalDOM::appendHTML( $bonus, $template );

				$node->parentNode->replaceChild( $bonus, $replace );
			}

			if ( $permission_title ) {

				$bonus = $dom->createElement( 'div' );

				$bonus->setAttribute( 'class', self::check( $class ) );

				$args = [];
				
				$args[ 'title' ] = ToolEncode::encode( $node->textContent );

				$args[ 'class' ] = $class;

				$replace = $node;
			}

			if ( $permission_description || $permission_content ) {
				$node->parentNode->removeChild( $node );
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

	public static function get_bonus( $args )
	{
		$group = get_field( ReviewAbout::FIELD );

		// LegalDebug::debug( [
		// 	'function' => 'get_bonus',

		// 	'$args' => $args,
		// ] );
		
		// if ( $group ) {
			return [
				'src' => ( !empty( $group[ 'about-logo-square' ] ) ? $group[ 'about-logo-square' ] : '' ),

				'title' => [
					'href' => self::check_url_review(),

					'text' => ( !empty( $group[ 'about-title' ] ) ? $group[ 'about-title' ] : '' ),
				],

				'name' => $args[ 'title' ],

				'get' => [
					'href' => self::check_url_get(),

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

		'rating' => 'about-rating',

		'afillate' => 'about-afillate',

		'review' => 'about-review',
	];

    public static function inline_style() {
		$group = get_field( ReviewAbout::FIELD );
        
        if( $group ) {
			if ( !empty( $group[ self::GROUP[ 'background' ] ] ) ) {
				$styles = '
					.wp-list-table .column-active_blogs {
						width: 10em;
						white-space: nowrap
					}
					';
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
			if ( !empty( $group[ self::GROUP[ 'review' ] ] ) ) {
				return $group[ self::GROUP[ 'review' ] ];
			}
		}

		return self::check_url_get();
	}

    public static function check_url_get()
	{
		$group = get_field( ReviewAbout::FIELD );
        
        if( $group ) {
			if ( !empty( $group[ self::GROUP[ 'afillate' ] ] ) ) {
				return $group[ self::GROUP[ 'afillate' ] ];
			}
		}

		return ( OopsMain::check_oops() ? '#' : '' );
	}

    public static function get_billet( $args )
	{
		$group = get_field( ReviewAbout::FIELD );
        
        // if( $group ) {
			return [
				'src' => ( !empty( $group[ self::GROUP[ 'logo' ] ] ) ? $group[ self::GROUP[ 'logo' ] ] : '' ),

				'review' => [
					'href' => self::check_url_review(),

					'text' => __( 'Review', ToolLoco::TEXTDOMAIN ),
				],

				'title' => $args[ 'title' ],

				'description' => ( !empty( $args[ 'description' ] ) ? $args[ 'description' ] : '' ),

				'get' => [
					'href' => self::check_url_get(),

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
						
						'selector' => 'p',

						'classes' => self::BONUS_CLASS[ 'bonus' ] . ' ' . self::BONUS_CLASS[ 'title' ],
					],

					[
						'title' => 'Bonus Content',
						
						'selector' => 'p,ul,ol,img',

						'classes' => self::BONUS_CLASS[ 'bonus' ] . ' ' . self::BONUS_CLASS[ 'content' ],
					],

					[
						'title' => 'Billet Title',
						
						'selector' => 'p',

						'classes' => self::BONUS_CLASS[ 'billet' ] . ' ' . self::BONUS_CLASS[ 'title' ],
					],

					[
						'title' => 'Billet Description',
						
						'selector' => 'p',

						'classes' => self::BONUS_CLASS[ 'billet' ] . ' ' . self::BONUS_CLASS[ 'description' ],
					],
				],
			],
		] );
	}
}

?>
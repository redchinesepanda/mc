<?php

class ReviewAbout
{
    const CSS = [
        'review-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-about.css',

            'ver'=> '1.1.3',
        ],
    ];

    public static function register_style()
    {
        if ( self::check() ) {
            ToolEnqueue::register_style( self::CSS );
        }
    }

    public static function register_inline_style()
    {
        if ( self::check() ) {
            ToolEnqueue::register_inline_style( 'review-about', self::inline_style_about() );
        }

        if ( ReviewMain::check() ) {
            ToolEnqueue::register_inline_style( 'review-highlight', self::inline_style_highlight() );
        }
    }

    public static function check()
    {
        $permission_admin = !is_admin();

        $permission_post_type = is_singular( [ 'legal_bk_review' ] );
        
        return $permission_admin && $permission_post_type;
    }

    public static function register()
    {
        $handler = new self();

        // [legal-about]

        // [legal-about mode="footer"]

        // [legal-about mode="mini"]

        add_shortcode( 'legal-about', [ $handler, 'render' ] );

        // [legal-button suffix="ios"]

        add_shortcode( 'legal-button', [ $handler, 'render_button' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
    }

    public static function inline_style_highlight()
    {
        $style = [];

		$style_item = self::get( [] );

        // LegalDebug::debug( [
        //     'style_item' => $style_item,
        // ] );

        $style[] = '.legal-highlight { background-color: ' . $style_item[ 'background' ] .'; }';

        return implode( ' ', $style ); 
    }

    public static function inline_style_about()
    {
		$style = [];

		$style_item = self::get( [] );

        $style[] = '.review-about { background-color: ' . $style_item[ 'background' ] .'; }';

        $style[] = '.review-about .about-logo { background-image: url( \'' . $style_item[ 'logo' ] .'\' ); }';

		return implode( ' ', $style );
	}

    public static function check_href_afillate()
	{
        $group = get_field( ReviewAbout::FIELD );
        
        if( $group ) {
			if ( !empty( $group[ 'about-afillate' ] ) ) {
                $meta = get_post_meta( $group[ 'about-afillate' ] );

                LegalDebug::debug( [
                    'meta' => $meta,
                ] );

				return $group[ 'about-afillate' ];
			}
		}

		return ( OopsMain::check_oops() ? '#' : '' );
	}

    const FIELD = 'review-about';

    const ABOUT = [
        'background' => 'about-background',

        'logo' => 'about-logo',
    ];

    const BONUS_EXCEPTION = [ 'es' ];

    public static function get( $args )
    {
        $mode = '';

        if ( !empty( $args[ 'mode' ] ) ) {
            if ( $args[ 'mode' ] == 'footer' )
            {
                $mode = 'footer';
            }

            if ( $args[ 'mode' ] == 'mini' )
            {
                $mode = 'mini';
            }
        }

        $group = get_field( self::FIELD );

        // LegalDebug::debug( [
        //     'group' => $group,
        // ] );
        
        if( $group ) {
            $title = $group[ 'about-title' ];

            $bonus = $group[ 'about-bonus' ];

            $locale = WPMLMain::current_language();

            if ( $mode == 'mini' || in_array( $locale, self::BONUS_EXCEPTION ) )
            {
                $bonus = $group[ 'about-title' ];
            }

            $afillate_description = '';

            if ( in_array( $locale, self::BONUS_EXCEPTION ) )
            {
                $afillate_description = 'Publicidad | Juego Responsable | +18';
            }

            return [
                'title' => $group[ 'about-prefix' ] . ' ' . $group[ 'about-title' ] . ' ' . $group[ 'about-suffix' ],
                
                'bonus' => $bonus,
                
                'description' => $group[ 'about-description' ],
                
                'logo' => $group[ self::ABOUT[ 'logo' ] ],

                'background' => $group[ self::ABOUT[ 'background' ] ],

                'font' => $group[ 'about-font' ],
                
                'rating' => [
                    'label' => __( 'Rating', ToolLoco::TEXTDOMAIN ),

                    'value' => $group[ 'about-rating' ],
                ],

                'afillate' => [
                    'href' => self::check_href_afillate(),

                    'text' => self::get_text(),

                    'description' => $afillate_description,
                ],

                'mode' => $mode,

                'class' => ( !empty( $mode ) ? 'legal-mode-' . $mode : 'legal-mode-default' ),
            ];
        }

        return [];
    }

    const TEMPLATE = [
        'review-about' => LegalMain::LEGAL_PATH . '/template-parts/review/review-about.php',

        'review-button' => LegalMain::LEGAL_PATH . '/template-parts/review/review-button.php',
    ];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'review-about' ], false, self::get( $args ) );

        $output = ob_get_clean();

        return $output;
    }

    public static function get_text( $suffix = '' )
    {
        $group = get_field( self::FIELD );

        $text = __( 'Bet here', ToolLoco::TEXTDOMAIN );

        if( $group )
        {
            if ( has_term( 'app', 'page_type' ) )
            {
                $text = __( 'Download', ToolLoco::TEXTDOMAIN ) . ' ' . $group[ 'about-title' ] . ' ' . $suffix . ' ' . __( 'App', ToolLoco::TEXTDOMAIN );
            }
        }

        return $text;
    }
    
    public static function get_button( $args )
    {
        $group = get_field( self::FIELD );

        if( $group )
        {
            $suffix = '';

            if ( !empty( $args[ 'suffix' ] ) )
            {
                $suffix = $args[ 'suffix' ];
            }

            return [
                'href' => self::check_href_afillate(),

                'text' => self::get_text( $suffix ),
            ];
        }

        return [];
    }

    public static function render_button( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'review-button' ], false, self::get_button( $args ) );

        $output = ob_get_clean();

        return $output;
    }
}

?>
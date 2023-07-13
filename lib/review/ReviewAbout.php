<?php

class ReviewAbout
{
    const CSS = [
        'review-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-about.css',

            'ver'=> '1.0.8',
        ],
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		ReviewMain::register_inline_style( 'review-about', self::inline_style() );
    }

    public static function register()
    {
        $handler = new self();

        // [legal-about]

        // [legal-about mode="footer"]

        add_shortcode( 'legal-about', [ $handler, 'render' ] );

        // [legal-button]

        add_shortcode( 'legal-button', [ $handler, 'render_button' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
    }

    public static function inline_style() {
		$style = [];

		$style_item = self::get( [] );

        $style[] = '.review-about, .legal-highlight { background-color: ' . $style_item[ 'background' ] .'; }';

        $style[] = '.review-about .about-logo { background-image: url( \'' . $style_item[ 'logo' ] .'\' ); }';

		return implode( ' ', $style );
	}

    public static function check_href_afillate()
	{
        $group = get_field( ReviewAbout::FIELD );
        
        if( $group ) {
			if ( !empty( $group[ 'about-afillate' ] ) ) {
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
            if ( $args[ 'mode' ] == 'footer' ) {
                $mode = 'footer';
            }
        }

        $group = get_field( self::FIELD );
        
        if( $group ) {
            $title = $group[ 'about-title' ];

            $bonus = $group[ 'about-bonus' ];

            $locale = WPMLMain::get_locale();

            if ( $mode == 'footer' && in_array( $locale, self::BONUS_EXCEPTION ) )
            {
                $bonus = $group[ 'about-title' ];
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

                    'text' => __( 'Bet here', ToolLoco::TEXTDOMAIN ),
                ],

                'mode' => $mode,

                'class' => ( !empty( $mode ) ? 'legal-mode' . $mode : 'legal-mode-default' ),
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

    public static function get_button( $args )
    {
        $group = get_field( self::FIELD );
        
        if( $group ) {
            return [
                'href' => self::check_href_afillate(),

                'text' => __( 'Bet here', ToolLoco::TEXTDOMAIN ),
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
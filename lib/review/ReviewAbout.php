<?php

class ReviewAbout
{
    const CSS = [
        'review-about' => LegalMain::LEGAL_URL . '/assets/css/review/review-about.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-about]

        add_shortcode( 'legal-about', [ $handler, 'render' ] );

        // [legal-button]

        add_shortcode( 'legal-button', [ $handler, 'render_button' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
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

    public static function get( $args )
    {
        $mode = '';

        if ( !empty( $args[ 'mode' ] ) ) {
            if ( $args[ 'mode' ] == 'footer' ) {
                $mode = 'footer';
            }
        }

        $group = get_field( self::FIELD );

        LegalDebug::debug( [
            'group' => $group, 
        ] );
        
        if( $group ) {
            // LegalDebug::debug( [
            //     'OopsMain::check_oops()' => ( OopsMain::check_oops() ? 'true' : 'false' ), 
            // ] );

            return [
                'title' => $group[ 'about-title' ],
                
                'bonus' => $group[ 'about-bonus' ],
                
                'description' => $group[ 'about-description' ],
                
                'logo' => $group[ 'about-logo' ],

                'background' => $group[ 'about-background' ],
                
                'rating' => __( 'Rating', ToolLoco::TEXTDOMAIN ) . ' - ' . $group[ 'about-rating' ],

                'afillate' => [
                    'href' => self::check_href_afillate(),

                    'text' => __( 'Bet here', ToolLoco::TEXTDOMAIN ),
                ],

                'mode' => $mode,
            ];
        }

        return [];
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-about.php';

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get( $args ) );

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

    const TEMPLATE_BUTTON = LegalMain::LEGAL_PATH . '/template-parts/review/review-button.php';

    public static function render_button( $args )
    {
        ob_start();

        load_template( self::TEMPLATE_BUTTON, false, self::get_button( $args ) );

        $output = ob_get_clean();

        return $output;
    }
}

?>
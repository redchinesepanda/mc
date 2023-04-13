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

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        LegalDebug::debug( [ 'function' => 'ReviewAbout::register' ] );
    }

    const FIELD = 'review-about';

    public static function get()
    {
        $group = get_field( self::FIELD );
        
        if( $group ) {
            return [
                'title' => $group[ 'about-title' ],
                
                'bonus' => $group[ 'about-bonus' ],
                
                'description' => $group[ 'about-description' ],
                
                'logo' => $group[ 'about-logo' ],
                
                'rating' => $group[ 'about-rating' ],

                'afillate' => $group[ 'about-afillate' ],
            ];
        }

        return [];
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-about.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
<?php

class ReviewOverview
{
    const CSS = [
        'review-overview' => LegalMain::LEGAL_URL . '/assets/css/review/review-overview.css',
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

        // [legal-overview]

        add_shortcode( 'legal-overview', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    const FIELD = 'review-overview';

    public static function get()
    {
        $group = get_field( self::FIELD );
        
        if( $group ) {
            return [
                'title' => $group[ 'overview-title' ],

                'description' => $group[ 'overview-description' ],
            ];
        }

        return '';
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-overview.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
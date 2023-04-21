<?php

class ReviewProfsCons
{
    const CSS = [
        'review-profs-cons' => LegalMain::LEGAL_URL . '/assets/css/review/review-profs-cons.css',
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

        // [legal-profs-cons]

        add_shortcode( 'legal-profs-cons', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    const FIELD = 'review-profs-cons';

    const GROUP = 'profs-cons-item';

    const ITEM_TYPE = 'item-type';

    const ITEM_TITLE = 'item-title';

    const ITEM_DESCRIPTION = 'item-description';

    public static function get()
    {
        $repeater = get_field( self::FIELD );
        
        $args = [];

        if( $repeater ) {
            foreach ( $repeater as $item ) {
                $args[] = [
                    'type' => $item[ self::GROUP ][ self::ITEM_TYPE ],

                    'title' => $item[ self::GROUP ][ self::ITEM_TITLE ],

                    'description' => $item[ self::GROUP ][ self::ITEM_DESCRIPTION ],
                ];
            }
        }

        return $args;
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-profs-cons.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
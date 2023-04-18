<?php

class RviewGallery
{
    const CSS = [
        'review-gallery' => LegalMain::LEGAL_URL . '/assets/css/review/review-gallery.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    const JS = [
        'review-gallery' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery.js',
    ];

    public static function register_script()
    {
        foreach ( self::JS as $name => $path ) {
            wp_register_script( $name, $path, [], false, true );

            wp_enqueue_script( $name );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_theme_support( 'post-thumbnails' );

        add_image_size( 'legal-bookmaker-review', 354, 489 );

        add_filter( 'image_size_names_choose', 'size_label' );
    }

    public static function size_label( $sizes )
    {
        return array_merge( $sizes, [
            'legal-bookmaker-review' => __( 'Bookmaker Review', ToolLoco::TEXTDOMAIN ),
        ] );
    }
}

?>
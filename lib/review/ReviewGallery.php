<?php

class ReviewGallery
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

    const SIZE = [
        'review' => 'legal-bookmaker-review',

        'lightbox' => 'legal-bookmaker-review-lightbox',
    ];

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_image_size( self::SIZE[ 'review' ], 354, 175, [ 'center', 'top' ] );

        add_image_size( self::SIZE[ 'lightbox' ], 1024, 619, false );

        add_filter( 'image_size_names_choose', [ $handler, 'size_label' ] );

        add_filter( 'wp_lazy_loading_enabled', '__return_true' );

        add_filter( 'wp_calculate_image_srcset', [ $handler, 'wp_kama_calculate_image_srcset_filter' ], 10, 5 );

        // add_filter('max_srcset_image_width', function( $max_srcset_image_width, $size_array ){
        //     LegalDebug::debug( [
        //         '$max_srcset_image_width' => $max_srcset_image_width,

        //         '$size_array' => $size_array,
        //     ] );

        //     return 2000;
        // }, 10, 2);
    }

    const FIELD = [
        'gallery' => '',
    ];

    public static function size_label( $sizes )
    {
        return array_merge( $sizes, [
            self::SIZE[ 'review' ] => __( 'Bookmaker Review', ToolLoco::TEXTDOMAIN ),

            self::SIZE[ 'lightbox' ] => __( 'Bookmaker Lightbox', ToolLoco::TEXTDOMAIN ),
        ] );
    }

    function wp_kama_calculate_image_srcset_filter( $sources, $size_array, $image_src, $image_meta, $attachment_id ){

        if ( !is_admin() ) {
            LegalDebug::debug( [
                'function' => 'wp_kama_calculate_image_srcset_filter',

                // 'wp_get_registered_image_subsizes()' => wp_get_registered_image_subsizes(),

                'wp_get_attachment_image_url' => wp_get_attachment_image_url( $attachment_id, self::SIZE[ 'lightbox' ] ),

                'wp_getimagesize' => wp_getimagesize( wp_get_attachment_image_url( $attachment_id, self::SIZE[ 'lightbox' ] ) ),

                '$sources' => $sources,
                
                '$size_array' => $size_array,

                '$image_src' => $image_src,

                // '$image_meta' => $image_meta,
                
                '$attachment_id' => $attachment_id,
            ] );
        }

        return $sources;
    }
}

?>
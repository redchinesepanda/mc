<?php

class ReviewGallery
{
    const CSS = [
        'review-gallery' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-gallery.css',

            'ver' => '1.0.1'
        ],
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

    const JS = [
        'review-gallery' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery.js',
    ];

    public static function register_script()
    {
        ReviewMain::register_script( self::JS );
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

        add_filter( 'post_gallery', [ $handler, 'wp_kama_post_gallery_filter' ], 10, 3 );

        // add_filter( 'wp_calculate_image_srcset', [ $handler, 'wp_kama_calculate_image_srcset_filter' ], 10, 5 );
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

    public static function get( $ids ) {
        $args = [];

        foreach ( $ids as $id ) {
            $review = wp_get_attachment_image_src( $id, self::SIZE[ 'review' ] );

            $lightbox = wp_get_attachment_image_src( $id, self::SIZE[ 'lightbox' ] );

            $caption = wp_get_attachment_caption( $id );

            $meta_value = get_post_meta( $id, '_wp_attachment_image_alt', true );

            $alt = ( !empty( $meta_value ) ? $meta_value : $caption );

            if ( $review && $lightbox ) {
                $args[] = [
                    'src' => $review[ 0 ],
    
                    'width' => $review[ 1 ],
    
                    'height' => $review[ 2 ],
    
                    'data-src' => $lightbox[ 0 ],
    
                    'caption' => $caption,
    
                    'alt' => $alt,
                ];
            }
        }

        return $args;
    }
    public static function wp_kama_post_gallery_filter( $output, $attr, $instance ) {
        if ( !empty( $attr[ 'ids' ] ) ) {
            $output = self::render( self::get( explode( ',', $attr[ 'ids' ] ) ) );
        }

        return $output;
    }

    const TEMPLATE = [
        'gallery' => LegalMain::LEGAL_PATH . '/template-parts/review/review-gallery.php',
    ];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'gallery' ], false, $args );

        return ob_get_clean();
    }
}

?>
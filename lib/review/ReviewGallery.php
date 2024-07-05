<?php

class ReviewGallery
{
    const CSS = [
        'review-gallery' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-gallery.css',

            'ver' => '1.1.1',
        ],
    ];

    const CSS_NEW = [
        'review-gallery' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-gallery-new.css',

            'ver' => '1.0.3',
        ],
    ]; 

    const SHORTCODES = [
        'gallery' => 'gallery',
    ];

    public static function check_shortcode_gallery()
    {
        return LegalComponents::check_shortcode( self::SHORTCODES[ 'gallery' ] );
        
        // return LegalComponents::check_contains( self::SHORTCODES[ 'gallery' ] );

        // return true;
    }

    public static function register_style()
    {
        if ( TemplateMain::check_new() )
        {
            if ( self::check_shortcode_gallery() )
            {
                ReviewMain::register_style( self::CSS_NEW );
            }
        }
        else
        {
            ReviewMain::register_style( self::CSS );
        }
    }

    const JS = [
        'review-gallery' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery.js',

            'ver' => '1.0.0',
        ],
    ];

    const JS_NEW = [
        'review-gallery-slider' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery-slider.js',

            'ver' => '1.0.0',
        ],

        'review-gallery-swiper' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery-swiper.js',

            'ver' => '1.0.1',
        ],

        'review-gallery-pagination' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery-pagination.js',

            'ver' => '1.0.0',
        ],

        'review-gallery-oops' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery-oops.js',

            'ver' => '1.0.0',
        ],

        'review-gallery-caption' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-gallery-caption.js',

            'ver' => '1.0.0',
        ],
    ];

    public static function register_script()
    {
        if ( TemplateMain::check_new() )
        {
            if ( self::check_shortcode_gallery() )
            {
                ReviewMain::register_script( self::JS_NEW );
            }
        }
        else
        {
            ReviewMain::register_script( self::JS );
        }
        
    }

    const SIZE = [
        'review' => 'legal-bookmaker-review',

        'lightbox' => 'legal-bookmaker-review-lightbox',

        'medium' => 'medium',

        'medium-large' => 'medium_large',
    ];

	public static function register_functions()
    {
        $handler = new self();
        
        add_image_size( self::SIZE[ 'review' ], 354, 175, [ 'center', 'top' ] );

        add_image_size( self::SIZE[ 'lightbox' ], 1024, 619, false );

        add_filter( 'image_size_names_choose', [ $handler, 'size_label' ] );
    }

    public static function register()
    {
        if ( self::check_shortcode_gallery() )
        {
            $handler = new self();

            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

            add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

            add_filter( 'wp_lazy_loading_enabled', '__return_true' );

            add_filter( 'post_gallery', [ $handler, 'render_gallery' ], 10, 3 );
        }
    }

    const FIELD = [
        'gallery' => '',
    ];

    public static function size_label( $sizes )
    {
        return array_merge( $sizes, [
            self::SIZE[ 'review' ] => __( ReviewMain::TEXT[ 'bookmaker-review' ], ToolLoco::TEXTDOMAIN ),

            self::SIZE[ 'lightbox' ] => __( ReviewMain::TEXT[ 'bookmaker-lightbox' ], ToolLoco::TEXTDOMAIN ),
        ] );
    }

    const COLUMNS = [
        '1' => 'columns-1',

        '2' => 'columns-2',

        '3' => 'columns-3',
    ];

    // public static function get_size( $amount, $size )
    // {
    //     if ( $columns == 1 )
    //     {
    //         return $size;
    //     }

    //     return self::SIZE[ 'review' ];
    // }

    public static function get_class( $amount )
    {
        if ( array_key_exists( $amount , self::COLUMNS ) )
        {
            return self::COLUMNS[ $amount ];
        }

        return self::COLUMNS[ '3' ];
    }

    public static function get( $attr )
    {
        $args = [];

        if ( !empty( $attr[ 'ids' ] ) )
        {
            $ids =  explode( ',', $attr[ 'ids' ] );

            $amount = count( $ids );

            $args[ 'class' ] = self::get_class( $amount );
            
            $size = self::SIZE[ 'review' ];
            
            // if ( !empty( $attr[ 'size' ] ) )
            if ( $amount == 1 && !empty( $attr[ 'size' ] ) )
            {
                // LegalDebug::debug( [
                //     $attr[ 'size' ],
                // ] );

                // if ( $amount == 1 && $attr[ 'size' ] == self::SIZE[ 'lightbox' ] )
                // {
                    $size = $attr[ 'size' ];
                // }
            }

            // $size = self::get_size( $amount, $attr[ 'size' ] );

            foreach ( $ids as $id )
            {    
                $item = self::get_item( $id, $size );

                if ( !empty( $item ) )
                {
                    $args[ 'items' ][] = $item;
                }
            }
        } 

        return $args;
    }

    const CLASSES = [
        'landscape' => 'legal-landscape',

        'portrait' => 'legal-portrait',
    ];

    public static function get_item( $id, $size )
    {
        // $review = wp_get_attachment_image_src( $id, $attr[ 'size' ] );
                        
        $review = wp_get_attachment_image_src( $id, $size );

        $lightbox = wp_get_attachment_image_src( $id, self::SIZE[ 'lightbox' ] );

        $caption = wp_get_attachment_caption( $id );

        $meta_value = get_post_meta( $id, '_wp_attachment_image_alt', true );

        $alt = ( !empty( $meta_value ) ? $meta_value : $caption );

        // if ( $review && $lightbox )
        
        if ( !$review || !$lightbox )
        {
            return [];  
        }

        $orientation = ( $review[ 1 ] > $review[ 2 ] ) ? self::CLASSES[ 'landscape' ] : self::CLASSES[ 'portrait' ];

        return [
            'src' => $review[ 0 ],

            'width' => $review[ 1 ],

            'height' => $review[ 2 ],

            'data-src' => $lightbox[ 0 ],

            'caption' => $caption,

            'alt' => $alt,

            'class' => 'item-image-' . $id . ' ' . $orientation,
        ];
    }

    public static function render_gallery( $output, $attr, $instance )
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        if ( TemplateMain::check_new() )
        {
            return self::render_new( self::get( $attr ) );
        } 

        return self::render( self::get( $attr ) );
    }

    const TEMPLATE = [
        'gallery' => LegalMain::LEGAL_PATH . '/template-parts/review/review-gallery.php',

        'gallery-new' => LegalMain::LEGAL_PATH . '/template-parts/review/review-gallery-new.php',
    ];

    public static function render( $args )
    {
        return self::render_main( self::TEMPLATE[ 'gallery' ], $args );
    }

    public static function render_new( $args )
    {
        return self::render_main( self::TEMPLATE[ 'gallery-new' ], $args );
    }

    public static function render_main( $template, $args )
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( $template, false, $args );

        return ob_get_clean();
    }
}

?>
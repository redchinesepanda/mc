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

            'ver' => '1.0.0',
        ],
    ];

    const SHORTCODES = [
        'gallery' => 'gallery',
    ];

    public static function check_shortcode_gallery()
    {
        return LegalComponents::check_shortcode( self::SHORTCODES[ 'gallery' ] );
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

    public static function register_script()
    {
        ReviewMain::register_script( self::JS );
    }

    const SIZE = [
        'review' => 'legal-bookmaker-review',

        'lightbox' => 'legal-bookmaker-review-lightbox',
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
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_filter( 'wp_lazy_loading_enabled', '__return_true' );

        add_filter( 'post_gallery', [ $handler, 'render_gallery' ], 10, 3 );
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

    public static function get( $attr )
    {
        $args = [];

        if ( !empty( $attr[ 'ids' ] ) )
        {
            $ids =  explode( ',', $attr[ 'ids' ] );

            $args[ 'class' ] = 'columns-3';

            if ( !empty( $attr[ 'columns' ] ) )
            {
                $args[ 'class' ] = 'columns-' . $attr[ 'columns' ];
            }

            // LegalDebug::debug( [
            //     'ReviewGallery' => 'get',

            //     'attr' => $attr,
            // ] );

            foreach ( $ids as $id ) {
                $size = self::SIZE[ 'review' ];
                
                if ( !empty( $attr[ 'size' ] ) )
                {
                    $size = $attr[ 'size' ];
                }
                
                // $review = wp_get_attachment_image_src( $id, $attr[ 'size' ] );
                
                $review = wp_get_attachment_image_src( $id, $size );

                $lightbox = wp_get_attachment_image_src( $id, self::SIZE[ 'lightbox' ] );

                $caption = wp_get_attachment_caption( $id );

                $meta_value = get_post_meta( $id, '_wp_attachment_image_alt', true );

                $alt = ( !empty( $meta_value ) ? $meta_value : $caption );

                if ( $review && $lightbox ) {
                    $args[ 'items' ][] = [
                        'src' => $review[ 0 ],
        
                        'width' => $review[ 1 ],
        
                        'height' => $review[ 2 ],
        
                        'data-src' => $lightbox[ 0 ],
        
                        'caption' => $caption,
        
                        'alt' => $alt,

                        'class' => 'item-image-' . $id,
                    ];
                }
            }
        }

        return $args;
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
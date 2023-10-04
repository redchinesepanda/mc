<?php

class ReviewGroup
{
    const FIELD = [
        'about' => 'review-about',
    ];

    const ABOUT = [
        'title' => 'about-title',
        
        'title-group' => 'about-title-group',
    ];

    const CSS = [
        'review-group' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-group.css',

            'ver' => '1.0.4',
        ],
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

    public static function register()
    {
        $handler = new self();

        // [legal-group]

        add_shortcode( 'legal-group', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    // const TAXONOMY = 'page_group';
    
    const TAXONOMY = [
        'group' => 'page_group',

        'type' => 'page_type',
    ];

    // const TERMS = [
    //     'compilation',
    // ];

    // public static function check()
    // {
    //     $permission_term = !has_term( self::TERMS, self::TAXONOMY[ 'type' ] );

    //     return ReviewMain::check() && $permission_term;
    // }

    public static function get_group_args( $post, $terms = [] ) {
        return [
            'numberposts' => -1,

            'post_type' => [ 'legal_bk_review', 'page' ],

            'suppress_filters' => 0,

            'exclude' => $post->ID,

            'tax_query' => [
                [
                    'taxonomy' => self::TAXONOMY[ 'group' ],

                    'field' => 'term_id',

                    'terms' => $terms,

                    'operator' => 'IN',
                ]
            ],

            'orderby' => 'menu_order',

            'order' => 'ASC',
        ];
    }

    public static function get_term_field( $items, $field )
    {
        return array_map( function( $e ) use ( $field ) {
            return is_object( $e ) ? $e->{$field} : $e[ $field ];
        }, $items);
    }

    public static function get_item_labels()
    {
        return [
            'review' => __( ReviewMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ),
    
            'promo-codes' => __( ReviewMain::TEXT[ 'promo-code' ], ToolLoco::TEXTDOMAIN ),
    
            'bonus' => __( ReviewMain::TEXT[ 'bonus' ], ToolLoco::TEXTDOMAIN ),
            
            'app' => __( ReviewMain::TEXT[ 'app' ], ToolLoco::TEXTDOMAIN ),
    
            'registration' => __( ReviewMain::TEXT[ 'registration' ], ToolLoco::TEXTDOMAIN ),
    
            'how-to-play' => __( ReviewMain::TEXT[ 'how-to-play' ], ToolLoco::TEXTDOMAIN ),
    
            'withdrawal' => __( ReviewMain::TEXT[ 'withdrawal' ], ToolLoco::TEXTDOMAIN ),
        ];
    }

    public static function get_item_label( $post )
    {
        $label = [
            'title' => $post->post_title,

            'type' => '',
        ];

        $type = true;

        $group = get_field( ReviewAbout::FIELD, $post );

        if ( $group )
        {
            $label[ 'title' ] = $group[ self::ABOUT[ 'title' ] ];

            if ( !empty( $group[ self::ABOUT[ 'title-group' ] ] ) )
            {
                $label[ 'title' ] = $group[ self::ABOUT[ 'title-group' ] ];

                $type = false;
            }
        }

        if ( in_array( $post->post_type, [ 'legal_bk_review', 'page' ] ) && $type )
        {
            $terms = wp_get_post_terms( $post->ID, self::TAXONOMY[ 'type' ] );

            if ( !empty( $terms ) )
            {
                $slugs = self::get_term_field( $terms, 'slug' );

                foreach ( self::get_item_labels() as $type => $text )
                {
                    if ( in_array( $type, $slugs ) )
                    {
                        $label[ 'type' ] = $text;
                    }
                }
            } 
        }

        if ( in_array( WPMLMain::current_language(), [ 'ng' ] ) )
        {
            $label = array_reverse( $label );
        }

        return implode( ' ', $label );
    }

    public static function get_terms_ids( $terms )
    {
        $items = [];

        foreach ( $terms as $term )
        {
            if ( !in_array( $term->slug, [ 'other-offers' ] ) )
            {
                $items[] = $term->term_id;
            }
        }

        return $items;
    }

    public static function get()
    {
        $post = get_post();

        if ( empty( $post ) ) {
            return [];
        }

        $items[ 'current' ] = [
            'label' => self::get_item_label( $post ),
        ];
        
        $terms = wp_get_post_terms( $post->ID, self::TAXONOMY[ 'group' ] );

        $ids = self::get_terms_ids( $terms );

        $posts = get_posts( self::get_group_args( $post, $ids ) );

        $items[ 'other' ] = [];

        if ( !empty( $posts ) ) {
            foreach ( $posts as $post ) {

                $items[ 'other' ][] = [
                    'label' => self::get_item_label( $post ),
    
                    'href' => get_post_permalink( $post->ID ),
                ];
            }
        }

        return $items;
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-group.php';

    public static function render()
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
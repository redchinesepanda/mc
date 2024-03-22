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

            'ver' => '1.0.5',
        ],
    ];

    const CSS_NEW = [
        'review-group-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-group-new.css',

			'ver' => '1.0.1',
		],
    ];

    public static function register_style()
    {
		if ( TemplateMain::check_code() )
		{
			ReviewMain::register_style( self::CSS_NEW );
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

    public static function register()
    {
        if ( self::check_has_group() )
        {
            $handler = new self();
    
            // [legal-group]
    
            add_shortcode( 'legal-group', [ $handler, 'render' ] );
    
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        }
    }

    public static function check_has_group()
    {
        return has_term( '', self::TAXONOMY[ 'group' ] );
    }
    
    const TAXONOMY = [
        'group' => 'page_group',

        'type' => 'page_type',
    ];
    
    public static function get_group_args( $post, $terms = [] )
    {
        $args = [
            'numberposts' => -1,

            'post_type' => [ 'page' ],

            'suppress_filters' => 0,

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

        if ( !TemplateMain::check_new() )
        {
            $args[ 'exclude' ] = $post->ID;
        }

        return $args;
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

            'deposit' => __( ReviewMain::TEXT[ 'deposit' ], ToolLoco::TEXTDOMAIN ),
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
            if ( !empty( $group[ self::ABOUT[ 'title' ] ] ) )
            {
                $label[ 'title' ] = $group[ self::ABOUT[ 'title' ] ];
            }

            if ( !empty( $group[ self::ABOUT[ 'title-group' ] ] ) )
            {
                $label[ 'title' ] = $group[ self::ABOUT[ 'title-group' ] ];

                $type = false;
            }
        }

        if ( in_array( WPMLMain::current_language(), [ 'br' ] ) )
        {
            // $label[ 'title' ] = '';

            unset( $label[ 'title' ] );

            $type = true;
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

                // LegalDebug::debug( [
                //     'type' => $type,

                //     'slugs' => $slugs,
                // ] );
            }
        }

        if ( in_array( WPMLMain::current_language(), [ 'ng' ] ) )
        {
            $label = array_reverse( $label );
        }

        // LegalDebug::debug( [
        //     'label' => $label,
        // ] );

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

    // public static function get()
    // {
    //     $post = get_post();

    //     if ( empty( $post ) ) {
    //         return [];
    //     }

    //     $items[ 'current' ] = [
    //         'label' => self::get_item_label( $post ),
    //     ];
        
    //     $terms = wp_get_post_terms( $post->ID, self::TAXONOMY[ 'group' ] );

    //     $ids = self::get_terms_ids( $terms );

    //     $posts = get_posts( self::get_group_args( $post, $ids ) );

    //     $items[ 'other' ] = [];

    //     if ( !empty( $posts ) ) {
    //         foreach ( $posts as $post ) {

    //             $items[ 'other' ][] = [
    //                 'label' => self::get_item_label( $post ),
    
    //                 'href' => get_post_permalink( $post->ID ),
    //             ];
    //         }
    //     }

    //     return $items;
    // }

    const CLASSES = [
        'default' => 'legal-default',
        
        'active' => 'legal-active',
    ];
    
    public static function parse_item( $group, $post )
    {
        return [
            'label' => self::get_item_label( $group ),

            'href' => get_post_permalink( $group->ID ),

            'class' => self::get_class( $group, $post ),
        ];
    }

    public static function get_class( $group, $post )
    {
        return $group->ID == $post->ID ? self::CLASSES[ 'active' ] : self::CLASSES[ 'default' ];
    }

    public static function get()
    {
        $post = get_post();

        if ( empty( $post ) ) {
            return [];
        }

        if ( !TemplateMain::check_new() )
        {
            $items[ 'current' ] = [
                'label' => self::get_item_label( $post ),
            ];
        }
        
        $terms = wp_get_post_terms( $post->ID, self::TAXONOMY[ 'group' ] );

        $ids = self::get_terms_ids( $terms );

        $args = self::get_group_args( $post, $ids );

        $groups = get_posts( $args );

        $items[ 'other' ] = [];

        if ( !empty( $groups ) )
        {
            foreach ( $groups as $group )
            {
                $items[ 'other' ][] = self::parse_item( $group, $post );
            }
        }

        return $items;
    }

    const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/review/review-group.php',

        'new' => LegalMain::LEGAL_PATH . '/template-parts/review/review-group-new.php',
    ];

    public static function render()
    {
        if ( TemplateMain::check_new() )
        {
            return self::render_main( self::TEMPLATE[ 'new' ], self::get() );
        }

        return self::render_main( self::TEMPLATE[ 'main' ], self::get() );
    }

    public static function render_main( $template, $args )
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
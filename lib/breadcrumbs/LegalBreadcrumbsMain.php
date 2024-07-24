<?php

class LegalBreadcrumbsMain extends LegalDebug
{
    const CSS = [
        'legal-breadcrumbs-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/breadcrumbs/legal-breadcrumbs-main.css',

            'ver' => '1.0.2',
        ],
    ];

    const CSS_NEW = [
        'legal-breadcrumbs-new' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/breadcrumbs/legal-breadcrumbs-new.css',

            'ver' => '1.0.3',
        ],
    ];

    public static function register_style()
    {
        if ( self::check() )
        {
            if ( TemplateMain::check_new() )
            {
                ToolEnqueue::register_style( self::CSS_NEW );
            }
            else
            {
                ToolEnqueue::register_style( self::CSS );
            }
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-breadcrumbs]

        add_shortcode( 'legal-breadcrumbs', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    const FIELD_ANCESTOR = 'breadcrumbs-ancestor';

    const TAXONOMY = [
        'category' => 'category',
    ];

    const FIELD = [
        'primary' => '_yoast_wpseo_primary_',
    ];

    public static function get_terms( $id )
    {
        $primary_id = YoastMain::get_primary_term_id( $id, self::TAXONOMY[ 'category' ] );
        
        // $primary_id = false;

        // $items = [];

        // $exclude = [];

        if ( $primary_id )
        {
            $primary = get_term( $primary_id, self::TAXONOMY[ 'category' ] );

            // LegalDebug::debug( [
            //     'LegalBreadcrumbsMain' => 'get_terms',

            //     'primary_id' => $primary_id,

            //     'primary' => $primary,
            // ] );

            if( !empty( $primary ) )
            {
                return [ $primary ];

                // $items[] = $primary;

                // $exclude[] = $primary_id;
            }
        }

        return wp_get_post_terms(
            $id,

            self::TAXONOMY[ 'category' ],

            [
                'orderby' => 'parent',
            ]

            // [ 'ids', 'names' ]
        );  

        // $other = wp_get_post_terms(
        //     $id,

        //     self::TAXONOMY[ 'category' ],

        //     [
        //         'exclude' => $exclude,
        //     ]
        // );

        // return array_merge( $items, $other );
    }

    public static function get_ancestors( $id )
    {
        $post = get_post( $id );

        $ancestor_id = get_field( self::FIELD_ANCESTOR, $id );

        if ( ! $post || empty( $ancestor_id ) || $ancestor_id == $id )
        {
            return [];
        }

        $ancestors[] = $ancestor_id;

        while ( $ancestor = get_post( $ancestor_id ) )
        {
            // LegalDebug::debug( [
            //     'LegalBreadcrumbsMain' => 'get_ancestors',

            //     'ancestor_id' => $ancestor_id,

            //     'ancestor' => $ancestor,
            // ] );

            $parent_id = get_field( self::FIELD_ANCESTOR, $ancestor->ID );

            if ( empty( $parent_id ) || ( $parent_id == $id ) || in_array( $parent_id, $ancestors, true ) )
            {
                break;
            }

            $ancestor_id = $parent_id;

            $ancestors[] = $parent_id;
        }

        return $ancestors;
    }

    const HOME = [
        'ru' => 'kz',

        'esp' => 'es',

        'eng' => '',

        'bp' => 'br',

        'sv' => 'se',

        'da' => 'dk',
    ];

    public static function get_home_url()
    {
        // LegalDebug::debug( [
        //     'LegalBreadcrumbsMain' => 'get_home_url-1',
        // ] );

        if ( get_option( 'show_on_front' ) === 'page' ) {
			$homepage_id = get_option( 'page_on_front' );

			if ( empty( $homepage_id ) ) {
				$homepage_url = get_option( 'home' );
			} else {
				$homepage_url = get_page_link( $homepage_id );
			}
		} else {
			$homepage_url = get_option( 'home' );
		}

        // LegalDebug::debug( [
        //     'LegalBreadcrumbsMain' => 'get_home_url-1',
        // ] );

        $lang = WPMLMain::current_language();

        // LegalDebug::debug( [
        //     'homepage_url' => $homepage_url,

        //     'lang' => $lang,

        //     'lang-new' => self::HOME[ $lang ],

        //     'array_key_exists' => array_key_exists( $lang, self::HOME ) ? 'true' : 'false',
        // ] );
        
        if ( array_key_exists( $lang, self::HOME ) )
        {
            $homepage_url = LegalMain::LEGAL_ROOT . '/' . self::HOME[ $lang ];

            if ( !empty( self::HOME[ $lang ] ) ) {
                $homepage_url .= '/';
            }

            $homepage_url = WPMLMain::locale_permalink( $homepage_url, self::HOME[ $lang ] );
        }

        // LegalDebug::debug( [
        //     'homepage_url' => $homepage_url,

        //     'HOME' => self::HOME,
        // ] );

        return $homepage_url;
    }

    public static function get_item( $text, $href, &$index )
    {
        $link = [];

        if ( !empty( $href ) )
        {
            $link = [
                'href' => $href,

                'itemprop' => 'item',
            ];
        }

        return [
            'title' => [
                'text' => $text,

                'itemprop' => 'name',
            ],

            'link' => $link,

            'meta' => [
                'content' => $index++,

                'itemprop' => 'position',
            ],
        ];
    }

    const FIELD_CATEGORY = [
        'exclude' => 'category-breadcrumbs-exclude',
    ];

    const FIELD_HIDE = 'breadcrumbs-hide-parent';

    const FIELD_ITEMS = 'breadcrumbs-items';

    const ITEM = [
        'id' => 'item-id',

        'label' => 'item-label',
    ];

    // public static function check_term_link( $href )
    // {
    //     if ( str_contains() )
    //     {}
    // }

    public static function check_post_status( $id )
    {
        if ( empty( $id ) )
		{
			return false;
		}

		return get_post_status( $id );
    }

    public static function get()
    {
        $id = 0;

        $post = get_post();

        if ( !empty( $post ) )
        {
            $post_id = $post->ID;
        }

        // LegalDebug::debug( [
        //     'LegalBreadcrumbsMain' => 'get',

        //     'post_id' => $post_id,
        // ] );

        $index = 1;

        $items = [];
        
        $first = self::get_item( __( BaseMain::TEXT[ 'match-center' ], ToolLoco::TEXTDOMAIN ), self::get_home_url(), $index );

        if ( !empty( $post_id ) )
        {
            $hide = get_field( self::FIELD_HIDE, $post_id );

            // LegalDebug::debug( [
            //     'LegalBreadcrumbsMain' => 'get',
    
            //     'hide' => $hide,
            // ] );

            // if ( empty( get_field( self::FIELD_HIDE, $post_id ) ) )
            
            if ( empty( $hide ) )
            {
                $legal_items = get_field( self::FIELD_ITEMS, $post_id );

                // LegalDebug::debug( [
                //     'LegalBreadcrumbsMain' => 'get',
        
                //     'legal_items' => $legal_items,
                // ] );

                if ( !empty( $legal_items ) )
                {
                    foreach( $legal_items as $item )
                    {
                        // LegalDebug::debug( [
                        //     'LegalBreadcrumbsMain' => 'get',
                
                        //     'item' => $item,
                        // ] );

                        $title = ( !empty( $item[ self::ITEM[ 'label' ] ] ) ? $item[ self::ITEM[ 'label' ] ] : get_the_title( $item[ self::ITEM[ 'id' ] ] ) );

                        $item_id = $item[ self::ITEM[ 'id' ] ];

                        $href = '#';

                        // LegalDebug::debug( [
                        //     'LegalBreadcrumbsMain' => 'get-1',
                        // ] );

                        if ( self::check_post_status( $item_id ) )
                        {
                            $href = get_page_link( $item_id );
                        }

                        // LegalDebug::debug( [
                        //     'LegalBreadcrumbsMain' => 'get-2',
                        // ] );

                        // $href = get_page_link( $item[ self::ITEM[ 'id' ] ] );

                        // LegalDebug::debug( [
                        //     'LegalBreadcrumbsMain' => 'get',
                
                        //     'title' => $title,

                        //     'item_id' => $item_id,

                        //     // 'href' => $href,
                        // ] );

                        // $items[] = self::get_item( $title, get_page_link( $item[ self::ITEM[ 'id' ] ] ), $index );
                        
                        $items[] = self::get_item( $title, $href, $index );

                        // LegalDebug::debug( [
                        //     'LegalBreadcrumbsMain' => 'get',
                
                        //     'items' => $items,
                        // ] );
                    }
                }

                // LegalDebug::debug( [
                //     'LegalBreadcrumbsMain' => 'get',
        
                //     'items' => $items,
                // ] );

                if ( empty( $items ) )
                {
                    $legal_ancestors = array_reverse( self::get_ancestors( $post_id ) );

                    LegalDebug::debug( [
                        'LegalBreadcrumbsMain' => 'get-1',
                    ] );

                    if ( !empty( $legal_ancestors ) ) {
                        foreach ( $legal_ancestors as $id ) {
                            if ( ! mepty( $id ) )
                            {
                                $items[] = self::get_item( get_the_title( $id ), get_page_link( $id ), $index );
                            }
                        }
                    }

                    LegalDebug::debug( [
                        'LegalBreadcrumbsMain' => 'get-2',
                    ] );
                }

                if ( empty( $items ) )
                {
                    // LegalDebug::debug( [
                    //     'LegalBreadcrumbsMain' => 'get',
                    // ] );

                    $legal_terms = self::get_terms( $post_id );

                    if ( !empty( $legal_terms ) ) {
                        foreach ( $legal_terms as $term ) {
                            $exclude = get_field( self::FIELD_CATEGORY[ 'exclude' ], $term );

                            if ( !$exclude ) {
                                $items[] = self::get_item( $term->name, get_term_link( $term->term_id ), $index );

                                // LegalDebug::debug( [
                                //     'LegalBreadcrumbsMain' => 'get',
        
                                //     '$items' => $items,

                                //     '$term->term_id' => $term->term_id,
                                // ] );
                            }
                        }

                        // LegalDebug::debug( [
                        //     'LegalBreadcrumbsMain' => 'get',

                        //     '$items' => $items,
                        // ] );
                    }
                }

                if ( empty( $items ) && $post->post_parent )
                {
                    $ancestors = array_reverse( get_post_ancestors( $post_id ) );

                    // LegalDebug::debug( [
                    //     'LegalBreadcrumbsMain' => 'get',

                    //     '$ancestors' => $ancestors,
                    // ] );
    
                    foreach ( $ancestors as $id )
                    {
                        $items[] = self::get_item( get_the_title( $id ), get_page_link( $id ), $index );
                    }
                }
            }

            $items[] = self::get_item( $post->post_title, '', $index );
        }

        array_unshift( $items, $first );

        // LegalDebug::debug( [
        //     'LegalBreadcrumbsMain' => 'get',

        //     'items' => $items,
        // ] );

        return $items;
    }

    public static function check()
    {
        $not_front_page = !is_front_page();

        return $not_front_page;
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/breadcrumbs/part-breadcrumbs-main.php';

    public static function render()
    {
        if ( !self::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function get_schema_data()
    {
        $items = self::get();

        $args = [];

        foreach ( $items as $item ) {
            $args[] = [
                "@type" => "ListItem",

                "position" => $item[ 'meta' ][ 'content' ],

                "item" => [
                    // "@id" => ( !empty( $item[ 'link' ][ 'href' ] ) ? $item[ 'link' ][ 'href' ] : get_post_permalink() ),
                    
                    "@id" => ( !empty( $item[ 'link' ][ 'href' ] ) ? $item[ 'link' ][ 'href' ] : get_permalink() ),

                    "name" => $item[ 'title' ][ 'text' ],
                ],
            ];
        }

        return $args;
    }

    public static function schema()
    {
        if ( !self::check() )
        {
            return [];
        }

        return [
            "@context" => "https://schema.org",

            "@type" => "BreadcrumbList",

            "name" => 'Legal Breadcrumbs',

            "itemListElement" => self::get_schema_data(),
        ];
    }
}

?>
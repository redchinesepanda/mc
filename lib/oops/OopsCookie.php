<?php

class OopsCookie
{
    const TAXONOMY = [
		'page-type' => 'page_type',
	];

	const PAGE_TYPE = [
		'privacy-policy' => 'legal-privacy-policy',
	];

	const CSS = [
		'legal-oops-cookie' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/legal-oops-cookie.css',

            'ver' => '1.0.6',
        ],
    ];

    const CSS_NEW = [
        'legal-oops-cookie-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/oops/legal-oops-cookie-new.css',

			'ver' => '1.0.0',
		],
    ];

/*     public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    } */

    public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                if ( TemplateMain::check_new() )
                {
                    $styles = self::CSS_NEW;
                }
                else
                {
                    $styles = self::CSS;
                }
            }

            ToolEnqueue::register_style( $styles );
        }
    }

    const JS = [
        'legal-oops-cookie' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/oops/legal-oops-cookie.js',

			'ver' => '1.0.3',

            'deps' => [ 'legal-lib-cookie' ],
		],
    ];

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            if ( empty( $scripts ) ) {
                $scripts = self::JS;
            }

            ToolEnqueue::register_script( $scripts );
        }
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

	// public static function check_post_type()
    // {
    //     return is_singular( [ 'post' ] );
    // }

	// public static function check_not_wiki_thrive()
    // {
    //     return !WikiMain::check_thrive();
    // }

	public static function check()
    {
        // LegalDebug::debug( [
        //     'check_post_type' => OopsMain::check_post_type(),

        //     'check_not_wiki_thrive' => OopsMain::check_not_wiki_thrive(),
        // ] );

		// return OopsMain::check_post_type() && OopsMain::check_not_wiki_thrive();

        // return OopsMain::check_template();

        return true;
    }

	// public static function get_privacy_policy_query()
	
    public static function get_privacy_policy_query( $page_type = [] )
	{
        if ( empty( $page_type ) )
        {
            $page_type = self::PAGE_TYPE;
        }

		return [
			'posts_per_page' => -1,
			
			'post_type' => 'page',

			'tax_query' => [
				[
					'taxonomy' => self::TAXONOMY[ 'page-type' ],
					
					// 'terms' => self::PAGE_TYPE,
					
                    'terms' => $page_type,

					'field' => 'slug',

					'operator' => 'IN',
				],
			],

			'fields' => 'ids',

            // 'supress_filter' => false,
		];
	}

	public static function get_privacy_policy_pages( $page_type )
    {
        $privacy_policy_query = self::get_privacy_policy_query( $page_type );

        // LegalDebug::debug( [
        //     'OopsCookie' => 'get_privacy_policy_pages-1',

        //     'privacy_policy_query' => $privacy_policy_query,
        // ] );

        return get_posts( $privacy_policy_query );
    }

    // public static function get_domain_main_site_privacy_policy_page( $page_type )
    // {
    //     $main_blog_id = MultisiteBlog::get_domain_main_blog_id();

    //     MultisiteBlog::set_blog( $main_blog_id );

    //     $pages = self::get_privacy_policy_pages( $page_type );

    //     MultisiteBlog::restore_blog();

    //     LegalDebug::debug( [
    //         'OopsCookie' => 'get_domain_main_site_privacy_policy_page-1',

    //         'pages' => $pages,
    //     ] );

    //     if ( ! empty( $pages ) )
	// 	{
	// 		return array_shift( $pages );
	// 	}

	// 	return null;
    // }

    public static function get_privacy_policy_page( $page_type )
	{
		$pages = self::get_privacy_policy_pages( $page_type );

        // LegalDebug::debug( [
        //     'OopsCookie' => 'get_privacy_policy_page-1',

        //     'pages' => $pages,
        // ] );

		if ( ! empty( $pages ) )
		{
			return array_shift( $pages );
		}

		return null;
	}

    public static function get_privacy_policy_wpml_url( $href, $anchor = '' )
    {
        if ( empty( $href ) )
        {
            $href = '/privacy-policy/';
        }

        if ( $page = get_page_by_path( $href ) )
        {
            if ( $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type ) )
            {
                $href = get_page_link( $translated_id );
            }
        }

        return $href . $anchor;
    }

    public static function get_privacy_policy_page_permalink( $page_type, $anchor = '' )
    {
        $page = self::get_privacy_policy_page( $page_type );

		if ( ! empty( $page ) )
		{
            // LegalDebug::debug( [
            //     'OopsCookie' => 'get_privacy_policy_page_type_url',

            //     'get_permalink' => get_permalink( $page ),

            //     'get_post_permalink' => get_post_permalink( $page ),

            //     'get_page_link' => get_page_link( $page ),
            // ] );

			if ( $page_url = get_permalink( $page ) )
			{
				return $page_url . $anchor;
			}
		}

        return '';
    }

    public static function get_privacy_policy_page_type_url( $page_type, $href = '', $anchor = '' )
	{
		// $page = self::get_privacy_policy_page( $page_type );

		// if ( ! empty( $page ) )
		// {
        //     // LegalDebug::debug( [
        //     //     'OopsCookie' => 'get_privacy_policy_page_type_url',

        //     //     'get_permalink' => get_permalink( $page ),

        //     //     'get_post_permalink' => get_post_permalink( $page ),

        //     //     'get_page_link' => get_page_link( $page ),
        //     // ] );

		// 	if ( $page_url = get_permalink( $page ) )
		// 	{
		// 		return $page_url . $anchor;
		// 	}
		// }

        $page_permalink = self::get_privacy_policy_page_permalink( $page_type, $anchor );

        if ( ! empty( $page_permalink ) )
        {
            return $page_permalink;
        }

        $domain = MultisiteBlog::get_domain();

        $blog_language = MultisiteSiteOptions::get_blog_language();

        $breadcrumbs_language = LegalBreadcrumbsMain::get_breadcrumbs_language( $blog_language );

        $path = '/';

        if ( ! empty( $breadcrumbs_language ) )
        {
            $path = sprintf( '/%s/', $breadcrumbs_language );
        }

        // $blog_language_site = MultisiteBlog::get_domain_path_site( $domain, $path );

        $domain_path_blog_id = MultisiteBlog::get_domain_path_blog_id( $domain, $path );

        // LegalDebug::debug( [
        //     'OopsCookie' => 'get_privacy_policy_page_type_url-1',

        //     'blog_language' => $blog_language,

        //     'breadcrumbs_language' => $breadcrumbs_language,

        //     'path' => $path,

        //     // 'blog_language_site' => $blog_language_site,

        //     'domain_path_blog_id' => $domain_path_blog_id,
        // ] );

        // $main_blog_id = MultisiteBlog::get_domain_main_blog_id();

        // MultisiteBlog::set_blog( $main_blog_id );
        
        MultisiteBlog::set_blog( $domain_path_blog_id );

        $domain_main_blog_page_permalink = self::get_privacy_policy_page_permalink( $page_type, $anchor );

        MultisiteBlog::restore_blog();

        if ( ! empty( $domain_main_blog_page_permalink ) )
        {
            return $domain_main_blog_page_permalink;
        }

        if ( empty( $href ) )
        {
            $href = '/privacy-policy/';
        }

		return $href . $anchor;

        // return self::get_privacy_policy_wpml_url();

        // return '';
	}

    public static function get_privacy_policy_url( $page_type = [], $href = '', $anchor = '' )
    {
        // LegalDebug::debug( [
        //     'get_privacy_policy_page_type_url' => self::get_privacy_policy_page_type_url(),

        //     'get_privacy_policy_wpml_url' => self::get_privacy_policy_wpml_url(),
        // ] );

        if ( MultisiteMain::check_multisite() )
        {
            if ( MultisiteBlog::check_not_main_blog() )
            {
                return self::get_privacy_policy_page_type_url( $page_type, $href, $anchor );
            }
        }

        return self::get_privacy_policy_wpml_url( $href, $anchor );

        // return '/privacy-policy/';
    }

	public static function get()
    {
        $href = self::get_privacy_policy_url();

        // $href = '/privacy-policy/';

        // if ( $page = get_page_by_path( '/privacy-policy/' ) )
        // {
        //     if ( $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type ) )
        //     {
        //         $href = get_page_link( $translated_id );
        //     }
        // }

        // $page = get_page_by_path( '/privacy-policy/' );

        // $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        // $href = get_page_link( $translated_id );

        // LegalDebug::debug( [
        //     'OopsCookie' => 'get',

        //     'translated_id' => $translated_id,

        //     'value' => $translated_id ? 'yes' : 'no',
        // ] );

        return  [
            'title' => __( BaseMain::TEXT[ 'сookies' ], ToolLoco::TEXTDOMAIN ),

            'description' => __( BaseMain::TEXT[ 'to-give' ], ToolLoco::TEXTDOMAIN ),

            'privacy' => [
                'href' => $href,

                'label' => __( BaseMain::TEXT[ 'more-information' ], ToolLoco::TEXTDOMAIN ),
            ],

			'label-necessary' => __( BaseMain::TEXT[ 'accept-necessary' ], ToolLoco::TEXTDOMAIN ),

			'label-all' => __( BaseMain::TEXT[ 'accept-all' ], ToolLoco::TEXTDOMAIN ),
        ];
    }

	const TEMPLATE = [
        'legal-oops-cookie' => LegalMain::LEGAL_PATH . '/template-parts/oops/legal-oops-cookie.php',
    ];

    public static function render()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'legal-oops-cookie' ], self::get() );
    }

    // public static function render()
    // {
    //     if ( !self::check() ) {
    //         return '';
    //     }

    //     ob_start();

    //     load_template( self::TEMPLATE[ 'legal-oops-cookie' ], false, self::get() );

    //     $output = ob_get_clean();

    //     return $output;
    // }
}

?>
<?php

class ReviewAuthor
{
    const CSS = [
        'review-author' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-author.css',

            'ver'=> '1.0.3',
        ],
    ];

    const CSS_NEW = [
        'review-author-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-author-new.css',

			'ver' => '1.0.0',
		],
    ];

   /*  public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    } */

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_style( self::CSS_NEW );
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

    public static function register_inline_style()
    {
		ReviewMain::register_inline_style( 'review-author', self::render_style() );
    }

    public static function register()
    {
        $handler = new self();

        // [legal-author]

        add_shortcode( 'legal-author', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
    }

    const FIELD = [
        'author' => 'media-author',
    ];

    const AUTHOR = [
        'name' => 'author-name',

        'post' => 'author-post',

        'items' => 'author-link-items',
    ];

    const LINK_ITEM = [
        'url' => 'link-item-url',

        'image' => 'link-item-image',
    ];

    // public static function check()
    // {
    //     $permisiion_review_main = ReviewMain::check();

    //     $permission_post_type = is_singular( [ 'post' ] );

    //     return $permisiion_review_main || $permission_post_type;
    // }

    const CIS = [
        'ru',

        'kz',

        'kz-kz',

        'by',

        'ua',

        'ua-ru',
    ];

    const ES = [
        'es',

        'mx',

        'pe',

        'cl',

        'py',

        'co',

        'ar',
    ];

    public static function get()
    {
        $language = WPMLMain::current_language();

        if ( in_array( $language, self::CIS ) )
        {
            return self::get_cis();
        }

        if ( in_array( $language, self::ES ) )
        {
            return self::get_es();
        }

        return self::get_default();
    }

	const PAGE_TYPE = [
		'about-us' => 'legal-about-us',
	];

    public static function get_about_us_url( $id, $href, $anchor = '' )
    {
        if ( MiltisiteMain::check_multisite() )
        {
            if ( MultisiteBlog::check_not_main_blog() )
            {
                return OopsCookie::get_privacy_policy_page_type_url( self::PAGE_TYPE );
            }
        }

        return self::get_about_us_wpml_url( $id, $href, $anchor );
    }
    
    public static function get_about_us_wpml_url( $id, $url, $anchor = '' )
    {
        $page_link = $url;

        // $page = get_page_by_path( $url, OBJECT, [ 'page' ] );

        $page = get_post( $id );

        // LegalDebug::debug( [
        //     'function' => 'get_href',

        //     '$url' => $url,

        //     '$anchor' => $anchor,

        //     '$page' => $page,
        // ] );

        if ( !empty( $page ) )
        {
            $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

            // LegalDebug::debug( [
            //     'function' => 'get_href',
    
            //     '$translated_id' => $translated_id,
            // ] );

            if ( !empty( $translated_id ) )
            {
                $page_link = get_page_link( $translated_id );
            }

            // LegalDebug::debug( [
            //     'function' => 'get_href',
    
            //     '$page_link' => $page_link,
            // ] );

        }
        
        return $page_link . $anchor;
    }

    public static function get_default()
    {
        // $href = self::get_href( 4739, '/about-us/', '#our-team' );
        
        $href = self::get_about_us_url( 4739, '/about-us/', '#our-team' );

        // $page = get_page_by_path( '/about-us/' );

        // $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        // $href = get_page_link( $translated_id ) . '#our-team';

        return [
			'name' => __( ReviewMain::TEXT[ 'valentin-axani' ], ToolLoco::TEXTDOMAIN ),

			'duty' => __( ReviewMain::TEXT[ 'website-manager' ], ToolLoco::TEXTDOMAIN ),

			'file' => LegalMain::LEGAL_URL . '/assets/img/review/author/valentin-axani.webp',

			'href' => $href,
		];
    }

    public static function get_cis()
    {
        // $href = self::get_href( '/o-nas/', $anchor = '#nasha-komanda' );
        
        // $href = self::get_href( 10764, '/kz/o-nas/', '#nasha-komanda' );
        
        $href = self::get_about_us_url( 10764, '/kz/o-nas/', '#nasha-komanda' );
        
        // $href = self::get_href( 'o-nas-kz', $anchor = '#nasha-komanda' );

        // $page = get_page_by_path( '/o-nas/' );

        // $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        // $href = get_page_link( $translated_id ) . '#nasha-komanda';

        // LegalDebug::debug( [
        //     'function' => 'get_cis',

        //     '$href' => $href,
        // ] );

        return [
			'name' => __( ReviewMain::TEXT[ 'alexander-kachalov' ], ToolLoco::TEXTDOMAIN ),

			'duty' => __( ReviewMain::TEXT[ 'website-administrator' ], ToolLoco::TEXTDOMAIN ),

			'file' => LegalMain::LEGAL_URL . '/assets/img/review/author/alexander-kachalov.webp',

			'href' => $href,
		];
    }

    public static function get_es()
    {
        // $href = self::get_href( 4758, '/es/sobre-nosotros/', '#nuestro-equipo' );
        
        $href = self::get_about_us_url( 4758, '/es/sobre-nosotros/', '#nuestro-equipo' );
        
        // $href = self::get_href( '/sobre-nosotros/', $anchor = '#nuestro-equipo' );

        // $page = get_page_by_path( '/sobre-nosotros/' );

        // $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        // $href = get_page_link( $translated_id ) . '#nuestro-equipo';

        return [
			'name' => __( ReviewMain::TEXT[ 'borja-imbergamo' ], ToolLoco::TEXTDOMAIN ),

			'duty' => __( ReviewMain::TEXT[ 'website-administrator' ], ToolLoco::TEXTDOMAIN ),

			'file' => LegalMain::LEGAL_URL . '/assets/img/review/author/borja-imbergamo.webp',

			'href' => $href,
		];
    }

    const TEMPLATE = [
		'main' =>  LegalMain::LEGAL_PATH . '/template-parts/review/review-author-main.php',

		'style' =>  LegalMain::LEGAL_PATH . '/template-parts/review/review-author-style.php',
	];

    public static function render()
    {
        return self::render_section();
    }

    public static function render_section()
    {
        if ( !TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get() );
        }
    }

    public static function render_block()
    {
        if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get() );
        }
    }

    // public static function render()
    // {
    //     if ( !ReviewMain::check() )
    //     {
    //         return '';
    //     }
        
    //     ob_start();

    //     load_template( self::TEMPLATE[ 'main' ], false, self::get() );

    //     $output = ob_get_clean();

    //     return $output;
    // }

    public static function render_style()
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }
        
        ob_start();

        load_template( self::TEMPLATE[ 'style' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
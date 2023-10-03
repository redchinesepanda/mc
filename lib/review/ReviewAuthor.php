<?php

class ReviewAuthor
{
    const CSS = [
        'review-author' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-author.css',

            'ver'=> '1.0.2',
        ],
    ];

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

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
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
    }

    // public static function check()
    // {
    //     $permisiion_review_main = ReviewMain::check();

    //     $permission_post_type = is_singular( [ 'post' ] );

    //     return $permisiion_review_main || $permission_post_type;
    // }

    const CIS = [
        'ru',

        'kz',

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

    public static function get_default()
    {
        $page = get_page_by_path( '/about-us/' );

        $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        $href = get_page_link( $translated_id ) . '#our-team';

        return [
			'name' => __( ReviewMain::TEXT[ 'valentin-axani' ], ToolLoco::TEXTDOMAIN ),

			'duty' => __( ReviewMain::TEXT[ 'website-manager' ], ToolLoco::TEXTDOMAIN ),

			'file' => LegalMain::LEGAL_URL . '/assets/img/review/author/valentin-axani.webp',

			'href' => $href,
		];
    }

    public static function get_cis()
    {
        $page = get_page_by_path( '/o-nas/' );

        $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        $href = get_page_link( $translated_id ) . '#nasha-komanda';

        return [
			'name' => __( ReviewMain::TEXT[ 'alexander-kachalov' ], ToolLoco::TEXTDOMAIN ),

			'duty' => __( ReviewMain::TEXT[ 'website-administrator' ], ToolLoco::TEXTDOMAIN ),

			'file' => LegalMain::LEGAL_URL . '/assets/img/review/author/alexander-kachalov.webp',

			'href' => $href,
		];
    }

    public static function get_es()
    {
        $page = get_page_by_path( '/sobre-nosotros/' );

        $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        $href = get_page_link( $translated_id ) . '#nuestro-equipo';

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
        if ( !ReviewMain::check() )
        {
            return '';
        }
        
        ob_start();

        load_template( self::TEMPLATE[ 'main' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

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
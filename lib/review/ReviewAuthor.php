<?php

class ReviewAuthor
{
    const CSS = [
        'review-author' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-author.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        // ReviewMain::register_style( self::CSS );
        
        ToolEnqueue::register_style( self::CSS );
    }

    public static function register()
    {
        $handler = new self();

        // [legal-author]

        add_shortcode( 'legal-author', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    public static function get()
    {
        $page = get_page_by_path( '/about-us/' );
        
        $page_link = WPMLMain::element_link( $page->ID );

        $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        $translated_link = get_page_link( $translated_id );

        $url = LegalMain::LEGAL_ROOT . '/about-us/';
        
        $locale = WPMLMain::current_language();

		$href = WPMLMain::locale_permalink( $url, $locale ) . '#our-team';

        LegalDebug::debug( [
            'page' => $page->ID,

            'page_link' => $page_link,

            'translated_id' => $translated_id,

            'translated_link' => $translated_link,

            'url' => $url,

            'locale' => $locale,

            'href' => $href,
        ] );

        return [
			'name' => __( 'Valentin Axani', ToolLoco::TEXTDOMAIN ),

			'duty' => __( 'Website Manager', ToolLoco::TEXTDOMAIN ),

			'file' => LegalMain::LEGAL_URL . '/assets/img/review/author/valentin-axani.webp',

			'href' => $href,
		];
    }

    const TEMPLATE = [
		'review-author' =>  LegalMain::LEGAL_PATH . '/template-parts/review/review-author.php',
	];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'review-author' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
<?php

class ReviewAuthor
{
    const CSS = [
        'review-author' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-author.css',

            'ver'=> '1.0.1',
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

        $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        $href = get_page_link( $translated_id ) . '#our-team';

        return [
			'name' => __( ReviewMain::TEXT[ 'valentin-axani' ], ToolLoco::TEXTDOMAIN ),

			'duty' => __( ReviewMain::TEXT[ 'website-manager' ], ToolLoco::TEXTDOMAIN ),

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
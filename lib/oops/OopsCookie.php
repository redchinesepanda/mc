<?php

class OopsCookie
{
	const CSS = [
		'legal-oops-cookie' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/legal-oops-cookie.css',

            'ver' => '1.0.3',
        ],
    ];

    public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    }

    const JS = [
        'legal-oops-cookie' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/oops/legal-oops-cookie.js',

			'ver' => '1.0.0',

            'deps' => [ 'legal-lib-cookie' ],
		],

        'legal-lib-cookie' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/oops/legal-lib-cookie.js',

            'ver' => '1.0.0',
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

	public static function check()
    {
		$permission_post_type = is_singular( [ 'post' ] );

		$permission_not_wiki = !TemplateWiki::check();

        return $permission_post_type && $permission_not_wiki;
    }

	public static function get()
    {
        $page = get_page_by_path( '/privacy-policy/' );

        $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type );

        $href = get_page_link( $translated_id );

        return  [
            'description' => __( BaseMain::TEXT[ 'to-give' ], ToolLoco::TEXTDOMAIN ),

            'privacy' => [
                'href' => $href,

                'label' => __( BaseMain::TEXT[ 'more-information' ], ToolLoco::TEXTDOMAIN ),,
            ],

			'label' => __( BaseMain::TEXT[ 'i-accept' ], ToolLoco::TEXTDOMAIN ),
        ];
    }

	const TEMPLATE = [
        'legal-oops-cookie' => LegalMain::LEGAL_PATH . '/template-parts/oops/legal-oops-cookie.php',
    ];

    public static function render()
    {
        if ( !self::check() ) {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-oops-cookie' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
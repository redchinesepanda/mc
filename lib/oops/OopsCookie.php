<?php

class OopsCookie
{
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

    public static function get_localize()
	{
		return [
			'legal-lib-cookie' => [
				'object_name' => 'legalHeaderCutText',
	
				'data' => [
					'default' => __( BaseMain::TEXT[ 'show-all' ], ToolLoco::TEXTDOMAIN ),
	
					'active' => __( BaseMain::TEXT[ 'hide' ], ToolLoco::TEXTDOMAIN ),
				],
			],
		];
	}

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            if ( empty( $scripts ) ) {
                $scripts = self::JS;
            }

            ToolEnqueue::register_script( $scripts );

            ToolEnqueue::localize_script( self::get_localize() );
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

	public static function get()
    {
        $href = '/privacy-policy/';

        if ( $page = get_page_by_path( '/privacy-policy/' ) )
        {
            if ( $translated_id = WPMLMain::translated_menu_id( $page->ID, $page->post_type ) )
            {
                $href = get_page_link( $translated_id );
            }
        }

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
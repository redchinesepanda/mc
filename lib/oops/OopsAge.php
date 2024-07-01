<?php

class OopsAge
{
	const CSS = [
		'legal-oops-age' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/legal-oops-age.css',

            'ver' => '1.0.5',
        ],
    ];

    const CSS_NEW = [
        'legal-oops-age-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/oops/legal-oops-age-new.css',

			'ver' => '1.0.0',
		],
    ];

   /*  public static function register_style( $styles = [] )
    {
        if ( self::check() )
		{
            ToolEnqueue::register_style( self::CSS );
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

    // const JS = [
    //     'legal-oops-age' => [
	// 		'path' => LegalMain::LEGAL_URL . '/assets/js/oops/legal-oops-age.js',

	// 		'ver' => '1.0.1',

    //         'deps' => [ 'legal-lib-cookie' ],
	// 	],
    // ];

	// public static function register_script( $scripts = [] )
    // {
    //     if ( self::check() )
	// 	{
    //         ToolEnqueue::register_script( self::JS );
    //     }
    // }

	public static function register()
    {
        if ( self::check() )
        {
            $handler = new self();
    
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    
            // add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
        }
    }

	const AGE_DEBUG = [
		'es',

		'hr',

        // 'kz',

        // 'dk',
	];

	const AGE_PRODUCTION = [
		'es',

		'hr',
	];

	public static function check_locale()
    {
        $current_language = self::AGE_DEBUG;

        // if ( LegalMain::check_host_production() )
        
        if ( LegalHosts::check_host_production() )
        {
            $current_language = self::AGE_PRODUCTION;
        }

        return in_array( WPMLMain::current_language(), $current_language );
    }
    
	public static function check()
    {
		// $permission_post_type = is_singular( [ 'post' ] );

		// $permission_not_wiki = !TemplateWiki::check();

		// $lang = WPMLMain::current_language();

		// $permission_age = in_array( $lang, self::AGE );

        // return self::check_locale() && OopsMain::check_post_type() && OopsMain::check_not_wiki_thrive();
        
        // return self::check_locale() && OopsMain::check_template();
        
        return self::check_locale();
    }

	public static function get()
    {
		$lang = WPMLMain::current_language();

        return [
            // 'title' => __( BaseMain::TEXT[ 'this-website' ], ToolLoco::TEXTDOMAIN ),

            'title' => __( BaseMain::TEXT[ 'do-you-confirm' ], ToolLoco::TEXTDOMAIN ),

            // 'description' => __( BaseMain::TEXT[ 'you-re-of' ], ToolLoco::TEXTDOMAIN ),

            'description' => __( BaseMain::TEXT[ 'according-to-the-law' ], ToolLoco::TEXTDOMAIN ),
            
			'button-yes' => [
				'label' => __( BaseMain::TEXT[ 'yes' ], ToolLoco::TEXTDOMAIN ),

				'href' => '',
			],

			'button-no' => [
				'label' => __( BaseMain::TEXT[ 'no' ], ToolLoco::TEXTDOMAIN ),

				// 'href' => 'http://google.' . $lang . '/',

                'href' => '#',
			],
            
			'after' => __( BaseMain::TEXT[ 'you-must-be' ], ToolLoco::TEXTDOMAIN ),

            'you-shure' => __( BaseMain::TEXT[ 'we-are-sorry' ], ToolLoco::TEXTDOMAIN ),
        ];
    }

	const TEMPLATE = [
        'legal-oops-age' => LegalMain::LEGAL_PATH . '/template-parts/oops/legal-oops-age.php',
    ];

    public static function render()
    {
        if ( !self::check() ) {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-oops-age' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
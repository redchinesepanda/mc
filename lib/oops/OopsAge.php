<?php

class OopsAge
{
	const CSS = [
		'legal-oops-age' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/legal-oops-age.css',

            'ver' => '1.0.2',
        ],
    ];

    public static function register_style( $styles = [] )
    {
        if ( self::check() )
		{
            ToolEnqueue::register_style( self::CSS );
        }
    }

    const JS = [
        'legal-oops-age' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/oops/legal-oops-age.js',

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
        if ( self::check() )
		{
            ToolEnqueue::register_script( self::JS );
        }
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

	const AGE = [
		'es',

		'hr',
	];

	public static function check()
    {
		$permission_post_type = is_singular( [ 'post' ] );

		$permission_not_wiki = !TemplateMain::check_wiki();

		$lang = WPMLMain::current_language();

		$permission_age = !in_array( $lang, self::AGE );

        return $permission_post_type && $permission_not_wiki && $permission_age;
    }

	public static function get()
    {
		$lang = WPMLMain::current_language();

        return [
            'title' => __( BaseMain::TEXT[ 'this-website' ], ToolLoco::TEXTDOMAIN ),

            'description' => __( BaseMain::TEXT[ 'you-re-of' ], ToolLoco::TEXTDOMAIN ),
            
			'button-yes' => [
				'label' => __( BaseMain::TEXT[ 'yes' ], ToolLoco::TEXTDOMAIN ),

				'href' => '',
			],

			'button-no' => [
				'label' => __( BaseMain::TEXT[ 'no' ], ToolLoco::TEXTDOMAIN ),

				'href' => 'http://google.' . $lang . '/',
			],
            
			'after' => __( BaseMain::TEXT[ 'you-must-be' ], ToolLoco::TEXTDOMAIN ),
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
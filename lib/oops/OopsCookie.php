<?php

class OopsCookie
{
	const CSS = [
        'legal-cookie' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/cookie.css',

            'ver' => '1.0.2',
        ],

        'legal-cookie-lib' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/lib-cookie.css',

            'ver' => '1.0.0',
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
        'legal-cookie' => LegalMain::LEGAL_URL . '/assets/js/oops/cookie.js',
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

		$permission_not_wiki = !TemplateMain::check_wiki();

        return $permission_post_type && $permission_not_wiki;
    }

	public static function get()
    {
        return  [
            'description' => __( BaseMain::TEXT[ 'to-give' ], ToolLoco::TEXTDOMAIN ),

			'label' => __( BaseMain::TEXT[ 'i-accept' ], ToolLoco::TEXTDOMAIN ),
        ];
    }

	const TEMPLATE = [
        'legal-cookie' => LegalMain::LEGAL_PATH . '/template-parts/oops/cookie.php',
    ];

    public static function render()
    {
        if ( !self::check() ) {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-cookie' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
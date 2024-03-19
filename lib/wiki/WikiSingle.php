<?php

class WikiSingle
{
    const CSS = [
        'wiki-single' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-single.css',

            'ver'=> '1.0.3',
        ],
    ];

    const CSS_NEW = [
        'legal-wiki-single-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-single-new.css',

			'ver' => '1.0.0',
		],
    ];

  /*   public static function register_style()
    {
        WikiMain::register_style( self::CSS );
    } */

    public static function register_style()
    {
		if ( TemplateMain::check_code() )
		{
			ReviewMain::register_style( self::CSS_NEW );
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'single-main' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-single.php',

        'single-new' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-single-new.php',
    ];

    public static function render()
    {
        if ( !WikiMain::check() )
        {
            return '';
        }

        if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'single-new' ], [] );
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'single-main' ], [] );

        // ob_start();

        // load_template( self::TEMPLATE[ 'single-main' ], false, [] );

        // $output = ob_get_clean();

        // return $output;
    }
}

?>
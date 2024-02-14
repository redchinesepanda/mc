<?php

class BonusSingle
{
    const CSS = [
        'bonus-single' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-single.css',

            'ver'=> '1.0.3',
        ],
    ];

    const CSS_NEW = [
        'bonus-single' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-single-new.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        if ( TemplateMain::check_new() )
        {
            BonusMain::register_style( self::CSS_NEW );
        }
        else
        {
            BonusMain::register_style( self::CSS );
        }
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-single.php',

        'new' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-single-new.php',
    ];

    public static function render()
    {
        if ( !BonusMain::check() )
        {
            return '';
        }

        // ob_start();

        // load_template( self::TEMPLATE[ 'main' ], false, [] );

        // $output = ob_get_clean();

        // return $output;

        if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'new' ], [] );
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'main' ], [] );
    }
}

?>
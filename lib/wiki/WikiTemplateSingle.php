<?php

class WikiTemplateSingle
{
    const CSS = [
        'wiki-single' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-single.css',

            'ver'=> '1.0.2',
        ],
    ];

    public static function register_style()
    {
        BonusMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'legal-wiki-single' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-single.php',
    ];

    public static function render()
    {
        if ( !WikiMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-wiki-single' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>
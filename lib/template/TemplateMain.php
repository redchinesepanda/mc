<?php

class TemplateMain
{
	const CSS = [
        'legal-template-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-main.css',

			'ver' => '1.0.5',
		],
    ];

	public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    const CATEGORY = [
        'wiki-tag',
    ];

    public static function check_wiki()
    {
        return has_category( self::CATEGORY );
    }

    const TEMPLATE = [
        'post-bonus' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-post-bonus.php',

        'post-wiki' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-post-wiki.php',
    ];

    public static function render()
    {
		ob_start();

        if ( self::check_wiki() )
        {
            load_template( self::TEMPLATE[ 'post-wiki' ], false, [] );
        }
        else
        {
            load_template( self::TEMPLATE[ 'post-bonus' ], false, [] );
        }

        $output = ob_get_clean();

        return $output;
    }
}

?>
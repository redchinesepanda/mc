<?php

class TemplateBonus
{
	const CSS = [
        'legal-template-bonus' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-bonus.css',

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

	public static function check()
    {
        return BonusMain::check();
    }

	const TEMPLATE = [
        'post-bonus' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-post-bonus.php',
    ];

	public static function render()
    {
		if ( !self::check() )
        {
            return '';
        }

        ob_start();
		
		load_template( self::TEMPLATE[ 'post-bonus' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>
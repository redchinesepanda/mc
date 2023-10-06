<?php

class TemplateNotFound
{
	// const CSS = [
    //     'legal-template-bonus' => [
	// 		'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-bonus.css',

	// 		'ver' => '1.0.7',
	// 	],
    // ];

	// public static function register_style()
    // {
    //     ToolEnqueue::register_style( self::CSS );
    // }

	// public static function register()
    // {
    //     $handler = new self();

	// 	add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    // }

	// public static function check()
    // {
	// 	$permission_category = ToolNotFound::check();

	// 	return $permission_category;
    // }

	const TEMPLATE = [
        'legal-template-notfound' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-notfound.php',
    ];

	public static function render()
    {
		// if ( !self::check() )
        // {
        //     return '';
        // }

        ob_start();
		
		load_template( self::TEMPLATE[ 'legal-template-notfound' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>
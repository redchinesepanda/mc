<?php

class WikiRecent
{
	const CSS = [
        'legal-wiki-recent' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-recent.css',

			'ver' => '1.0.7',
		],
    ];

	public static function register_style()
    {
		if ( WikiMain::check() )
		{
			ToolEnqueue::register_style( self::CSS );
		}
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'legal-wiki-recent' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-recent.php',
    ];

	public static function render( $args = [] )
    {
		if ( !WikiMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-wiki-recent' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
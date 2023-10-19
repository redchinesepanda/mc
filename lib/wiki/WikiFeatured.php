<?php

class WikiFeatured
{
	const CSS = [
        'wiki-featured' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-featured.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        WikiMain::register_style( self::CSS );
    }

	public static function check_no_image_size()
	{
		return !has_image_size( BonusFeatured::SIZE[ 'featured' ] );
	}

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		if ( self::check_no_image_size() )
		{
			add_image_size( BonusFeatured::SIZE[ 'featured' ], 700, 400, false );
		}
    }

	const TEMPLATE = [
        'wiki-featured' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-featured.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'wiki-featured' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
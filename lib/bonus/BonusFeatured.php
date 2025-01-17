<?php

class BonusFeatured
{
	const CSS = [
        'bonus-featured' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-featured.css',

            'ver'=> '1.0.0',
        ],
    ];

    const CSS_NEW = [
        'bonus-featured-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-featured-new.css',

			'ver' => '1.0.0',
		],
    ];

    /* public static function register_style()
    {
        BonusMain::register_style( self::CSS );
    } */

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

	public static function register_functions()
    {
        add_image_size( self::SIZE[ 'featured' ], 700, 400, [ 'center', 'center' ] );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const SIZE = [
		'featured' => 'legal-bonus-featured',
	];

	const FIELD = [
        'bonus-affilate' => 'bonus-afillate',

		'bonus-affilate-primary' => 'ref-ssylka',

		'bonus-affilate-secondary' => 'ref-perelinkovka',
	];

	public static function get()
	{
		$id = BonusMain::get_id();

		$preview = BonusPreview::get_thumbnail( $id, self::SIZE[ 'featured' ] );

		// $preview[ 'href' ] = get_field( self::FIELD[ 'bonus-affilate-primary' ], $id );
		
        $preview[ 'href' ] = get_field( self::FIELD[ 'bonus-affilate' ], $id );

		return [
			'preview' => $preview,
		];
	}

	const TEMPLATE = [
        'bonus-featured' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-featured.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-featured' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
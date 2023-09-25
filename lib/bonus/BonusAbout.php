<?php

class BonusAbout
{
	const CSS = [
        'bonus-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-about.css',

            'ver'=> '1.0.0',
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

	const FIELD = [
		'bonus-title' => 'h1',

		'bonus-description' => 'pod-h1',

		'bonus-src' => 'img-bk',

		'bonus-bookmaker-name' => 'name-bk',

		'bonus-affilate-primary' => 'ref-ssylka',

		'bonus-affilate-secondary' => 'ref-perelinkovka',
	];

	public static function get_button()
    {
        $id = BonusMain::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

        $href = get_field( self::FIELD[ 'bonus-affilate-primary' ], $id );

        if ( empty( $href ) )
        {
            $href = OopsMain::check_oops() ? '#' : '';
        }

        return [
            'label' => __( BonusMain::TEXT[ 'claim-bonus' ], ToolLoco::TEXTDOMAIN ),

            'href' => $href,
        ];
    }

	public static function get()
    {
        $id = BonusMain::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

		return [
			'title' => get_field( self::FIELD[ 'bonus-title' ], $id ),
			
			'description' => get_field( self::FIELD[ 'bonus-description' ], $id ),

			'logo' => [
				'src' => get_field( self::FIELD[ 'bonus-src' ], $id ),

				'alt' => get_field( self::FIELD[ 'bonus-bookmaker-name' ], $id ),
			],
		];
    }

	const TEMPLATE = [
        'bonus-about' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-about.php',

        'bonus-about-button' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-about-button.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-about' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_button()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-about-button' ], false, self::get_button() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
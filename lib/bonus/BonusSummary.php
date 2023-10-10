<?php

class BonusSummary
{
	const CSS = [
        'bonus-summary' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-summary.css',

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

	const FIELD = [
		'bonus-name' => 'name-bk',

		'bonus-amount' => 'summa',

		'bonus-min-deposit' => 'min-deposit-bonus',

		'bonus-wagering' => 'otygrysh',
	];

	public static function get()
    {
        $id = BonusMain::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

		return [
			'bookmaker' => [
				'label' => __( BonusMain::TEXT[ 'bookmaker' ], ToolLoco::TEXTDOMAIN ),

				'value' => get_field( self::FIELD[ 'bonus-name' ], $id ),
			],

			'bonus-amount' => [
				'label' => __( BonusMain::TEXT[ 'bonus-amount' ], ToolLoco::TEXTDOMAIN ),

				'value' => get_field( self::FIELD[ 'bonus-amount' ], $id ),
			],

			'min-deposit' => [
				'label' => __( BonusMain::TEXT[ 'min-deposit' ], ToolLoco::TEXTDOMAIN ),

				'value' => get_field( self::FIELD[ 'bonus-min-deposit' ], $id ),
			],

			'wagering' => [
				'label' => __( BonusMain::TEXT[ 'wagering' ], ToolLoco::TEXTDOMAIN ),

				'value' => get_field( self::FIELD[ 'bonus-wagering' ], $id ),
			],

			'published' => [
				'label' => __( BonusMain::TEXT[ 'published' ], ToolLoco::TEXTDOMAIN ),

				'value' => get_the_date( 'd/m/Y' ),
			],
		];
    }

	const TEMPLATE = [
        'bonus-summary' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-summary.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-summary' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
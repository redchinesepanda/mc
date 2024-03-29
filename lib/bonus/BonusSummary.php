<?php

class BonusSummary
{
	const CSS = [
        'bonus-summary' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-summary.css',

            'ver'=> '1.0.2',
        ],
    ];

	const CSS_NEW = [
        'bonus-summary-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-summary-new.css',

			'ver' => '1.0.0',
		],
    ];

/* 	public static function register_style()
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

		$summary_bookmaker = [];

		if ( !TemplateMain::check_new() )
		{
			$summary_bookmaker = [
				'bookmaker' => [
					'label' => __( BonusMain::TEXT[ 'bookmaker' ], ToolLoco::TEXTDOMAIN ),
	
					'value' => get_field( self::FIELD[ 'bonus-name' ], $id ),
				],
			];
		}

		$published_value = get_the_date( 'd/m/Y' );

		$summary_always = [
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
		];

		$summary_published = [
			'published' => [
				'label' => __( BonusMain::TEXT[ 'published' ], ToolLoco::TEXTDOMAIN ),

				'value' => get_the_date( 'd/m/Y' ),
			],
		];

		if ( TemplateMain::check_new() )
		{
			// LegalDebug::debug( [
			// 	'BonusSummary' => 'get',

			// 	'BonusDuration' => BonusDuration::get(),
			// ] );

			$bonus_duration = BonusDuration::get();

			$published_value = $bonus_duration[ 'title' ];

			if ( !empty( $bonus_duration[ 'duration' ] ) )
			{
				$published_value = $bonus_duration[ 'duration' ];
			}

			$summary_published = [
				'published' => [
					'label' => __( BonusMain::TEXT[ 'expires-in' ], ToolLoco::TEXTDOMAIN ),
	
					'value' => $published_value,
				],
			];
		}

		return array_merge( $summary_bookmaker, $summary_always, $summary_published );
    }

	const TEMPLATE = [
        'bonus-summary' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-summary.php',
    ];

    public static function render_about()
	{
		if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'bonus-summary' ], self::get() );
        }
        
		return '';
	}

    public static function render()
    {
		if ( TemplateMain::check_new() )
        {
            return '';
        }

		if ( !BonusMain::check() )
        {
            return '';
        }

		return LegalComponents::render_main( self::TEMPLATE[ 'bonus-summary' ], self::get() );
    }
}

?>
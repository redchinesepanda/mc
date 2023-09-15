<?php

class BonusRelated
{
	const CSS = [
        'bonus-related' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-related.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        if ( BonusMain::check() ) {
            ToolEnqueue::register_style( self::CSS );
        }
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TYPE = [
		'post' => 'post',
	];

	const TAXONOMY = [
		'tag' => 'post_tag',
	];

	public static function get_items()
	{
		$terms = wp_get_post_terms(
            $id,

            self::TAXONOMY[ 'category' ],

            [ 'ids' ]
        );

		return BonusMain::get_items( [
			'post_type' => self::TYPE[ 'post' ],

			'limit' => 6,

			'taxonomy' => self::TAXONOMY[ 'tag' ],

			'terms' => $terms,
		] );
	}

	public static function get()
    {
		return [
			'title' => __( BonusMain::TEXT[ 'best-bookmaker-bonuses' ], ToolLoco::TEXTDOMAIN ),

			'items' => self::get_items(),
		];
	}

	const TEMPLATE = [
        'bonus-related' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-related.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-related' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
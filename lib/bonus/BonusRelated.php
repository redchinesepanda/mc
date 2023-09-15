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

	public static function get_id()
    {
		$post = get_post();

        if ( !empty( $post ) )
        {
            return $post->ID;
        }

        return 0;
    }

	public static function get_items()
	{
		$tags = wp_get_post_tags(
            self::get_id(),

            [ 'names' ]
        );

		LegalDebug::debug( [
			'function' => 'BonusRelated::get_items',

			'tags' => $tags,
		] );

		return BonusMain::get_items( [
			'post_type' => self::TYPE[ 'post' ],

			// 'taxonomy' => self::TAXONOMY[ 'tag' ],

			// 'terms' => $terms,

			'exclude' => [],

			'limit' => 6,
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
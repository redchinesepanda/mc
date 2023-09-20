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
        if ( BonusMain::check() ) {
            ToolEnqueue::register_style( self::CSS );
        }
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function get_id()
    {
		$post = get_post();

        if ( !empty( $post ) )
        {
            return $post->ID;
        }

        return 0;
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
        $id = self::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

        $href = get_field( self::FIELD[ 'bonus-affilate-primary' ], $id );

        if ( empty( $href ) )
        {
            $href = OopsMain::check_oops() ? '#' : '';
        }

        // $path = parse_url( $href, PHP_URL_PATH );

        // $path = trim( $path, '/' );

        // $path_array = explode( '/', $path );

        // $affilate_link = get_page_by_path( end( $path_array ), OBJECT, 'affiliate-links' );

        // $affilate_link_meta = get_post_meta( $affilate_link->ID );

        // $count_data_json = get_post_meta( $affilate_link->ID, 'wpil_links_inbound_internal_count_data', true );

        // $amount = count( $count_data_json ); 

        // $count_data = json_decode( $count_data_json );

        // LegalDebug::debug( [
        //     'function' => 'onusAbout::get_button',

        //     // 'href' => $href,

        //     // 'path' => $path,

        //     // 'affilate_link' => $affilate_link,

        //     'amount' => $amount,

        //     'count_data_json' => $count_data_json,
        // ] );

        return [
            'label' => __( BonusMain::TEXT[ 'claim-bonus' ], ToolLoco::TEXTDOMAIN ),

            'href' => get_field( self::FIELD[ 'bonus-affilate-primary' ], $id ),
        ];
    }

	public static function get()
    {
        $id = self::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

        // $button = self::get_button();

		return [
			'title' => get_field( self::FIELD[ 'bonus-title' ], $id ),
			
			'description' => get_field( self::FIELD[ 'bonus-description' ], $id ),

			'logo' => [
				'src' => get_field( self::FIELD[ 'bonus-src' ], $id ),

				'alt' => get_field( self::FIELD[ 'bonus-bookmaker-name' ], $id ),
			],

			// 'button' => [
			// 	'label' => __( BonusMain::TEXT[ 'claim-bonus' ], ToolLoco::TEXTDOMAIN ),

			// 	'href' => get_field( self::FIELD[ 'bonus-affilate-primary' ], $id ),
			// ],

            // 'button' => $button,
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
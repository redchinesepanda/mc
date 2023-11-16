<?php

class BonusAbout
{
	const CSS = [
        'bonus-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-about.css',

            'ver'=> '1.0.2',
        ],
    ];
    
    public static function register_style()
    {
        BonusMain::register_style( self::CSS );
    }

	public static function register_functions()
    {
        // self::affiliate_migrate();
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }
    
    const TAXONOMY = [
		'category' => 'category',
	];

    const CATEGORY = [
		'bonusy-kz',
        
        'bonusy-by',
	];

    const SEARCH = [
        'https://match.center/',

        '/go/',

        '/kz/',
    ];

    public static function affiliate_migrate_args()
    {
        return [
            'numberposts' => -1,

            'suppress_filters' => 1,

            'post_type' => 'post',

            [
                [
                    'taxonomy' => self::TAXONOMY[ 'category' ],

                    'field' => 'slug',

                    'terms' => self::CATEGORY,

					'operator' => 'IN',
				],
            ],
        ];
    }

    public static function affiliate_filter( $item )
    {
        if ( !empty( $item[ 'href' ] ) )
        {
            return str_contains( $item[ 'href' ], '/go/' );
        }

        return false;
    }

    public static function affiliate_id( $item )
    {
        $href = str_replace( self::SEARCH, '/', $item[ 'href' ] );

        if ( $affiliate = get_page_by_path( $href, OBJECT, 'affiliate-links' ) )
        {
            $item[ 'id' ] = $affiliate->ID;
        }

        return $item;
    }

    public static function affiliate_get( $id )
    {
        $handler = new self();
        // $bonus_affilate = get_field( self::FIELD[ 'bonus-affilate-primary' ], $id );

        $href_previous = [
            [
                'href' => get_field( self::FIELD[ 'bonus-affilate-primary' ], $id ),

                'id' => 0,
            ],

            [
                'href' => get_field( self::FIELD[ 'bonus-affilate-secondary' ], $id ),

                'id' => 0,
            ],   
        ];

        $href_go = array_filter( $href_previous, [ $handler, 'affiliate_filter' ] );

        if ( !empty( $href_go ) )
        {
            $href_id = array_map( [ $handler, 'affiliate_id' ], $href_go);

            LegalDebug::debug( [
                'function' => 'BonusAbout::affiliate_get',
    
                'href_previous' => $href_previous,
    
                'href_go' => $href_go,
    
                'href_id' => $href_id,
            ] );

            return array_shift( $href_id )[ 'id' ];
        }

        // if ( empty( $bonus_affilate ) || $bonus_affilate == '#' )
        // {
        //     $bonus_affilate = get_field( self::FIELD[ 'bonus-affilate-secondary' ], $id );
        // }

        // $affiliate_primary = get_page_by_path( $bonus_affilate_primary, OBJECT, 'affiliate-links' );

        // $affiliate_secondary = get_page_by_path( $bonus_affilate_secondary, OBJECT, 'affiliate-links' );

        // if ( $affiliate = get_page_by_path( $bonus_affilate, OBJECT, 'affiliate-links' ) )
        // {
        //     return $affiliate->ID;
        // }
        
        return '';
    }

    public static function affiliate_migrate()
    {
        $posts = get_posts( self::affiliate_migrate_args() );

        foreach ( $posts as $post )
        {
            $affiliate_id = self::affiliate_get( $post->ID );

            // update_field( self::FIELD[ 'bonus-affilate-new' ], $affiliate_id, $post->ID );

            // LegalDebug::debug( [
            //     'function' => 'BonusAbout::affiliate_migrate',

            //     'ID' => $post->ID,

            //     'affiliate_id' => $affiliate_id,
            // ] );
        }
    }

	const FIELD = [
		'bonus-title' => 'h1',

		'bonus-description' => 'pod-h1',

		'bonus-src' => 'img-bk',

		'bonus-bookmaker-name' => 'name-bk',

		'bonus-affilate-primary' => 'ref-ssylka',

		'bonus-affilate-secondary' => 'ref-perelinkovka',

		'bonus-affilate-new' => 'bonus-afillate',
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
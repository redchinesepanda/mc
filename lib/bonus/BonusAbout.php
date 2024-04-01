<?php

class BonusAbout
{
	const CSS = [
        'bonus-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-about.css',

            'ver'=> '1.0.4',
        ],
    ];

    const CSS_NEW = [
        'bonus-about-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-about-new.css',

			'ver' => '1.0.0',
		],
    ];
    
   /*  public static function register_style()
    {
        BonusMain::register_style( self::CSS );
    } */

    public static function register_style()
    {
		if ( TemplateMain::check_code() )
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

    public static function filter_go( $item )
    {
        if ( !empty( $item[ 'href' ] ) )
        {
            return str_contains( $item[ 'href' ], '/go/' );
        }

        return false;
    }

    public static function filter_id( $item )
    {
        return !empty( $item[ 'id' ] );
    }

    public static function set_id( $item )
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

        $href_go = array_filter( $href_previous, [ $handler, 'filter_go' ] );

        if ( !empty( $href_go ) )
        {
            $href_id = array_map( [ $handler, 'set_id' ], $href_go);

            $href_result = array_filter( $href_id, [ $handler, 'filter_id' ] );

            $item = array_shift( $href_id );

            // LegalDebug::debug( [
            //     'function' => 'BonusAbout::affiliate_get',
    
            //     'href_previous' => $href_previous,
    
            //     'href_go' => $href_go,
    
            //     'href_id' => $href_id,

            //     'href_result' => $href_result,

            //     'item' => $item,
            // ] );

            return $item[ 'id' ];
        }

        // $bonus_affilate = get_field( self::FIELD[ 'bonus-affilate-primary' ], $id );

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

            LegalDebug::debug( [
                'function' => 'BonusAbout::affiliate_migrate',

                'ID' => $post->ID,

                'affiliate_id' => $affiliate_id,
            ] );
        }
    }

	const FIELD = [
		'bonus-title' => 'h1',

		'bonus-description' => 'pod-h1',

		'bonus-src' => 'img-bk',

		'bonus-bookmaker-name' => 'name-bk',

		'bonus-affilate' => 'bonus-afillate',

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

        // $href = get_field( self::FIELD[ 'bonus-affilate-primary' ], $id );
        
        $href = get_field( self::FIELD[ 'bonus-affilate' ], $id );

        if ( empty( $href ) )
        {
            $href = OopsMain::check_oops() ? '#' : '';
        }

        // $href = ACFReview::format_afillate( $href, 0, '' );

        return [
            'label' => __( BonusMain::TEXT[ 'claim-bonus' ], ToolLoco::TEXTDOMAIN ),

            'href' => $href,
        ];
    }

	public static function get_bonus()
    {
        $bonus_amount = BonusSummary::get_bonus_amount();

        if ( TemplateMain::check_new())
        {
            return [
                'label' => ToolLoco::translate( BonusMain::TEXT[ 'bookmaker-bonus' ] ),
    
                'value' => $bonus_amount[ 'value' ],
            ];
        }

        return [];
    }

	public static function get_logo_src( $id = false )
    {
        if ( $brand_src = BrandMain::get_logo_billet( $id ) )
        {
            return $brand_src;
        }

        return get_field( self::FIELD[ 'bonus-src' ], $id );
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

            'bonus' => self::get_bonus(),

			'logo' => [
				// 'src' => get_field( self::FIELD[ 'bonus-src' ], $id ),
				
                'src' => self::get_logo_src( $id ),

				'alt' => get_field( self::FIELD[ 'bonus-bookmaker-name' ], $id ),
			],
		];
    }

	const TEMPLATE = [
        'bonus-about' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-about.php',

        'bonus-about-new' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-about-new.php',

        'bonus-about-button' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-about-button.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        // ob_start();

        // load_template( self::TEMPLATE[ 'bonus-about' ], false, self::get() );

        // $output = ob_get_clean();

        // return $output;

        if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'bonus-about-new' ], self::get() );
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'bonus-about' ], self::get() );
    }

    public static function render_button()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        // ob_start();

        // load_template( self::TEMPLATE[ 'bonus-about-button' ], false, self::get_button() );

        // $output = ob_get_clean();

        // return $output;

        return LegalComponents::render_main( self::TEMPLATE[ 'bonus-about-button' ], self::get_button() );
    }
}

?>
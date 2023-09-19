<?php

require_once( 'BonusTemplateSingle.php' );

require_once( 'BonusAbout.php' );

require_once( 'BonusSummary.php' );

require_once( 'BonusRelated.php' );

require_once( 'BonusTemplateSingle.php' );

require_once( 'BonusFeatured.php' );

require_once( 'BonusDuration.php' );

require_once( 'BonusContent.php' );

class BonusMain
{
	const TEXT = [
		'best-bookmaker-bonuses' => 'Best Bookmaker Bonuses',

		'bonus-amount' => 'Bonus amount',

		'bonus-preview' => 'Bonus Preview',

		'bonus-logo' => 'Bonus Logo',
		
		'bookmaker' => 'Bookmaker',

		'claim-bonus' => 'Claim Bonus',

		'get-bonus' => 'Get Bonus',

		'min-deposit' => 'Min. deposit',

		'promotion-expired' => 'Promotion Expired',

		'promotion-period' => 'Promotion period',

		'published' => 'Published',

		'similar-bonuses' => 'Similar Bonuses',

		'till' => 'till',

		'wagering' => 'Wagering',
	];

	const SIZE = [
		'preview' => 'legal-bonus-preview',

		'logo' => 'legal-bonus-logo',
	];

	const CSS = [
        'legal-bonus' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus.css',

            'ver'=> '1.0.3',
        ],
    ];

	public static function register_style()
    {
        if ( self::check() ) {
            ToolEnqueue::register_style( self::CSS );
        }
    }

	public static function check()
    {
        $permission_admin = !is_admin();

        $permission_post_type = is_singular( [ 'page', 'post' ] );
        
        return $permission_admin && $permission_post_type;
    }

	public static function register()
    {
        $handler = new self();

        // [legal-bonus post_type='post' taxonomy='category' terms='fribety' exclude="fribety-1xbet" limit=6]

        // [legal-bonus terms='fribety' exclude="fribety-1xbet" limit=6]
        
		// [legal-bonus terms='bonusy-kz']

        add_shortcode( 'legal-bonus', [ $handler, 'prepare' ] );

		add_image_size( self::SIZE[ 'preview' ], 330, 190, [ 'center', 'center' ] );

		add_image_size( self::SIZE[ 'logo' ], 50, 50, [ 'center', 'center' ] );

		add_filter( 'image_size_names_choose', [ $handler, 'size_label' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'admin_init', [ $handler, 'legal_posts_order' ] );

		BonusAbout::register();

		BonusSummary::register();

		BonusRelated::register();

		BonusTemplateSingle::register();

		BonusFeatured::register();

		BonusDuration::register();

		BonusContent::register();
    }

	public static function legal_posts_order() 
	{
		add_post_type_support( 'post', 'page-attributes' );
	}

	public static function size_label( $sizes )
    {
        return array_merge( $sizes, [
            self::SIZE[ 'preview' ] => __( self::TEXT[ 'bonus-preview' ], ToolLoco::TEXTDOMAIN ),

            self::SIZE[ 'logo' ] => __( self::TEXT[ 'bonus-logo' ], ToolLoco::TEXTDOMAIN ),
        ] );
    }

	const PAIRS = [
		'post_type' => 'post',

		'taxonomy' => 'category',

		'terms' => [ 'bonusy-kz' ],

		'exclude' => [],

		'limit' => -1,
	];

	const FIELD = [
		'logo-preview' => 'logo_bk_mini',

		'bonus-size' => 'summa',
		
		'afillate' => 'ref-ssylka',

		'duration' => 'data-okonchaniya',
	];

	const MODE = [
		'all' => 'all',

		'partner' => 'partner',

		'no-partner' => 'no-partner',
	];

	const DURATION = [
		'actual' => 'actual',

		'expired' => 'expired',
	];

	public static function get_posts_date( $atts, $mode = self::MODE[ 'all' ], $duration = self::DURATION[ 'actual' ] )
	{
		if ( $atts[ 'limit' ] == 0 )
		{
			return [];
		}

		$compare = '>';

		if ( in_array( $duration, [ self::DURATION[ 'expired' ] ] ) )
		{
			$compare = '<';
		}

		$query_filter = new ToolDate ( self::FIELD[ 'duration' ], date( 'Y-m-d' ), '%d/%m/%Y', $compare );

		$args = self::get_args( $atts, $mode );
		
		$query = $query_filter->createWpQuery( $args );

		$posts = $query->posts;

		return $posts;
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
	
	public static function get_args( $atts, $mode = self::MODE[ 'all' ] )
    {
		$meta_query = [];

		if ( in_array( $mode, [ self::MODE[ 'partner' ] ] ) )
		{
			$meta_query = [
				[
					'key' => self::FIELD[ 'afillate' ],
					
					'value' => [ '', '#' ],
					
					'compare' => 'NOT IN',
				],
			];
		}

		if ( in_array( $mode, [ self::MODE[ 'no-partner' ] ] ) )
		{
			$meta_query = [
				[
					'key' => self::FIELD[ 'afillate' ],
					
					'value' => [ '', '#' ],
					
					'compare' => 'IN',
				],
			];
		}

		$tax_query = [];

		if ( !empty( $atts[ 'taxonomy' ] ) )
		{
			$tax_query = [
				[
					'taxonomy' => $atts[ 'taxonomy' ],
	
					'field' => 'slug',
	
					'terms' => $atts[ 'terms' ],
				]
			];
		}

		if ( !empty( $atts[ 'exclude' ] ) )
		{
			$tax_query[] = [
				[
					'taxonomy' => $atts[ 'taxonomy' ],

					'field' => 'slug',

					'terms' => $atts[ 'exclude' ],

					'operator' => 'NOT IN',
				]
			];
		}

		$args = [
			'posts_per_page' => $atts[ 'limit' ],
            
            'post_type' => $atts[ 'post_type' ],

			'suppress_filters' => 0,

			'tax_query' => $tax_query,

			'meta_query' => $meta_query,

			'orderby' => [
				'menu_order' => 'DESC',

				'modified' => 'DESC',

				'title' => 'ASC',
			],
        ];

		if ( !empty( $atts[ 'tags' ] ) )
		{
			$args[ 'tag_slug__in' ] = $atts[ 'tags' ];
		}

		if ( !empty( $atts[ 'categories' ] ) )
		{
			$args[ 'category__in' ] = $atts[ 'categories' ];
		}

		if ( !empty( $atts[ 'current_not_in' ] ) )
		{
			$args[ 'post__not_in' ] = [ self::get_id() ];
		}

		return $args;
    }

	public static function get_thumbnail( $id, $size = self::SIZE[ 'preview' ] )
	{
		if ( $thumbnail_id = get_post_thumbnail_id( $id ) )
		{
			$details = wp_get_attachment_image_src( $thumbnail_id, $size );

			if ( $details )
			{
				return [
					'id' => $thumbnail_id,

					'src' => $details[ 0 ],
	
					'width' => $details[ 1 ],
	
					'height' => $details[ 2 ],
				];
			}
		}
		
		return [
			'src' => LegalMain::LEGAL_URL . '/assets/img/bonus/bonus-preview-default.webp',
	
			'width' => '330',

			'height' => '190',
		];
	}

	public static function get_logo( $id, $size = self::SIZE[ 'logo' ] )
	{
		$logo = get_field( self::FIELD[ 'logo-preview' ], $id );

		if ( $logo )
		{
			$details = wp_get_attachment_image_src( $logo[ 'id' ], $size );

			if ( $details )
			{
				return [
					'id' => $logo[ 'id' ],

					'src' => $details[ 0 ],
	
					'width' => $details[ 1 ],
	
					'height' => $details[ 2 ],
				];
			}
		}
		
		return [
			'src' => LegalMain::LEGAL_URL . '/assets/img/bonus/bonus-logo-default.webp',
	
			'width' => '50',

			'height' => '50',
		];
	}

	public static function group_posts( $atts )
	{
		$limit = $atts[ 'limit' ] != -1 && is_numeric( $atts[ 'limit' ] );
		
		$active_partners = self::get_posts_date( $atts, self::MODE[ 'partner' ], self::DURATION[ 'actual' ] );

		if ( $limit )
		{
			$amount = count( $active_partners );

			$rest = $atts[ 'limit' ] - $amount;

			if ( $rest >= 0 )
			{
				$atts[ 'limit' ] = $rest;
			}
		}

		$active_no_partners = self::get_posts_date( $atts, self::MODE[ 'no-partner' ], self::DURATION[ 'actual' ] );

		if ( $limit )
		{
			$amount = count( $active_no_partners );

			$rest = $atts[ 'limit' ] - $amount;

			if ( $rest >= 0 )
			{
				$atts[ 'limit' ] = $rest;
			}
		}

		$expired_all = self::get_posts_date( $atts, self::MODE[ 'all' ], self::DURATION[ 'expired' ] );

		return array_merge( $active_partners, $active_no_partners, $expired_all );
	}

	public static function get_items( $atts )
	{
		$posts = self::group_posts( $atts );

		$items = [];

		if ( !empty( $posts ) )
		{
			foreach ( $posts as $post )
			{
				$post_url = get_post_permalink( $post->ID );

				$preview = self::get_thumbnail( $post->ID );

				if ( !empty( $preview ) )
				{
					$preview[ 'href' ] = $post_url;
				}

				$items[] = [
					'id' => $post->ID,

					'preview' => $preview,
					
					'logo' => self::get_logo( $post->ID ),

					'title' => [
						'label' => $post->post_title,

						'href' => $post_url,
					],

					'size' => get_field( self::FIELD[ 'bonus-size' ], $post->ID ),

					'get' => [
						'label' => __( self::TEXT[ 'bonus-preview' ], ToolLoco::TEXTDOMAIN ),

						'href' => get_field( self::FIELD[ 'afillate' ], $post->ID ),
					],
				];
			}
		}

		return $items;
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, 'legal-bonus' );

		$items = self::get_items( $atts );

		$args = [
			'items' => $items,
		];

		return self::render( $args );
	}

	const TEMPLATE = [
        'legal-bonus' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus.php',
    ];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'legal-bonus' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
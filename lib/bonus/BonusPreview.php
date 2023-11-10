<?php

class BonusPreview
{
	const SIZE = [
		'preview' => 'legal-bonus-preview',

		'logo' => 'legal-bonus-logo',
	];

	const CSS = [
        'legal-bonus-preview' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-preview.css',

            'ver'=> '1.1.2',
        ],
    ];
	
	public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

	public static function register_functions()
    {
		$handler = new self();
		
        add_image_size( self::SIZE[ 'preview' ], 330, 190, [ 'center', 'center' ] );

		add_image_size( self::SIZE[ 'logo' ], 50, 50, [ 'center', 'center' ] );

		add_filter( 'image_size_names_choose', [ $handler, 'size_label' ] );

		add_action( 'admin_init', [ $handler, 'legal_posts_order' ] );
    }

	public static function register()
    {
        $handler = new self();

        // [legal-bonus post_type='post' taxonomy='category' terms='fribety' exclude="fribety-1xbet" limit=6]

        // [legal-bonus terms='fribety' exclude="fribety-1xbet" limit=6]
        
		// [legal-bonus terms='bonusy-kz']

        add_shortcode( 'legal-bonus', [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function legal_posts_order() 
	{
		add_post_type_support( 'post', 'page-attributes' );
	}

	public static function size_label( $sizes )
    {
        return array_merge( $sizes, [
            self::SIZE[ 'preview' ] => __( BonusMain::TEXT[ 'bonus-preview' ], ToolLoco::TEXTDOMAIN ),

            self::SIZE[ 'logo' ] => __( BonusMain::TEXT[ 'bonus-logo' ], ToolLoco::TEXTDOMAIN ),
        ] );
    }

	const PAIRS = [
		'post_type' => 'post',

		'taxonomy' => 'category',

		'terms' => [ 'bonusy-kz' ],

		'exclude' => [],

		'limit' => -1,

		'tags' => [],

		'current_not_in' => false,

		'duration' => '',
	];

	const FIELD = [
		'logo-preview' => 'logo_bk_mini',

		'bonus-size' => 'summa',
		
		'afillate' => 'ref-ssylka',

		'duration' => 'data-okonchaniya',

		'expire' => 'bonus-expire',
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

	// public static function get_posts_date( $atts, $mode = self::MODE[ 'all' ], $duration = self::DURATION[ 'actual' ] )
	// {
	// 	if ( $atts[ 'limit' ] == 0 )
	// 	{
	// 		return [];
	// 	}

	// 	$compare = '>';

	// 	if ( in_array( $duration, [ self::DURATION[ 'expired' ] ] ) )
	// 	{
	// 		$compare = '<';
	// 	}

	// 	$query_filter = new ToolDate ( self::FIELD[ 'duration' ], date( 'Y-m-d' ), '%d/%m/%Y', $compare );

	// 	$args = self::get_args( $atts, $mode );
		
	// 	$query = $query_filter->createWpQuery( $args );

	// 	$posts = $query->posts;

	// 	return $posts;
	// }
	
	public static function get_posts_date( $atts, $mode = self::MODE[ 'all' ], $duration = self::DURATION[ 'actual' ] )
	{
		if ( $atts[ 'limit' ] == 0 )
		{
			return [];
		}

		// $compare = '>';

		// if ( in_array( $duration, [ self::DURATION[ 'expired' ] ] ) )
		// {
		// 	$compare = '<';
		// }

		// $query_filter = new ToolDate ( self::FIELD[ 'duration' ], date( 'Y-m-d' ), '%d/%m/%Y', $compare );

		// $atts[ 'compare' ] = $compare;

		// $atts[ 'duration' ] = $duration;

		$args = self::get_args( $atts, $mode, $duration );
		
		// $query = $query_filter->createWpQuery( $args );

		// $posts = $query->posts;

		$posts = get_posts( $args );

		return $posts;
	}

	public static function get_args_date( $atts, $duration )
	{
		// $today = date( 'Y-m-d ' );

		$now = new DateTime( 'now' );

		$compare = '>=';

		// $compare = 'after';

		// $inclusive = true;

		if ( in_array( $duration, [ self::DURATION[ 'expired' ] ] ) )
		{
			$compare = '<';
			
			// $compare = 'before';

			// $inclusive = false;
		}

		// return [
		// 	'column' => self::FIELD[ 'expire' ],

		// 	// 'compare' => $compare,

		// 	$compare => 'today',
			
		// 	'inclusive' => $inclusive,
		// ];

		return [
			[
				'key' => self::FIELD[ 'expire' ],

				'value' => $now->format('Y-m-d H:i:s'),

				'compare' => $compare,

				'type' => 'DATETIME',
			],
		];
	}

	public static function get_args_meta( $atts, $mode )
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

		return $meta_query;
	}

	public static function get_args_tax( $atts )
	{
		$tax_query = [];

		if ( !empty( $atts[ 'taxonomy' ] ) )
		{
			$tax_query[] = [
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

		return $tax_query;
	}
	
	public static function get_args( $atts, $mode = self::MODE[ 'all' ], $duration = self::DURATION[ 'actual' ] )
    {
		$meta_query = array_merge(
			self::get_args_meta( $atts, $mode ),

			self::get_args_date( $atts, $duration ),
		);

		$tax_query = self::get_args_tax( $atts );

		$args = [
			'posts_per_page' => $atts[ 'limit' ],
            
            'post_type' => $atts[ 'post_type' ],

			'suppress_filters' => 0,

			'tax_query' => $tax_query,

			'meta_query' => $meta_query,

			// 'date_query' => $date_query,

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

		if ( !empty( $atts[ 'current_not_in' ] ) )
		{
			$args[ 'post__not_in' ] = [ BonusMain::get_id() ];
		}

		// LegalDebug::debug( [
		// 	'function' => 'BonusPreview::get_args',

		// 	'atts' => $atts,

		// 	'args' => $args,
		// ] );

		return $args;
    }

	// public static function get_args( $atts, $mode = self::MODE[ 'all' ] )
    // {
	// 	$meta_query = [];

	// 	if ( in_array( $mode, [ self::MODE[ 'partner' ] ] ) )
	// 	{
	// 		$meta_query = [
	// 			[
	// 				'key' => self::FIELD[ 'afillate' ],
					
	// 				'value' => [ '', '#' ],
					
	// 				'compare' => 'NOT IN',
	// 			],
	// 		];
	// 	}

	// 	if ( in_array( $mode, [ self::MODE[ 'no-partner' ] ] ) )
	// 	{
	// 		$meta_query = [
	// 			[
	// 				'key' => self::FIELD[ 'afillate' ],
					
	// 				'value' => [ '', '#' ],
					
	// 				'compare' => 'IN',
	// 			],
	// 		];
	// 	}

	// 	$tax_query = [];

	// 	if ( !empty( $atts[ 'taxonomy' ] ) )
	// 	{
	// 		$tax_query = [
	// 			[
	// 				'taxonomy' => $atts[ 'taxonomy' ],
	
	// 				'field' => 'slug',
	
	// 				'terms' => $atts[ 'terms' ],
	// 			]
	// 		];
	// 	}

	// 	if ( !empty( $atts[ 'exclude' ] ) )
	// 	{
	// 		$tax_query[] = [
	// 			[
	// 				'taxonomy' => $atts[ 'taxonomy' ],

	// 				'field' => 'slug',

	// 				'terms' => $atts[ 'exclude' ],

	// 				'operator' => 'NOT IN',
	// 			]
	// 		];
	// 	}

	// 	$args = [
	// 		'posts_per_page' => $atts[ 'limit' ],
            
    //         'post_type' => $atts[ 'post_type' ],

	// 		'suppress_filters' => 0,

	// 		'tax_query' => $tax_query,

	// 		'meta_query' => $meta_query,

	// 		'orderby' => [
	// 			'menu_order' => 'DESC',

	// 			'modified' => 'DESC',

	// 			'title' => 'ASC',
	// 		],
    //     ];

	// 	if ( !empty( $atts[ 'tags' ] ) )
	// 	{
	// 		$args[ 'tag_slug__in' ] = $atts[ 'tags' ];
	// 	}

	// 	if ( !empty( $atts[ 'current_not_in' ] ) )
	// 	{
	// 		$args[ 'post__not_in' ] = [ BonusMain::get_id() ];
	// 	}

	// 	return $args;
    // }

	public static function get_thumbnail( $id, $size = self::SIZE[ 'preview' ] )
	{
		$thumbnail_id = get_post_thumbnail_id( $id );

		if ( $thumbnail_id )
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
			'id' => 0,

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
			'id' => 0,

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

		$expired_all = [];

		if ( !in_array( $atts[ 'duration' ], [ self::DURATION[ 'actual' ] ] ) )
		{
			$expired_all = self::get_posts_date( $atts, self::MODE[ 'all' ], self::DURATION[ 'expired' ] );
		}

		$posts = array_merge( $active_partners, $active_no_partners, $expired_all );

		// LegalDebug::debug( [
		// 	'function' => 'BonusPreview::group_posts',

		// 	'active_partners' => count( $active_partners ),

		// 	'active_no_partners' => count( $active_no_partners ),

		// 	'expired_all' => count( $expired_all ),

		// 	'posts' => count( $posts ),
		// ] );

		return $posts;
	}

	public static function get_items_shortcode( $atts )
	{
		return self::get_items( self::group_posts( $atts ) );
	}

	public static function get_items( $posts )
	{
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

				$expired = '';

				if ( BonusDuration::check_expired( $post->ID ) )
				{
					$expired = __( BonusMain::TEXT[ 'promotion-expired' ], ToolLoco::TEXTDOMAIN );
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
						'label' => __( BonusMain::TEXT[ 'bonus-preview' ], ToolLoco::TEXTDOMAIN ),

						'href' => get_field( self::FIELD[ 'afillate' ], $post->ID ),
					],

					'expired' => $expired,

					// 'date' => get_field( self::FIELD[ 'expire' ], $post->ID ),

					// 'modified' => $post->post_modified,
				]; 
			}
		}

		return $items;
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, 'legal-bonus' );

		$items = self::get_items_shortcode( $atts );

		$args = [
			'items' => $items,
		];

		return self::render( $args );
	}

	const TEMPLATE = [
        'legal-bonus-preview' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-preview.php',
    ];

    public static function render( $args )
    {
		if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-bonus-preview' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
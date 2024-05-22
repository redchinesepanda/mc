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

	const CSS_NEW = [
        'legal-bonus-preview-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-preview-new.css',

			'ver' => '1.0.0',
		],
    ];

	public static function register_style()
	{
		if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_style( self::CSS_NEW );
		}
		else
		{
			ToolEnqueue::register_style( self::CSS );
		}
	}

	public static function register_functions()
    {
		$handler = new self();
		
        add_image_size( self::SIZE[ 'preview' ], 330, 190, [ 'center', 'center' ] );

		add_image_size( self::SIZE[ 'logo' ], 50, 50, [ 'center', 'center' ] );

		add_filter( 'image_size_names_choose', [ $handler, 'size_label' ] );

		add_action( 'admin_init', [ $handler, 'legal_posts_order' ] );
    }

	const SHORTCODE = [
		'preview' => 'legal-bonus',
	];
	
	public static function check_contains_bonus()
    {
        return LegalComponents::check_shortcode( self::SHORTCODE[ 'preview' ] );
    }

	public static function register()
    {
        $handler = new self();

        // [legal-bonus post_type='post' taxonomy='category' terms='fribety' exclude="fribety-1xbet" limit=6]

        // [legal-bonus terms='fribety' exclude="fribety-1xbet" limit=6]
        
		// [legal-bonus terms='bonusy-kz']

        add_shortcode( self::SHORTCODE[ 'preview' ], [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		if (  TemplateMain::check_new() && self::check_contains_bonus() )
		{
			add_action( 'the_content', [ $handler, 'modify_content' ] );
		}
    }
	
	public static function modify_content( $content )
	{
		// if ( self::check_contains_bonus() )
		// {
		// 	return $content;
		// }

		$dom = LegalDOM::get_dom( $content ); 

		self::insert_anchors( $dom );

		return $dom->saveHTML( $dom );
	}

	public static function get_nodes_shortcode( $dom )
	{
		// return LegalDOM::get_nodes( $dom, "//text()[contains(., 'legal-bonus terms')]" );
		
		return LegalDOM::get_nodes( $dom, "//text()[contains(., '[" . self::SHORTCODE[ 'preview' ] . "')]" );
	}

	public static function insert_anchors( $dom )
	{
		$nodes = self::get_nodes_shortcode( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		$node = $nodes->item( $nodes->length - 1 );

		$section = $dom->createElement( 'div' );

		$section->setAttribute( 'class', 'legal-section-anchors' );

		LegalDOM::appendHTML( $section, ReviewAnchors::render() );

		try
		{
			$node->parentNode->insertBefore( $section, $node->nextSibling );
		}
		catch ( DOMException $e )
		{
			LegalDebug::debug( [
				'BonusPreview' => 'insert_anchors',

				'node' => substr( $node->textContent, 0, 30 ),

				'message' => $e->getMessage(),
			] );
		}

		return true;
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
		'bonus-title' => 'h1',

		'logo-preview' => 'logo_bk_mini',

		'bonus-size' => 'summa',
		
		'afillate' => 'ref-ssylka',

		'bonus-affilate-secondary' => 'ref-perelinkovka',
		
		'bonus-afillate' => 'bonus-afillate',

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

		// LegalDebug::debug( [
		// 	'BonusPreview' => 'get_posts_date',

		// 	'args' => $args,
		// ] );
		
		// $query = $query_filter->createWpQuery( $args );

		// $posts = $query->posts;

		$posts = get_posts( $args );

		$query = new WP_Query( $args );
		
		$query_sql = $query->request;

		LegalDebug::debug( [
			'BonusPreview' => 'get_posts_date',

			'duration' => $duration,

			'query_sql' => $query_sql,
		] );

		return $posts;
	}

	public static function get_args_date( $atts, $duration )
	{
		// $now = new DateTime( 'now' );
		
		// $timezone = ToolTimezone::get_timezone();
		
		// $now = new DateTime( 'now', new DateTimeZone( $timezone ) );

		$now = ToolTimezone::get_now_timezone();

		// LegalDebug::debug( [
		// 	'function' => 'BonusPreview::get_args_date',

		// 	'timezone' => $timezone,

		// 	'now' => $now,
		// ] );

		$expired = in_array( $duration, [ self::DURATION[ 'expired' ] ] );

		if ( $expired )
		{
			$meta_query_date = [
				[
					'relation' => 'AND',
	
					[
						'key' => self::FIELD[ 'expire' ],
						
						'compare_key' => 'EXISTS',
					],

					[
						'key' => self::FIELD[ 'expire' ],
						
						'compare' => '!=',
	
						'value' => '',
					],

					[
						'key' => self::FIELD[ 'expire' ],
			
						'value' => $now->format( 'Y-m-d H:i:s' ),
			
						'compare' => '<',
			
						'type' => 'DATETIME',
					]
				],
			];
		}
		else
		{
			$meta_query_date = [
				[
					'relation' => 'OR',
	
					[
						'key' => self::FIELD[ 'expire' ],
						
						'compare_key' => 'NOT EXISTS',
					],

					[
						'key' => self::FIELD[ 'expire' ],
						
						'compare' => '=',
	
						'value' => '',
					],
					
					[
						'key' => self::FIELD[ 'expire' ],
			
						'value' => $now->format( 'Y-m-d H:i:s' ),
			
						'compare' => '>=',
			
						'type' => 'DATETIME',
					]
				]
			];
		}

		return $meta_query_date;

		$compare = $expired ? '<' : '>=';

		// $compare = '>=';

		// if ( in_array( $duration, [ self::DURATION[ 'expired' ] ] ) )
		// {
		// 	$compare = '<';
		// }

		// return [
		// 	[
		// 		'key' => self::FIELD[ 'expire' ],

		// 		'value' => $now->format('Y-m-d H:i:s'),

		// 		'compare' => $compare,

		// 		'type' => 'DATETIME',
		// 	],
		// ];

		$meta_query_date = [
			'key' => self::FIELD[ 'expire' ],

			'value' => $now->format( 'Y-m-d H:i:s' ),

			'compare' => $compare,

			'type' => 'DATETIME',
		];

		if ( $expired )
		{
			return [ $meta_query_date ];
		}

		return [
			[
				'relation' => 'OR',

				$meta_query_date,

				[
					'key' => self::FIELD[ 'expire' ],
					
					'compare' => '=',

					'value' => '',
				],
			],
		];
	}

	public static function get_args_meta( $atts, $mode )
	{
		$meta_query = [];

		if ( in_array( $mode, [ self::MODE[ 'partner' ] ] ) )
		{
			$meta_query = [
				// [
				// 	'key' => self::FIELD[ 'afillate' ],
					
				// 	'value' => [ '', '#' ],
					
				// 	'compare' => 'NOT IN',
				// ],

				[
					'key' => self::FIELD[ 'bonus-afillate' ],
					
					'value' => '',
					
					'compare' => '!=',
				],
			];
		}

		if ( in_array( $mode, [ self::MODE[ 'no-partner' ] ] ) )
		{
			$meta_query = [
				// [
				// 	'key' => self::FIELD[ 'afillate' ],
					
				// 	'value' => [ '', '#' ],
					
				// 	'compare' => 'IN',
				// ],

				[
					'relation' => 'OR',

					[
						'key' => self::FIELD[ 'bonus-afillate' ],
						
						'value' => '',
						
						'compare' => '=',
					],

					[
						'key' => self::FIELD[ 'bonus-afillate' ],
						
						'compare' => 'NOT EXISTS',
					],
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

			'post_status' => 'publish',

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
		// LegalDebug::debug( [
		// 	'BonusPreview' => 'get_logo',

		// 	'get_logo_bonus_preview' => BrandMain::get_logo_bonus_preview( $id ),

		// 	'get_field' => get_field( self::FIELD[ 'logo-preview' ], $id ),
		// ] );

		if ( $logo_brand = BrandMain::get_logo_bonus_preview( $id ) )
        {
            return [
				'id' => 'post-' . $id,

				'src' => $logo_brand,

				'width' => 30,

				'height' => 30,
			];
        }

		if ( $logo = get_field( self::FIELD[ 'logo-preview' ], $id ) )
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

		LegalDebug::debug( [
			'function' => 'BonusPreview::group_posts',

			'active_partners' => count( $active_partners ),

			'active_no_partners' => count( $active_no_partners ),

			'expired_all' => count( $expired_all ),

			'posts' => count( $posts ),
		] );

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
				
				$get_href = get_field( self::FIELD[ 'bonus-afillate' ], $post->ID );

				if ( empty( $get_href ) )
				{
					$get_href = OopsMain::check_oops() > 0 ? '#' : '';
				}

				// $get_href = ACFReview::format_afillate( $get_href, 0, '' );

				$items[] = [
					'id' => $post->ID,

					'preview' => $preview,
					
					'logo' => self::get_logo( $post->ID ),

					'title' => [
						'label' => get_field( self::FIELD[ 'bonus-title' ], $post->ID ),

						'href' => $post_url,
					],

					'size' => get_field( self::FIELD[ 'bonus-size' ], $post->ID ),

					'get' => [
						'label' => __( BonusMain::TEXT[ 'bonus-preview' ], ToolLoco::TEXTDOMAIN ),
						
						'href' => $get_href,
					],

					'expired' => $expired,
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
        'main' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-preview.php',

        'new' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-preview-new.php',
    ];

    public static function render( $args )
	{
		if ( TemplateMain::check_new() )
		{
			return LegalComponents::render_main( self::TEMPLATE[ 'new' ], $args );
		}

		return LegalComponents::render_main( self::TEMPLATE[ 'main' ], $args );
	}
}

?>
<?php

class BonusMain
{
	const TEXT = [
		'bonus-preview' => 'Bonus Preview',

		'get-bonus' => 'Get Bonus',
	];

	const SIZE = [
		'preview' => 'legal-bonus-preview',
	];

	const CSS = [
        'legal-bonus' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus.css',

            'ver'=> '1.0.0',
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

        $permission_post_type = is_singular( [ 'page' ] );
        
        return $permission_admin && $permission_post_type;
    }

	public static function register()
    {
        $handler = new self();

        // [legal-bonus]

        // [legal-bonus post_type='post' taxonomy='category' terms='bonusy-kz']

        add_shortcode( 'legal-bonus', [ $handler, 'prepare' ] );

		add_image_size( self::SIZE[ 'preview' ], 330, 190, [ 'center', 'center' ] );

		add_filter( 'image_size_names_choose', [ $handler, 'size_label' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'admin_init', [ $handler, 'legal_posts_order' ] );
    }

	public static function legal_posts_order() 
	{
		add_post_type_support( 'post', 'page-attributes' );
	}

	public static function size_label( $sizes )
    {
        return array_merge( $sizes, [
            self::SIZE[ 'preview' ] => __( self::TEXT[ 'bonus-preview' ], ToolLoco::TEXTDOMAIN ),
        ] );
    }

	const PAIRS = [
		'post_type' => 'post',

		'taxonomy' => 'category',

		'terms' => [ 'bonusy-kz' ],
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
		// $query_filter = null;

		$compare = '>';

		if ( in_array( $duration, [ self::DURATION[ 'expired' ] ] ) )
		{
			$compare = '<';
		}

		// if ( in_array( $duration, [ self::DURATION[ 'actual' ] ] ) )
		// {
		// 	$query_filter = new ToolDate ( self::FIELD[ 'duration' ], date( 'Y-m-d' ), '%d/%m/%Y', '>' );
		// }

		// if ( in_array( $duration, [ self::DURATION[ 'expired' ] ] ) )
		// {
		// 	// $compare = '<';

		// 	$query_filter = new ToolDate ( self::FIELD[ 'duration' ], date( 'Y-m-d' ), '%d/%m/%Y', '<' );
		// }

		$query_filter = new ToolDate ( self::FIELD[ 'duration' ], date( 'Y-m-d' ), '%d/%m/%Y', $compare );
		
		// $query_filter = new ToolDate ( self::FIELD[ 'duration' ], date( 'Y-m-d' ), '%d/%m/%Y', '<' );

		$args = self::get_args( $atts, $mode );

		// LegalDebug::debug( [
		// 	'args' => $args,
		// ] );

		LegalDebug::debug( [
			'mode' => $mode,

			'duration' => $duration,

			'compare' => $compare,

			'query_filter' => $query_filter,

			'args' => $args,
		] );
		
		$query = $query_filter->createWpQuery( $args );
		
		// $query = $query_filter->createWpQuery( self::get_args( $atts, $mode ) );

		// $query = $query_filter->createWpQuery( self::get_args( $atts ) );

		// $query = $query_filter->createWpQuery( self::get_args( $atts, 'partner' ) );

		// $query = $query_filter->createWpQuery( self::get_args( $atts, 'no-partner' ) );

		// LegalDebug::debug( [
		// 	'query' => $query,
		// ] );

		return $query->posts;
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

		return [
			'posts_per_page' => -1,

            // 'numberposts' => -1,
            
            'post_type' => $atts[ 'post_type' ],

			'suppress_filters' => 0,
            
            // 'orderby' => [ 'date ' => 'DESC', 'title' => 'ASC' ],

			'tax_query' => [

				'taxonomy' => $atts[ 'taxonomy' ],

				'field' => 'slug',

				'terms' => $atts[ 'terms' ],
			],

			'meta_query' => $meta_query,

			'orderby' => [
				'menu_order' => 'ASC',

				'modified' => 'DESC',

				'title' => 'ASC',
			],
        ];
    }

	public static function get_thumbnail( $id )
	{
		if ( $thumbnail_id = get_post_thumbnail_id( $id ) )
		{
			$details = wp_get_attachment_image_src( $thumbnail_id, self::SIZE[ 'preview' ] );

			if ( $details )
			{
				return [
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

	public static function get_logo( $id )
	{
		$logo = get_field( self::FIELD[ 'logo-preview' ], $id );

		if ( $logo )
		{
			return [
				'src' => $logo[ 'url' ],

				'width' => $logo[ 'width' ],

				'height' => $logo[ 'height' ],
			];
		}
		
		return [
			'src' => LegalMain::LEGAL_URL . '/assets/img/bonus/bonus-logo-default.webp',
	
			'width' => '50',

			'height' => '50',
		];
	}

	public static function get_items( $atts )
	{
		$items = [];

		// $posts = get_posts( self::get_args( $atts ) );
		
		// $posts = get_posts( self::get_args( $atts, 'partner' ) );

		// $posts = get_posts( self::get_args( $atts, 'no-partner' ) );

		// $posts = self::get_posts_date( $atts );
		
		// $active_partners = self::get_posts_date( $atts, self::MODE[ 'partner' ], self::DURATION[ 'actual' ] );

		// $active_no_partners = self::get_posts_date( $atts, self::MODE[ 'no-partner' ], self::DURATION[ 'actual' ] );

		// $expired_all = self::get_posts_date( $atts, self::MODE[ 'all' ], self::DURATION[ 'expired' ] );
		
		$posts = self::get_posts_date( $atts, self::MODE[ 'all' ], self::DURATION[ 'expired' ] );

		// $posts = array_merge( $active_partners, $active_no_partners, $expired_all );

		LegalDebug::debug( [
			'count' => count( $posts ),
		] );

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

					// 'logo' => get_field( self::FIELD[ 'logo-preview' ], $post->ID ),
					
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
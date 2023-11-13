<?php

class ReviewOffers
{
	const CSS = [
        // 'review-offers-main' => [
		// 	'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-offers-main.css',

		// 	'ver' => '1.0.1',
		// ],

        'review-offers-compilation' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-offers-compilation.css',

			'ver' => '1.0.2',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

	// const JS = [
    //     'review-offers' => LegalMain::LEGAL_URL . '/assets/js/review/review-offers.js',
    // ];

    // public static function register_script()
    // {
	// 	ReviewMain::register_script( self::JS );
    // }

	// public static function register_inline_style()
    // {
	// 	ReviewMain::register_inline_style( 'review-offers', self::inline_style() );
    // }

	const SHORTCODE = [
		'offers' => 'legal-offers',
	];

	const PAGE_TYPE = [
        'compilation' => 'compilation',
    ];

	public static function check()
    {
		return ReviewMain::check();
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		// add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		// [legal-offers]

		add_shortcode( self::SHORTCODE[ 'offers' ], [ $handler, 'prepare' ] );
    }

	// public static function inline_style()
	// {
	// 	if ( !ReviewMain::check() )
	// 	{
    //         return '';
    //     }

	// 	if ( self::check_compilation() )
	// 	{
    //         return '';
    //     }

	// 	$style = [];

	// 	$style_items = self::get_offers( self::PAIRS );

	// 	if ( !empty( $style_items ) ) {
	// 		foreach ( $style_items as $style_item_id => $style_item ) {
	// 			$style[] = '.legal-other-offers .offers-item-' . $style_item_id . ' .item-logo { background-image: url(\'' . $style_item[ 'logo' ] .'\'); }';

	// 			$style[] = '.legal-other-offers .offers-item-' . $style_item_id . ' { background-color: ' . $style_item[ 'background' ] .'; }';
	// 		}
	// 	}

	// 	return implode( ' ', $style );
	// }

	const FIELD = [
		'title' => 'offer-group-title',

		'about' => 'review-about',
	];

	const REVIEW_ABOUT = [
		'afillate' => 'about-afillate',

		'bonus' => 'about-bonus',

		'logo' => 'about-logo',

		'background' => 'about-background',

		'font' => 'about-font',

		'afillate' => 'about-afillate',
	];

	const TAXONOMY = [
		'page_type' => 'page_type',

		'offer' => 'offer_group',
	];

	public static function get_terms( $id )
	{
		$items = [];

		$terms = wp_get_post_terms( $id, self::TAXONOMY[ 'offer' ] );

		if ( !is_wp_error( $terms ) )
		{
			foreach ( $terms as $term )
			{
				$items[] = $term->slug;
			}
		}

		return $items;
	}

	const OFFER_GROUP = [
		'other' => 'offer-group-other',
	];

	public static function offer_query( $id, $selected_term = '', $limit = 5 )
	{
		$tax_query = [
			[
				'taxonomy' => self::TAXONOMY[ 'offer' ],

				'operator' => 'EXISTS',
			],
		];

		if ( empty( $selected_term ) )
		{
			$terms = self::get_terms( $id );

			if ( !empty( $terms ) )
			{
				$selected_term = array_shift( $terms );
			}
		} 

		if ( !empty( $selected_term ) )
		{
			$tax_query = [
                [
                    'taxonomy' => self::TAXONOMY[ 'offer' ],

                    'field' => 'slug',

                    // 'terms' => array_merge( [ $selected_term ], self::OFFER_GROUP ),
                    
					'terms' => [ $selected_term ],

					'operator' => 'IN',
				],
            ];
		}

		LegalDebug::debug( [
			'function' => 'ReviewOffers::offer_query',

			'selected_term' => $selected_term,
		] );

		return [
			// 'numberposts' => -1,
			
			'numberposts' => $limit,

            'post_type' => [ 'page' ],

			'post_status' => [ 'private', 'publish' ],

            'suppress_filters' => 0,

            'exclude' => $id,

            'tax_query' => $tax_query,

            // 'orderby' => [ 'menu_order' => 'ASC', 'modified' => 'DESC', 'title' => 'ASC' ],
            
			'orderby' => [ 'rand' ],
		];
	}

	public static function check_url_afillate( $href = '' )
	{
		if ( !empty( $href ) )
		{
			return $href;
		}

		return ( OopsMain::check_oops() ? '#' : '' );
	}

	// public static function parse_offers( $offers )
	// {
	// 	$items = [];

	// 	foreach ( $offers as $offer )
	// 	{
	// 		$group = get_field( self::FIELD[ 'about' ], $offer->ID );

	// 		$items[] = [
	// 			'bonus' => $group[ self::REVIEW_ABOUT[ 'bonus' ] ],

	// 			'logo' => $group[ self::REVIEW_ABOUT[ 'logo' ] ],

	// 			'background' => $group[ self::REVIEW_ABOUT[ 'background' ] ],

	// 			'font' => $group[ self::REVIEW_ABOUT[ 'font' ] ],

	// 			'afillate' => [
    //                 'href' => self::check_url_afillate( $group[ self::REVIEW_ABOUT[ 'afillate' ] ] ),

    //                 'text' => __( ReviewMain::TEXT[ 'bet-here' ], ToolLoco::TEXTDOMAIN ),
    //             ],
	// 		];
			
	// 	}

	// 	return $items;
	// }

	public static function parse_offers_compilation( $offers, $suffix = '' )
	{
		$items = [];

		foreach ( $offers as $offer )
		{
			$label = get_field( self::FIELD[ 'title' ], $offer->ID );

			if ( empty( $label ) )
			{
				$label = $offer->post_title;
			}

			if ( !empty( $suffix ) )
			{
				$label .= ' + ' . $suffix;
			}

			$items[] = [
				'label' => $label,

				'href' => get_post_permalink( $offer->ID ),
			];
			
		}

		return $items;
	}

	public static function get_offers( $atts )
	{
		$items = [];

		$post = get_post();

		if ( !empty( $post ) )
		{
			// $query = self::offer_query( $post->ID, $atts[ 'selected-term' ] );

			$query_default_limit = 5;

			$posts_current = [];

			if ( self::OFFER_GROUP[ 'other' ] != $atts[ 'selected-term' ] )
			{
				$posts_current = get_posts(
					self::offer_query( $post->ID, $atts[ 'selected-term' ] )
				);
			}
			else 
			{
				$query_default_limit = 10;
			}

			$posts_default = get_posts(
				self::offer_query( $post->ID, self::OFFER_GROUP[ 'other' ], $query_default_limit )
			);

			// $posts = get_posts( $query );

			$posts = array_merge( $posts_current, $posts_default );

			if ( !empty( $posts ) )
			{
				shuffle( $posts );

				// if ( self::check_compilation() )
				// {
					$items = self::parse_offers_compilation( $posts, $atts[ 'suffix' ] );
				// }
				// else
				// {
				// 	$items = self::parse_offers( $posts );
				// }
			}

			LegalDebug::debug( [
				'function' => 'ReviewOffers::get_offers',

				'selected-term' => $atts[ 'selected-term' ],

				'query_default_limit' => $query_default_limit,

				'posts_current' => count( $posts_current ),

				'posts_default' => count( $posts_default ),

				// 'query' => $query,
			] );
		}
		
		return $items;
	}

	const PAIRS = [
		'selected-term' => '',

		'suffix' => '',
	];

	// public static function check_compilation()
	// {
	// 	return has_term( self::PAGE_TYPE[ 'compilation' ], self::TAXONOMY[ 'page_type' ] );
	// }

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'offers' ] );

		$args = self::get_offers( $atts );

		// if ( self::check_compilation() )
		// {
			return self::render_offers_compilation( $args );
		// }

		// return self::render_offers( $args );
	}

	const TEMPLATE = [
		// 'main' => LegalMain::LEGAL_PATH . '/template-parts/review/review-offers-main.php',

		'compilation' => LegalMain::LEGAL_PATH . '/template-parts/review/review-offers-compilation.php',
	];

    public static function render( $template, $args )
    {
		// if ( !ReviewMain::check() ) {
        //     return '';
        // }

        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }

    // public static function render_offers( $args )
    // {
	// 	return self::render( self::TEMPLATE[ 'main' ], $args );
    // }

    public static function render_offers_compilation( $args )
    {
		return self::render( self::TEMPLATE[ 'compilation' ], $args );
    }
}

?>
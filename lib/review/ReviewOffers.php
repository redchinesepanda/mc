<?php

class ReviewOffers
{
	const CSS = [
        'review-offers-compilation' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-offers-compilation.css',

			'ver' => '1.0.2',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

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

		// [legal-offers]

		add_shortcode( self::SHORTCODE[ 'offers' ], [ $handler, 'prepare' ] );
    }

	const FIELD = [
		'title' => 'offer-group-title',

		'about' => 'review-about',

		'suffix' => 'offer-group-suffix',
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

		if ( !empty( $selected_term ) )
		{
			$tax_query = [
                [
                    'taxonomy' => self::TAXONOMY[ 'offer' ],

                    'field' => 'slug',
                    
					'terms' => [ $selected_term ],

					'operator' => 'IN',
				],
            ];
		}

		return [
			'numberposts' => $limit,

            'post_type' => [ 'page' ],

			'post_status' => [ 'private', 'publish' ],

            'suppress_filters' => 0,

            'exclude' => $id,

            'tax_query' => $tax_query,
            
			'orderby' => [ 'rand' ],
		];
	}

	public static function get_term_current( $id )
	{
		$terms = self::get_terms( $id );

		if ( !empty( $terms ) )
		{
			return array_shift( $terms );
		}

		return '';
	}

	public static function check_url_afillate( $href = '' )
	{
		if ( !empty( $href ) )
		{
			return $href;
		}

		return ( OopsMain::check_oops() ? '#' : '' );
	}

	public static function parse_offers_compilation( $posts, $suffix = '' )
	{
		$items = [];

		foreach ( $posts as $post )
		{
			$label = get_field( self::FIELD[ 'title' ], $post->ID );

			if ( empty( $label ) )
			{
				$label = $post->post_title;
			}

			if ( !empty( $suffix ) )
			{
				$label .= ' ' . $suffix;
			}

			$items[] = [
				'label' => $label,
				
				'href' => get_page_link( $post->ID ),
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
			if ( empty( $atts[ 'selected-term' ] ) )
			{
				$atts[ 'selected-term' ] = self::get_term_current( $post->ID );
			}

			if ( !empty( $atts[ 'selected-term' ] ) )
			{
				$posts_current = [];

				$query_default_limit = 5;

				if ( self::OFFER_GROUP[ 'other' ] != $atts[ 'selected-term' ] )
				{
					$posts_current = get_posts(
						self::offer_query(
							$post->ID,
							
							$atts[ 'selected-term' ]
						)
					);
				}
				else 
				{
					$query_default_limit = 10;
				}

				$posts_default = get_posts(
					self::offer_query(
						$post->ID,
						
						self::OFFER_GROUP[ 'other' ],
						
						$query_default_limit
					)
				);

				if ( !empty( $posts_current ) || !empty( $posts_default ) )
				{
					$suffix = get_field( self::FIELD[ 'suffix' ], $post->ID );

					if ( empty( $suffix ) )
					{
						$suffix = $atts[ 'suffix' ];
					}

					$items_current = self::parse_offers_compilation( $posts_current, $suffix );

					$items_default = self::parse_offers_compilation( $posts_default, '' );

					$items = array_merge( $items_current, $items_default );

					shuffle( $items );
				}
			}
		}
		
		return $items;
	}

	const PAIRS = [
		'selected-term' => '',

		'suffix' => '',

		'check' => 0,
	];

	public static function prepare_offers_bottom()
	{
		return self::prepare( [
			'check' => 1,
		] );
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'offers' ] );

		if ( $atts[ 'check' ] )
		{
			if ( self::check_content() )
			{
				return '';
			}
		}

		$args = self::get_offers( $atts );
		
		return self::render_offers_compilation( $args );
	}

	public static function check_content()
	{
		$post = get_post();

		if ( $post )
		{
			return has_shortcode( $post->post_content, self::SHORTCODE[ 'offers' ] );
		}

		return false;
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
<?php

class ReviewOffers
{
	const JS = [
        'review-offers' => LegalMain::LEGAL_URL . '/assets/js/review/review-offers.js',
    ];

    public static function register_script()
    {
		// if ( self::check() ) {
			ReviewMain::register_script( self::JS );
		// }
    }

	const CSS = [
        'review-offers' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-offers.css',

			'ver' => '1.0.0',
		],
    ];

    public static function register_style()
    {
		// if ( self::check() ) {
        	ReviewMain::register_style( self::CSS );
		// }
    }

	public static function register_inline_style()
    {
		// if ( self::check() ) {
			// ToolEnqueue::register_inline_style( 'review-offers', self::inline_style() );
			ReviewMain::register_inline_style( 'review-offers', self::inline_style() );
		// }
    }

	const SHORTCODE = [
		'offers' => 'legal-offers',
	];

	const PAGE_TYPE = [
        'compilation' => 'compilation',
    ];

	public static function check()
    {
		// $permission_term = !has_term( self::PAGE_TYPE[ 'compilation' ], self::TAXONOMY[ 'page_type' ] );

        // return ReviewMain::check() && $permission_term;
        
		return ReviewMain::check();
    }

	public static function register()
    {
        $handler = new self();

        // add_filter( 'the_content', [ $handler, 'get_content' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		// add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

		// [legal-offers terms=""]

		add_shortcode( self::SHORTCODE[ 'offers' ], [ $handler, 'prepare' ] );
    }

	public static function inline_style()
	{
		if ( !ReviewMain::check() ) {
            return '';
        }

		$style = [];

		$style_items = self::get_offers( self::PAIRS );

		if ( !empty( $style_items ) ) {
			foreach ( $style_items as $style_item_id => $style_item ) {
				$style[] = '.legal-other-offers .offers-item-' . $style_item_id . ' .item-logo { background-image: url(\'' . $style_item[ 'logo' ] .'\'); }';

				$style[] = '.legal-other-offers .offers-item-' . $style_item_id . ' { background-color: ' . $style_item[ 'background' ] .'; }';
			}
		}

		return implode( ' ', $style );
	}

	const FIELD = [
		'about' => 'review-about',

		'afillate' => 'about-afillate',

		'bonus' => 'about-bonus',

		'logo' => 'about-logo',

		'background' => 'about-background',

		'font' => 'about-font',

		'afillate' => 'about-afillate',

		'offer' => 'tabs-title-offer',
	];

	const TAXONOMY = [
		// 'group' => 'page_group',

		'page_type' => 'page_type',

		'offer' => 'offer_group',
	];

	// const OFFER = [
	// 	// 'term_id',

	// 	// 'name',

	// 	'slug',
	// ];

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

		// LegalDebug::debug( [
		// 	'function' => 'ReviewOffers::get_terms',

		// 	'id' => $id,

		// 	'terms' => $terms,

		// 	'items' => $items,
		// ] );

		return $items;
	}

	public static function offer_query( $id, $selected_term = '' )
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

                    'terms' => [ $selected_term ],

					'operator' => 'IN',
				],
            ];
		}

		// LegalDebug::debug( [
		// 	'function' => 'ReviewOffers::offer_query',

		// 	'id' => $id,

		// 	'selected_term' => $selected_term,
		// ] );

		return [
			'numberposts' => -1,

            'post_type' => [ 'page' ],

            'suppress_filters' => 0,

            'exclude' => $id,

            'tax_query' => $tax_query,

            'orderby' => [ 'menu_order' => 'ASC', 'modified' => 'DESC' ],
		];
	}

	public static function parse_offers( $offers )
	{
		$items = [];

		foreach ( $offers as $offer )
		{
			$group = get_field( self::FIELD[ 'about' ], $offer->ID );

			$items[] = [
				'bonus' => $group[ self::FIELD[ 'bonus' ] ],

				'logo' => $group[ self::FIELD[ 'logo' ] ],

				'background' => $group[ self::FIELD[ 'background' ] ],

				'font' => $group[ self::FIELD[ 'font' ] ],

				'afillate' => [
                    'href' => $group[ self::FIELD[ 'afillate' ] ],

                    'text' => __( ReviewMain::TEXT[ 'bet-here' ], ToolLoco::TEXTDOMAIN ),
                ],
			];
			
		}

		return $items;
	}

	public static function parse_offers_compilation( $offers )
	{
		$items = [];

		foreach ( $offers as $offer )
		{
			$items[] = [
				'label' => get_field( self::FIELD[ 'offer' ], $offer->ID ),

				'href' => get_post_permalink( $offer->ID ),
			];
			
		}

		return $items;
	}

	public static function get_offers( $atts = [] )
	{
		$items = [];

		$post = get_post();

		if ( !empty( $post ) )
		{
			$query = self::offer_query( $post->ID, $atts[ 'selected-term' ] );

			$posts = get_posts( $query );

			if ( !empty( $posts ) )
			{
				if ( self::check_compilation() )
				{
					$items = self::parse_offers_compilation( $posts );
				}
				else
				{
					$items = self::parse_offers( $posts );
				}
			}
		}

		// LegalDebug::debug( [
		// 	'function' => 'ReviewOffers::get_offers',

		// 	'atts' => $atts,

		// 	'query' => $query,

		// 	'items' => $items,
		// ] );
		
		return $items;
	}

	const PAIRS = [
		'selected-term' => '',
	];

	// public static function prepare_array( $items )
	// {
	// 	if ( !is_array( $items ) )
	// 	{
	// 		$items = preg_replace( '/\s*,\s*/', ',', filter_var( $items, FILTER_SANITIZE_STRING ) );
	
	// 		return explode( ',', $items );
	// 	}

	// 	return $items;
	// }

	public static function check_compilation()
	{
		return has_term( self::PAGE_TYPE[ 'compilation' ], self::TAXONOMY[ 'page_type' ] );
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'offers' ] );

		// $atts[ 'terms' ] = self::prepare_array( $atts[ 'terms' ] );

		$args = self::get_offers( $atts );
		
		// LegalDebug::debug( [
		// 	'function' => 'ReviewOffers::prepare',

		// 	'atts' => $atts,

		// 	'args' => $args,
		// ] );

		if ( self::check_compilation() )
		{
			return self::render_offers_compilation( $args );
		}

		return self::render_offers( $args );
	}

	const TEMPLATE = [
		'main' => LegalMain::LEGAL_PATH . '/template-parts/review/review-offers-main.php',

		'compilation' => LegalMain::LEGAL_PATH . '/template-parts/review/review-offers-compilation.php',
	];

    public static function render( $template, $args )
    {
		if ( !ReviewMain::check() ) {
            return '';
        }

        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_offers( $args )
    {
		return self::render( self::TEMPLATE[ 'main' ], $args );
    }

    public static function render_offers_compilation( $args )
    {
		return self::render( self::TEMPLATE[ 'compilation' ], $args );
    }

	// public static function get_content( $content )
	// {
    //     if ( !self::check() ) {
	// 		return $content;
	// 	}

	// 	$dom = LegalDOM::get_dom( $content );

	// 	$body = $dom->getElementsByTagName( 'body' )->item( 0 );

	// 	if ( empty( $body ) ) {
	// 		return $content;
	// 	}

	// 	$item = $dom->createElement( 'div' );

	// 	$item->setAttribute( 'class', 'legal-other-offers-wrapper' ); 

	// 	LegalDOM::appendHTML( $item, ToolEncode::encode( self::render_offers() ) );

	// 	try
	// 	{
	// 		$body->appendChild( $item );
	// 	} catch ( DOMException $e )
	// 	{
	// 		LegalDebug::debug( [
	// 			'ReviewOffers::get_content > appendChild DOMException',
	// 		] );
	// 	}

	// 	return $dom->saveHTML();
	// }
}

?>
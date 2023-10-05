<?php

class ReviewOffers
{
	const JS = [
        'review-offers' => LegalMain::LEGAL_URL . '/assets/js/review/review-offers.js',
    ];

    public static function register_script()
    {
		if ( self::check() ) {
			ReviewMain::register_script( self::JS );
		}
    }

	const CSS = [
        'review-offers' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-offers.css',

			'ver' => '1.0.0',
		],
    ];

    public static function register_style()
    {
		if ( self::check() ) {
        	ReviewMain::register_style( self::CSS );
		}
    }

	public static function register_inline_style()
    {
		if ( self::check() ) {
			ToolEnqueue::register_inline_style( 'review-offers', self::inline_style() );
		}
    }

	const SHORTCODE = [
		'offers' => 'legal-offers',
	];

	const PAGE_TYPE = [
        'compilation' => 'compilation',
    ];

	public static function check()
    {
		$permission_term = !has_term( self::PAGE_TYPE[ 'compilation' ], self::TAXONOMY[ 'page_type' ] );

        return ReviewMain::check() && $permission_term;
    }

	public static function register()
    {
        $handler = new self();

        // add_filter( 'the_content', [ $handler, 'get_content' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		// add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

		// [legal-offers terms=""]

		// add_shortcode( self::SHORTCODE[ 'offers' ], [ $handler, 'prepare' ] );
    }

	public static function inline_style()
	{
		if ( !self::check() ) {
            return '';
        }

		$style = [];

		$style_items = self::get_offers();

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
	];

	const TAXONOMY = [
		// 'group' => 'page_group',

		'page_type' => 'page_type',

		'offer' => 'offer_group',
	];

	// const TERM = [
	// 	'offers' => 'other-offers',
	// ];

	public static function get_terms( $id )
	{
		$terms = self::get_terms( $id );

		if ( !is_wp_error( $terms ) )
		{
			return $terms;
		}

		return [];
	}

	public static function offer_query( $id, $terms = [] )
	{
		$tax_query = [
			[
				'taxonomy' => self::TAXONOMY[ 'offer' ],

				'operator' => 'EXISTS',
			],
		];

		if ( empty( $terms ) )
		{
			$terms = self::get_terms( $id );
		}

		if ( !empty( $terms ) )
		{
			$tax_query = [
                [
                    'taxonomy' => self::TAXONOMY[ 'offer' ],

                    'field' => 'slug',

                    'terms' => $terms,

					'operator' => 'IN',
				],
            ];
		}

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

	public static function get_offers( $atts = [] )
	{
		$items = [];

		// $post = get_post();

		// if ( !empty( $post ) )
		// {
		// 	$query = self::offer_query( $post->ID, $atts[ 'terms' ] );

		// 	$offers = get_posts(  );

		// 	if ( !empty( $offers ) )
		// 	{
		// 		$items = self::parse_offers( $offers );
		// 	}
		// }
		
		return $items;
	}

	const PAIRS = [
		'terms' => '',
	];

	public static function prepare_array( $items )
	{
		if ( !is_array( $items ) )
		{
			$items = preg_replace( '/\s*,\s*/', ',', filter_var( $items, FILTER_SANITIZE_STRING ) );
	
			return explode( ',', $items );
		}

		return $items;
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'offers' ] );

		$atts[ 'terms' ] = self::prepare_array( $atts[ 'terms' ] );

		$args = self::get_offers( $atts );

		return self::render( $args );
	}

	const TEMPLATE = [
		'offers' => LegalMain::LEGAL_PATH . '/template-parts/review/review-offers.php',
	];

    public static function render_offers( $args )
    {
		if ( !self::check() ) {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'offers' ], false, $args );

        $output = ob_get_clean();

        return $output;
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
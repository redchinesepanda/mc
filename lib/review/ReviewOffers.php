<?php

class ReviewOffers
{
	const JS = [
        'review-offers' => LegalMain::LEGAL_URL . '/assets/js/review/review-offers.js',
    ];

    public static function register_script()
    {
		BaseMain::register_script( self::JS );
    }

	const CSS = [
        'review-offers' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-offers.css',

			'ver' => '1.0.0',
		],
    ];

    public static function register_style()
    {
        BaseMain::register_style( self::CSS );
    }

	public static function register_inline_style()
    {
		ToolEnqueue::register_inline_style( 'review-offers', self::inline_style() );
    }

	public static function register()
    {
        $handler = new self();

        add_filter( 'the_content', [ $handler, 'get_content' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

	public static function inline_style() {
		$style = [];

		$style_items = self::get_offers();

		if ( !empty( $style_items ) ) {
			foreach ( $style_items as $style_item_id => $style_item ) {
				$style[] = '.legal-other-offers .offers-item-' . $style_item_id . ' .item-logo { background-image: url(\'' . $style_item[ 'logo' ] .'\'); }';
			}
		}

		return implode( ' ', $style );
	}

	const FIELD = [
		'about' => 'review-about',

		'afillate' => 'about-afillate',

		'bonus' => 'about-bonus',

		'logo' => 'about-logo',

		'afillate' => 'about-afillate',
	];

	const TAXONOMY = [
		'group' => 'page_group',
	];

	const TERM = [
		'offers' => 'other-offers',
	];

	public static function offer_query( $post )
	{
		return [
			'numberposts' => -1,

            'post_type' => [ 'legal_bk_review', 'page' ],

            'suppress_filters' => 0,

            'exclude' => $post->ID,

			'meta_query' => [
                [
                    'key' => self::FIELD[ 'about' ] . '_' . self::FIELD[ 'afillate' ],
                ],
            ],

            // 'tax_query' => [
            //     [
            //         'taxonomy' => self::TAXONOMY[ 'group' ],

            //         'field' => 'slug',

            //         'terms' => self::TERM[ 'offers' ],
			// 	],
            // ],

            'orderby' => [ 'menu_order' => 'ASC', 'modified' => 'DESC' ],
		];
	}

	public static function parse_offers( $offers )
	{
		$items = [];

		foreach ( $offers as $offer )
		{
			$group = get_field( self::FIELD[ 'about' ], $offer->ID );

			LegalDebug::debug( [
				'bonus' => $group[ self::FIELD[ 'bonus' ] ],

				'afillate' => ( $group[ self::FIELD[ 'afillate' ] ] ? $group[ self::FIELD[ 'afillate' ] ] : 'false' ),
			] );

			$items[] = [
				'bonus' => $group[ self::FIELD[ 'bonus' ] ],

				'logo' => $group[ self::FIELD[ 'logo' ] ],

				'afillate' => [
                    'href' => $group[ self::FIELD[ 'afillate' ] ],

                    'text' => __( 'Bet here', ToolLoco::TEXTDOMAIN ),
                ],
			];
		}

		return $items;
	}

	public static function get_offers()
	{
		$items = [];

		$post = get_post();

		if ( !empty( $post ) )
		{
			$offers = get_posts( self::offer_query( $post ) );

			if ( !empty( $offers ) )
			{
				$items = self::parse_offers( $offers );
			}
		}

		LegalDebug::debug( [
			'id' => $post->ID,

			// 'query' => self::offer_query( $post ),

			'offers' => count( $offers ),

			'items' => count( $items ),
		] );

		return $items;
	}

	const TEMPLATE = [
		'offers' => LegalMain::LEGAL_PATH . '/template-parts/review/review-offers.php',
	];

    public static function render_offers()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'offers' ], false, self::get_offers() );

        $output = ob_get_clean();

        return $output;
    }

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		return $xpath->query( './/h2' );
	}

	public static function get_content( $content )
	{
        if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

		$body = $dom->getElementsByTagName( 'body' )->item(0);

		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		$item = $dom->createElement( 'div' );

		$item->setAttribute( 'class', 'legal-other-offers' );

		LegalDOM::appendHTML( $item, self::render_offers() );

		$body->insertBefore( $item, $nodes->item( $nodes->length - 1 ) );

		return $dom->saveHTML();
	}
}

?>
<?php

class WikiPreview
{
	const CSS = [
        'legal-wiki-preview' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-preview.css',

            'ver'=> '1.0.0',
        ],
    ];
	
	public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        // [legal-wiki terms='kak-delat-stavki-na-sport']

        add_shortcode( self::SHORTCODE[ 'wiki' ], [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const PAIRS = [
		'post_type' => 'post',

		'taxonomy' => 'category',

		'terms' => [ 'kak-delat-stavki-na-sport' ],

		'limit' => 5,

		'featured' => false,
	];

	const SHORTCODE = [
		'wiki' => 'legal-wiki',
	];

	public static function offer_query( $atts )
	{
		return [
			'numberposts' => $atts[ 'limit' ],

            'post_type' => [ $atts[ 'post_type' ] ],

			'post_status' => [ 'private', 'publish' ],

            'suppress_filters' => 0,

            'tax_query' => [
                [
                    'taxonomy' => $atts[ 'taxonomy' ],

                    'field' => 'slug',
                    
					'terms' => [ $atts[ 'terms' ] ],

					'operator' => 'IN',
				],
            ],

            'orderby' => [ 'menu_order' => 'ASC', 'modified' => 'DESC', 'title' => 'ASC' ],
		];
	}

	public static function get_items( $posts )
	{
		$items = [];

		if ( !empty( $posts ) )
		{
			foreach ( $posts as $post )
			{
				$post_url = get_post_permalink( $post->ID );

				$preview = BonusPreview::get_thumbnail( $post->ID );

				$items[] = [
					'id' => $post->ID,

					'href' => $post_url,

					'preview' => $preview,

					'title' => $post->post_title,
				]; 
			}
		}

		return $items;
	}

	public static function get_items_shortcode( $atts )
	{
		return self::get_items( self::group_posts( $atts ) );
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'wiki' ] );

		$items = self::get_items_shortcode( $atts );

		$args = [
			'items' => $items,
		];

		return self::render( $args );
	}
	
	const TEMPLATE = [
        'legal-wiki-preview' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-preview.php',
    ];

    public static function render( $args )
    {
		if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-wiki-preview' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
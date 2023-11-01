<?php

class ForecastPreview
{
	const CSS = [
        'legal-forecast-preview' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/forecast/legal-forecast-preview.css',

            'ver'=> '1.0.0',
        ],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

	const SHORTCODE = [
		'forecast-preview' => 'legal-forecast-preview',
	];

	const TAXONOMY = [
		'post-tag' => 'post_tag',
	];

	public static function register()
    {
        $handler = new self();

        // [legal-forecast-preview post_type='page' taxonomy='post_tag' terms='prognozy-na-mma' limit=6]

        add_shortcode( self::SHORTCODE[ 'forecast-preview' ], [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const ACF_FIELD = [
		'forecast-date' => 'Databoya',
	];

	public static function get_items( $posts )
	{
		$items = [];

		if ( !empty( $posts ) )
		{
			foreach ( $posts as $post )
			{
				$items[] = [
					'id' => $post->ID,

					'href' => get_post_permalink( $post->ID ),

					'preview' => BonusPreview::get_thumbnail( $post->ID ),

					'title' => $post->post_title,

					'date' => get_field( self::ACF_FIELD[ 'forecast-date' ] ),
				]; 
			}
		}

		return $items;
	}

	public static function get_args( $atts )
    {
		return [
			'posts_per_page' => $atts[ 'limit' ],

			'post_type' => $atts[ 'post_type' ],

			'post_status' => 'publish',

			'suppress_filters' => 0,

			// 'tax_query' => [
			// 	[
			// 		'taxonomy' => $atts[ 'taxonomy' ],
	
			// 		'field' => 'slug',
	
			// 		'terms' => $atts[ 'terms' ],
			// 	]
			// ],

			'tag_slug__in' = $atts[ 'tags' ],

			'orderby' => [
				'modified' => 'DESC',

				'title' => 'ASC',
			],
        ];
    }

	public static function shortcode_get_items( $atts )
	{
		return self::get_items(
			get_posts(
				self::get_args( $atts )
			)
		);
	}

	const PAIRS = [
		'post_type' => 'page',

		'taxonomy' => 'post_tag',

		'terms' => [ 'prognozy-na-sport' ],

		'limit' => 6,
	];

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'forecast-preview' ] );

		$items = self::shortcode_get_items( $atts );

		$args = [
			'items' => $items,
		];

		return self::render( $args );
	}

	const TEMPLATE = [
        'legal-forecast-preview' => LegalMain::LEGAL_PATH . '/template-parts/forecast/part-legal-forecast-preview.php',
    ];

	public static function render( $args )
    {
		ob_start();

        load_template( self::TEMPLATE[ 'legal-forecast-preview' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
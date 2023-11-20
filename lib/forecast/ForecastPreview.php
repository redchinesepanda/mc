<?php

class ForecastPreview
{
	const CSS = [
        'legal-forecast-preview' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/forecast/legal-forecast-preview.css',

            'ver'=> '1.0.3',
        ],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

	public static function register_inline_style()
    {
        ToolEnqueue::register_inline_style( 'legal-forecast-preview', self::get_inline_style() );
    }

	const SHORTCODE_INLINE = [
        self::SHORTCODE[ 'forecast-preview' ],
    ];

	public static function get_atts( $matches )
    {
        $atts = [];

        if ( !empty( $matches ) )
        {
            foreach ( $matches as $match )
            {
                $atts[] = shortcode_atts(
					self::PAIRS,

					shortcode_parse_atts( $match[ 3 ] ),
					self::SHORTCODE[ 'forecast-preview' ]
				);
            }
        }

        return $atts;
    }

	public static function get_shortcode()
    {
        $matches = [];

        $post = get_post();

        if ( $post )
        {
            $regex = get_shortcode_regex( self::SHORTCODE_INLINE );

            $amount = preg_match_all( 
                '/' . $regex . '/', 
    
                $post->post_content,
    
                $matches,
    
                PREG_SET_ORDER
            );
        }

        // return self::get_attr_id( $matches );

        return $matches;
    }

	public static function get_inline_style()
	{
		$output = [];

		$shortcodes = self::get_shortcode();

		$atts_all = self::get_atts( $shortcodes );

		if ( !empty( $atts_all ) )
        {
            foreach ( $atts_all as $atts )
            {
				$args = [
					'items' => self::shortcode_get_items( $atts ),
				];

				// LegalDebug::debug( [
				// 	'function' => 'ForecastPreview::get_inline_style',
		
				// 	'args' => $args,
				// ] );

                $output[] = self::render_inline( $args );
            }
        }

		// LegalDebug::debug( [
		// 	'function' => 'ForecastPreview::get_inline_style',

		// 	'atts_all' => $atts_all,
		// ] );

        return implode( PHP_EOL, $output );
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

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
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

					'date' => get_field( self::ACF_FIELD[ 'forecast-date' ], $post->ID ),
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

			'tag_slug__in' => $atts[ 'terms' ],

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

        'legal-forecast-preview-style' => LegalMain::LEGAL_PATH . '/template-parts/forecast/part-legal-forecast-preview-style.php',
    ];

	public static function render( $args )
    {
		ob_start();

        load_template( self::TEMPLATE[ 'legal-forecast-preview' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }

	public static function render_inline( $args )
    {
		ob_start();

        load_template( self::TEMPLATE[ 'legal-forecast-preview-style' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
<?php

class ToolSitemap
{
	const CSS = [
        'tool-sitemap-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-sitemap-main.css',

            'ver'=> '1.0.5',
        ],
    ];

	const CSS_NEW = [
        'tool-sitemap-main-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-sitemap-main-new.css',

			'ver' => '1.0.0',
		],
    ];

/* 	public static function register_style()
    {
		if ( self::check() )
		{
			ToolEnqueue::register_style( self::CSS );
		}
    } */

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

	const SHORTCODE = [
		'sitemap' => 'legal-sitemap',
	];

	const TAXONOMY = [
		'page_type' => 'page_type',
	];

	const PAGE_TYPE = [
		'sitemap' => 'legal-sitemap',
	];

	public static function check_page_type()
	{
		return has_term( self::PAGE_TYPE, self::TAXONOMY[ 'page_type' ] );
	}

	public static function check()
	{
		return self::check_page_type();
	}

	public static function register()
    {
		$handler = new self();

        // [legal-sitemap post_type='page' taxonomy='page_type' terms='review']

		add_shortcode( self::SHORTCODE[ 'sitemap' ], [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function get_args( $atts )
    {
		return [
            'numberposts' => -1,
            
            'post_type' => $atts[ 'post_type' ],

			'post_status' => 'publish',
			
			'suppress_filters' => 0,
			
			'tax_query' => [
				[
					'taxonomy' => $atts[ 'taxonomy' ],

					'field' => 'slug',

					'terms' => $atts[ 'terms' ],

					// 'operator' => 'AND',
					
					'operator' => 'IN',
				],
			],
			
			'orderby' => [ 'date' => 'DESC', 'title' => 'ASC' ],
        ];
    }

	public static function parse_posts( $posts )
    {
		$items = [];

		if ( !empty( $posts ) ) {
			foreach ( $posts as $post )
			{
				// LegalDebug::debug( [
				// 	'ToolSitemap' => 'parse_posts',

				// 	'get_permalink' => get_permalink( $post->ID ),

				// 	'get_post_permalink' => get_post_permalink( $post->ID ),
				// ] );

				$items[] = [
					'label' => $post->post_title,
					
					'href' => get_permalink( $post->ID ),
					
					// 'href' => get_post_permalink( $post->ID ),
				];
			}
		}

        return $items;
    }

	const PAIRS = [
		'post_type' => 'page',

		'taxonomy' => 'page_type',

		'terms' => [ 'bookmaker-review' ],

		'title' => '',
	];

	public static function get_settings( $atts )
	{
		return [
			'title' => $atts[ 'title' ],
		];
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'sitemap' ] );
		
		$atts[ 'terms' ] = ToolShortcode::validate_array( $atts[ 'terms' ] );

		$args = self::get_args( $atts );

		$posts = get_posts( $args );

		$args_render = [
			'items' => self::parse_posts( $posts ),

			'settings' => self::get_settings( $atts ),
		];

        return self::render_main( $args_render );
    }
	
	const TEMPLATE = [
        'sitemap' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-sitemap.php',

        'items' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-sitemap-items.php',
    ];

    public static function render_main( $args )
	{
		return self::render( self::TEMPLATE[ 'sitemap' ], $args );
	}

    public static function render_items( $args )
	{
		return self::render( self::TEMPLATE[ 'items' ], $args );
	}

    public static function render( $template, $args )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
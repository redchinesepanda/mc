<?php

class ToolSitemap
{
	const CSS = [
        'tool-sitemap-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-sitemap-main.css',

            'ver'=> '1.0.0',
        ],
    ];

	public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	const SHORTCODE = [
		'sitemap' => 'legal-sitemap',
	];

	public static function register()
    {
        $handler = new self();

        // [legal-sitemap post_type='page' taxonomy='page_type' terms='review']

		add_shortcode( self::SHORTCODE[ 'sitemap' ], [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function get_args( $atts )
    {
		// $tax_query = [];

		// if ( !empty( $atts[ 'taxonomy' ] ) && !empty( $atts[ 'terms' ] ) && $atts[ 'url' ] ) {
		// 	$tax_query[] = [
		// 		'taxonomy' => $atts[ 'taxonomy' ],

		// 		'field' => 'slug',

		// 		'terms' => $atts[ 'terms' ],
		// 	];
		// }

		// $suppress_filters = 0;

		// $orderby = [ 'date' => 'DESC', 'title' => 'ASC' ];

		// $numberposts = -1;

		// if ( $atts[ 'lang' ] )
		// {
		// 	// $numberposts = 60;

		// 	// $suppress_filters = 1;

		// 	$orderby = [ 'name' => 'ASC' ];
		// }

		// $offset = 0;

		// if ( $atts[ 'lang' ] && !empty( $_GET[ 'offset' ] ) )
		// {
		// 	$offset = $_GET[ 'offset' ];
		// }

        return [
            // 'numberposts' => -1,
            
			// 'numberposts' => $numberposts,
			
			'numberposts' => -1,

			// 'offset' => $offset,
            
            'post_type' => $atts[ 'post_type' ],

			'post_status' => 'publish',

			// 'suppress_filters' => $suppress_filters,
			
			'suppress_filters' => 0,

			// 'tax_query' => $tax_query,
			
			'tax_query' => [
				[
					'taxonomy' => $atts[ 'taxonomy' ],

					'field' => 'slug',

					'terms' => $atts[ 'terms' ],

					'operator' => 'AND',
				],
			],
            
			// 'orderby' => $orderby,
			
			'orderby' => [ 'date' => 'DESC', 'title' => 'ASC' ],
        ];
    }

	public static function parse_posts( $posts )
    {
		$items = [];

		if ( !empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$items[] = [
					'label' => $post->post_title,

					// 'href' => get_post_permalink( $post->ID ),
					
					'href' => get_permalink( $post->ID ),
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

		// 'url' => false,

		// 'lang' => false,
	];

	public static function get_settings( $atts )
	{
		// $class = '';

		// if ( !empty( $atts[ 'title' ] ) )
		// {
		// 	$class = 'legal-sitemap-item';
		// }

		return [
			// 'url' => $atts[ 'url' ],

			'title' => $atts[ 'title' ],

			// 'class' => $class,
		];
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'sitemap' ] );

		// $atts[ 'url' ] = wp_validate_boolean( $atts[ 'url' ] );

		// $atts[ 'lang' ] = wp_validate_boolean( $atts[ 'lang' ] );
		
		$atts[ 'terms' ] = ToolShortcode::validate_array( $atts[ 'terms' ] );

		$args = self::get_args( $atts );

		$posts = get_posts( $args );

		// LegalDebug::debug( [
		// 	'function' => 'ToolSitemap::prepare',

		// 	'args' => $args,

		// 	'posts' => count( $posts ),
		// ] );

		$args_render = [
			'items' => self::parse_posts( $posts ),

			'settings' => self::get_settings( $atts ),
		];

        return self::render_main( $args_render );
    }
	
	const TEMPLATE = [
        'sitemap' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-sitemap.php',

        'items' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-sitemap-items.php',

        // 'url' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-sitemap-url.php',
    ];

    public static function render_main( $args )
	{
		return self::render( self::TEMPLATE[ 'sitemap' ], $args );
	}

    public static function render_items( $args )
	{
		return self::render( self::TEMPLATE[ 'items' ], $args );
	}

    public static function render_url( $args )
	{
		return self::render( self::TEMPLATE[ 'url' ], $args );
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
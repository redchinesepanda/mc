<?php

class ToolSitemap
{
	public static function register()
    {
        $handler = new self();

        // [legal-sitemap post_type='legal_bk_review' taxonomy='page_type' terms='review']

		// add_shortcode( 'legal-sitemap', [ $handler, 'render' ] );

		add_shortcode( 'legal-sitemap', [ $handler, 'prepare' ] );
    }

	public static function prepare( $atts )
    {
		$pairs = [
			'post_type' => 'legal_bk_review',

			'taxonomy' => '',

			'terms' => '',

			'url' => false,

			'lang' => false,
		];

		$atts = shortcode_atts( $pairs, $atts, 'legal-sitemap' );

		$args = self::get_args( $atts );

		$posts = get_posts( $args );

		$args_render = [
			'items' => self::parse_posts( $posts ),

			'url' => $atts[ 'url' ],
		];

        return self::render( $args_render );
    }

	public static function get_args( $atts )
    {
		$tax_query = [];

		if ( !empty( $atts[ 'taxonomy' ] ) && !empty( $atts[ 'terms' ] ) && $atts[ 'url' ] ) {
			$tax_query[] = [
				'taxonomy' => $atts[ 'taxonomy' ],

				'field' => 'slug',

				'terms' => $atts[ 'terms' ],
			];
		}

		$suppress_filters = 0;

		$orderby = [ 'date' => 'DESC', 'title' => 'ASC' ];

		$numberposts = -1;

		if ( $atts[ 'lang' ] )
		{
			$numberposts = 60;

			$suppress_filters = 1;

			$orderby = [ 'name' => 'ASC' ];
		}

		$offset = 0;

		if ( $atts[ 'lang' ] && !empty( $_GET[ 'offset' ] ) )
		{
			$offset = $_GET[ 'offset' ];
		}

        return [
            // 'numberposts' => -1,
            
			'numberposts' => $numberposts,

			'offset' => $offset,
            
            'post_type' => $atts[ 'post_type' ],

			'post_status' => 'publish',

			'suppress_filters' => $suppress_filters,
            
			'orderby' => $orderby,

			'tax_query' => $tax_query,
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
	
	const TEMPLATE = [
        'sitemap' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-sitemap.php',
    ];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'sitemap' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
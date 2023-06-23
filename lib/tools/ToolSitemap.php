<?php

class ToolSitemap
{
	public static function register()
    {
        $handler = new self();

        // [legal-sitemap]

		add_shortcode( 'legal-sitemap', [ $handler, 'render' ] );
    }

	public static function get_args( $post_type, $tax_query )
    {
		$tax_query = [];

		if ( !empty( $term ) ) {
			$tax_query[] = [
				'taxonomy' => $tax_query[ 'taxonomy' ],

				'field' => 'slug',

				'terms' => $tax_query[ 'terms' ],
			];
		}

        return [
            'numberposts' => -1,
            
            'post_type' => $post_type,

			'suppress_filters' => 0,
            
            'orderby' => [ 'date ' => 'DESC', 'title' => 'ASC' ],

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

					'href' => get_post_permalink( $post->ID ),
				];
			}
		}

        return $items;
    }

	public static function get( $atts )
	{
		$post_type = 'legal_bk_review';

		$term = '';

		if ( !empty( $atts[ 'post_type' ] ) ) {
			$post_type = $atts[ 'post_type' ];
		}

		if ( !empty( $atts[ 'term' ] ) ) {
			$term = $atts[ 'term' ];
		}

		$args = self::get_args( $post_type, $term );

		$posts = get_posts( $args );

		return self::parse_posts( $posts );
	}
	
	const TEMPLATE = [
        'sitemap' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-sitemap.php',
    ];

    public static function render( $atts )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'sitemap' ], false, self::get( $atts ) );

        $output = ob_get_clean();

        return $output;
    }
}

?>
<?php

class ToolSitemap
{
	public static function register()
    {
        $handler = new self();

        // [legal-sitemap]

		add_shortcode( 'legal-sitemap', [ $handler, 'render' ] );
    }

	public static function get_args( $post_type )
    {
        return [
            'numberposts' => -1,
            
            'post_type' => $post_type,

			'suppress_filters' => 0,
            
            'orderby' => [ 'date ' => 'DESC', 'title' => 'ASC' ],
        ];
    }

	public static function get_posts( $post_type )
    {
        return get_posts( self::get_args( $post_type ) );
    }

	public static function parse_posts( $post_type )
    {
		$items = [];

		$posts = self::get_posts( $post_type );

		if ( !empty( $posts ) ) {
			foreach ( $posts as $post ) {
				// LegalDebug::debug( [
				// 	'ID' => $post->ID,

				// 	'post_title' => $post->post_title,

				// 	'get_post_permalink' => get_post_permalink( $post->ID ),

				// 	'wpml_post_language_details' => apply_filters( 'wpml_post_language_details', NULL, $post->ID ),
				// ] );

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

		if ( !empty( $atts[ 'post_type' ] ) ) {
			$post_type = $atts[ 'post_type' ];
		}

		return self::parse_posts( $post_type );
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
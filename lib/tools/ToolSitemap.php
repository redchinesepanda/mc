<?php

class ToolSitemap
{
	public static function register()
    {
        $handler = new self();

        // [legal-sitemap]

		add_shortcode( 'legal-sitemap', [ $handler, 'render' ] );
    }
	
	const TEMPLATE = [
        'sitemap' => LegalMain::LEGAL_PATH . '/template-parts/tool/part-tool-sitemap.php',
    ];

	public static function get_args()
    {
        return [
            'numberposts' => -1,
            
            'post_type' => 'legal_bk_review',
            
            'orderby' => [ 'date ' => 'DESC', 'title' => 'ASC' ],
        ];
    }

	public static function get_posts()
    {
        return get_posts( self::get_args() );
    }

	public static function parse_posts()
    {
		$items = [];

		$posts = self::get_posts();

		if ( !empty( $posts ) ) {
			foreach ( $posts as $post ) {
				LegalDebug::debug( [
					'ID' => $post->ID,

					'post_title' => $post->post_title,

					'get_post_permalink' => get_post_permalink( $post->ID ),
				] );
			}
		}

        return $items;
    }

	public static function get()
	{
		return self::parse_posts();
	}

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'sitemap' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
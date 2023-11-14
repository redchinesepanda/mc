<?php

class WikiPreview
{
	const CSS = [
        'legal-wiki-preview-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-preview-main.css',

            'ver'=> '1.0.0',
        ],

        'legal-wiki-preview-featured' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-preview-featured.css',

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

	const TAXONOMY = [
		'category' => 'category',
	];

	const PAIRS = [
		'post_type' => 'post',

		'taxonomy' => self::TAXONOMY[ 'category' ],

		'terms' => [ 'kak-delat-stavki-na-sport' ],

		'limit' => 5,

		'featured' => false,
	];

	const SHORTCODE = [
		'wiki' => 'legal-wiki',
	];

	public static function preview_query( $atts )
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
                    
					'terms' => $atts[ 'terms' ],

					// 'operator' => 'IN',
					
					'operator' => 'AND',
				],
            ],

            'orderby' => [ 'menu_order' => 'ASC', 'modified' => 'DESC', 'title' => 'ASC' ],
		];
	}

	public static function get_posts( $atts )
	{
		// LegalDebug::debug( [
		// 	'function' => 'get_posts',

		// 	'preview_query' => self::preview_query( $atts ),
		// ] );

		return get_posts( self::preview_query( $atts ) );
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

	public static function get_term_href_redirect( $id )
	{
		$redirect_id = get_term_meta( $id, self::META_KEY[ 'redirect' ], true );

		if ( !empty( $redirect_id ) )
		{
			retun get_page_link( $redirect_id );
		}

		return '';
	}

	public static function get_settings( $terms )
	{
		$term_slug = array_shift( $terms );

		$term = get_term_by( 'slug', $term_slug, self::TAXONOMY[ 'category' ] );

		if ( $term )
		{
			return [
				'id' => $term->term_id,

				'href' => self::get_term_href_redirect( $term->term_id ),

				'title' => $term->name,
			]; 
		}

		return [
			'id' => 0,

			'href' => '',

			'title' => __( WikiMain::TEXT[ 'term-not-found' ], ToolLoco::TEXTDOMAIN ),
		];
	}

	public static function get_items_shortcode( $atts )
	{
		return self::get_items( self::get_posts( $atts ) );
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODE[ 'wiki' ] );
		
		$atts[ 'terms' ] = ToolShortcode::validate_array( $atts[ 'terms' ] );

		$atts[ 'featured' ] = wp_validate_boolean( $atts[ 'featured' ] );

		$args = [
			'items' => self::get_items_shortcode( $atts ),
		];

		if ( $atts[ 'featured' ] )
		{
			return self::render_featured( $args );
		}

		return self::render_main( $args );
	}
	
	const TEMPLATE = [
        'legal-wiki-preview-main' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-preview-main.php',

        'legal-wiki-preview-featured' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-preview-featured.php',
    ];

    public static function render_main( $args )
	{
		return self::render( self::TEMPLATE[ 'legal-wiki-preview-main' ], $args );
	}

    public static function render_featured( $args )
	{
		return self::render( self::TEMPLATE[ 'legal-wiki-preview-featured' ], $args );
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
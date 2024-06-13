<?php

class ToolTaxonomy
{
	public static function register_functions()
    {
        // $handler = new self();

        // add_filter( 'wp_sitemaps_max_urls', [ $handler, 'kama_sitemap_max_urls'], 10, 2 );2 );

		self::handle_incorrect_terms();
    }

	const TAXONOMY = [
		'billet-feature' => 'billet_feature',

		// 'page-type' => 'page_type',
	];

	public static function get_incorrect_terms()
    {
        $args = [
			'taxonomy' => self::TAXONOMY,

			'search' => ',',

			'hide_empty' => false,
		];

		$terms = get_terms( $args );
		
		// $terms = get_terms( 'billet_feature' );

		// LegalDebug::debug( [
		// 	'ToolTaxonomy' => 'get_incorrect_terms',

		// 	'args' => $args,

		// 	'terms' => $terms,
		// ] );

		// self::render_message( [
		// 	'ToolTaxonomy' => 'get_incorrect_terms',

		// 	'args' => $args,

		// 	'terms' => $terms,
		// ] );

		if ( $terms && ! is_wp_error( $terms ) )
		{
			// $parts = self::get_incorrect_parts( $terms );

			// self::repare_incorrect_terms( $terms );

			// LegalDebug::debug( [
			// 	'ToolTaxonomy' => 'get_incorrect_terms',
	
			// 	'count' => count( $terms ),

			// 	'parts' => $parts,
			// ] );

			// self::render_message( [
			// 	'count' => count( $terms ),
			// ] );

			return $terms;
		}

		return [];
    }

	public static function handle_incorrect_terms()
	{
		$terms = self::get_incorrect_terms();

		$parts = self::get_incorrect_parts( $terms );

		$parts_terms = self::get_incorrect_parts_terms( $parts );

		$parts_terms_posts = self::get_incorrect_parts_terms_posts( $parts_terms );

		self::repare_incorrect_terms( $terms );

		LegalDebug::debug( [
			'ToolTaxonomy' => 'get_incorrect_terms',

			'terms-count' => count( $terms ),
			
			// 'terms' => $terms,

			'parts-count' => count( $parts ),

			// 'parts' => $parts,

			'parts_terms-count' => count( $parts_terms ),

			// 'parts_terms' => $parts_terms,

			'parts_terms_posts-count' => count( $parts_terms_posts ),

			// 'parts_terms_posts' => $parts_terms_posts,
		] );
	}

	public static function get_incorrect_parts( $terms )
	{
		$parts = [];

		foreach ( $terms as $term )
		{
			$parts = array_merge( $parts, explode( ', ', $term->name ) );
		}

		return $parts;
	}

	public static function get_incorrect_parts_terms( $parts )
	{
		$args = [
			'taxonomy' => self::TAXONOMY,

			'name' => $parts,

			'hide_empty' => false,

			// 'fields' => 'ids',
			
			'fields' => 'id=>slug',
		];

		$terms = get_terms( $args );

		if ( $terms && ! is_wp_error( $terms ) )
		{
			return $terms;
		}

		return [];
	}

	public static function get_incorrect_parts_terms_posts( $terms = [] )
	{
		// if ( empty( $terms ) )
		// {
		// 	$terms = self::TERM[ 'cross' ];
		// }

		$args = [
			'post_type' => [ 'page', 'legal_billet' ],

			'numberposts' => -1,

			'fields' => 'ids',

			'tax_query' => [
				[
					'taxonomy' => self::TAXONOMY[ 'billet-feature' ],

					'field' => 'slug',

					'terms' => $terms,

					'include_children' => false,
				],
			],
		];

		$posts = get_posts( $args );

		// LegalDebug::debug( [
		// 	'ToolTaxonomy' => 'get_incorrect_parts_terms_posts',

        //     'terms' => $terms,

        //     'args' => $args,

		// 	'posts' => $posts,
		// ] );

		if ( !empty( $posts ) )
		{
			return $posts;
		}

		return [];
	}

	public static function repare_incorrect_terms( $terms )
	{
		// $parts = [];

		foreach ( $terms as $term )
		{
			// $parts = array_merge( $parts, explode( ', ', $term->name ) );

			$args = [
				'name' => str_replace( ', ', '-', $term->name ),
			];

			// LegalDebug::debug( [
			// 	'MultisiteTerms' => 'repare_incorrect_terms',

			// 	'args' => $args,
			// ] );

			// wp_update_term( $term->term_id, $term->taxonomy, $args );
		}

		// return $parts;
	}

	const TEMPLATE = [
        'message' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-admin-message.php',
    ];

	public static function render_message( $args )
    {
		echo LegalComponents::render_main( self::TEMPLATE[ 'message' ], $args );
    }
}

?>
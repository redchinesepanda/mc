<?php

class ToolTaxonomy
{
	public static function register()
    {
        // $handler = new self();

        // add_filter( 'wp_sitemaps_max_urls', [ $handler, 'kama_sitemap_max_urls'], 10, 2 );2 );

		// self::handle_incorrect_terms();
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

	public static function handle_incorrect_terms_posts( $term, $posts )
	{
		foreach ( $posts as $post_id )
		{
			if ( ! has_term( $term->slug, self::TAXONOMY[ 'billet-feature' ], $post_id ) )
			{
				LegalDebug::debug( [
					'ToolTaxonomy' => 'handle_incorrect_terms_posts',

					'post_id' => $post_id,

					'slug' => $term->slug,

					'taxonomy' => self::TAXONOMY[ 'billet-feature' ],
				] );

				wp_set_post_terms( $post_id, $term->slug, self::TAXONOMY[ 'billet-feature' ], true );
			}
		}
	}

	public static function handle_incorrect_terms()
	{
		$terms = self::get_incorrect_terms();

		// LegalDebug::debug( [
		// 	'ToolTaxonomy' => 'get_incorrect_terms',

		// 	'terms-count' => count( $terms ),
			
		// 	// 'terms' => $terms,
		// ] );

		foreach ( $terms as $term )
		{
			$parts = self::get_incorrect_parts( [ $term ] );

			$parts_terms = self::get_incorrect_parts_terms( $parts );

			$parts_terms_posts = self::get_incorrect_parts_terms_posts( $parts_terms );

			LegalDebug::debug( [
				'ToolTaxonomy' => 'get_incorrect_terms',

				'term' => $term,
				
				'parts-count' => count( $parts ),

				// 'parts' => $parts,

				'parts_terms-count' => count( $parts_terms ),

				// 'parts_terms' => $parts_terms,

				'parts_terms_posts-count' => count( $parts_terms_posts ),

				// 'parts_terms_posts' => $parts_terms_posts,
			] );

			self::handle_incorrect_terms_posts( $term, $parts_terms_posts );

			self::delete_incorrect_terms( $parts_terms );
		}

		self::repare_incorrect_terms( $terms );
	}

	public static function delete_incorrect_terms( $terms )
	{
		foreach ( $terms as $term_id => $term_slug )
		{
			LegalDebug::debug( [
				'ToolTaxonomy' => 'delete_incorrect_terms',

				'term_id' => $term_id,

				'taxonomy' => self::TAXONOMY[ 'billet-feature' ],
			] );

			wp_delete_term( $term_id, self::TAXONOMY[ 'billet-feature' ] );
		}
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

		if ( !empty( $posts ) )
		{
			return $posts;
		}

		return [];
	}

	public static function repare_incorrect_terms( $terms )
	{
		foreach ( $terms as $term )
		{
			$args = [
				'name' => str_replace( ', ', '-', $term->name ),
			];

			LegalDebug::debug( [
				'MultisiteTerms' => 'repare_incorrect_terms',

				'term_id' => $term->term_id,

				'taxonomy' => $term->taxonomy,

				'args' => $args,
			] );

			wp_update_term( $term->term_id, $term->taxonomy, $args );
		}
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
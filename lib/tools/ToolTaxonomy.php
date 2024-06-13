<?php

class ToolTaxonomy
{
	public static function register_functions()
    {
        // $handler = new self();

        // add_filter( 'wp_sitemaps_max_urls', [ $handler, 'kama_sitemap_max_urls'], 10, 2 );2 );

		self::get_incorrect_terms();
    }

	const TAXONOMY = [
		'billet-feature' => 'billet_feature',
	];

	public static function get_incorrect_terms()
    {
        $args = [
			'taxonomy' => self::TAXONOMY,

			'search' => ',',
		];

		$terms = get_terms( 'args' );

		if ( $terms && ! is_wp_error( $terms ) )
		{
			LegalDebug::debug( [
				'terms' => $terms,
			] );
		}
    }
}

?>
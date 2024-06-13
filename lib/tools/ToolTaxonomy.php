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

		// LegalDebug::debug( [
		// 	'args' => $args,
		// ] );

		self::render_message( [
			'args' => $args,
		] );

		$terms = get_terms( 'args' );

		if ( $terms && ! is_wp_error( $terms ) )
		{
			// LegalDebug::debug( [
			// 	'terms' => $terms,
			// ] );

			self::render_message( [
				'terms' => $terms,
			] );
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
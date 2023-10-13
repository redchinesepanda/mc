<?php

class ReviewTable
{
	const HANDLE = [
		'table' => 'review-table',
	];

	const CSS = [
        self::HANDLE[ 'table' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-table.css',

            'ver' => '1.1.2',
        ],
    ];

	public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'the_content', [ $handler, 'get_content' ] );
	}

	const CLASSES = [
		'container' => 'legal-rawspan',
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( '//table[contains(@class, \'' . self::CLASSES[ 'container' ] . '\')]' );

		return $nodes;
	}

	public static function get_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $id => $node )
		{
			LegalDebug::debug( [
				'function' => 'ReviewTable::get_content',

				'textContent' => substr( $node->textContent, 0, 30 ),
			] );
		}

		return $dom->saveHTML( $dom );
	}
}

?>
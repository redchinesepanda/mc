<?php

class ReviewStats
{
    const CSS = [
        'review-stats' => LegalMain::LEGAL_URL . '/assets/css/review/review-stats.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'the_content', [ $handler, 'get_content' ] );
    }

	const TEMPLATE = [
		'review-stats' => LegalMain::LEGAL_PATH . '/template-parts/review/review-stats.php',
	];

    public static function render_stats( $node )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'review-stats' ], false, self::get_stats( $node ) );

        $output = ob_get_clean();

        return $output;
    }

	public static function get_content( $content )
	{
		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/table[contains(@class, \'legal-stats\')]' );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $node ) {
			$stats = $dom->createElement( 'div' );

			$stats->setAttribute( 'class', 'legal-stats' );

			ReviewBonus::appendHTML( $stats, self::render_stats( $node ) );

			$node->insertBefore( $stats );
		}

		return $dom->saveHTML();
	}

	public static function get_stats ( $node )
	{
		$args = [];

		$rows = $node->getElementsByTagName( 'tr' );

		foreach ( $rows as $row ) {
			$cells = $row->getElementsByTagName( 'td' );
			
			if ( $cells->length ) {
				$args[] = [
					'title' => $cells[ 0 ]->textContent,

					'width' => ( round( ( float ) $cells[ 1 ]->textContent ) / 10 ) * 100,
				];
			}
		}

		return $args;
	}
}

?>
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

    public static function register_inline_style()
    {
		$name = 'review-inline';

        wp_register_style( $name, false, [], true, true );
		
		wp_add_inline_style( $name, self::inline_style() );
		
		wp_enqueue_style( $name );
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

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

	public static function inline_style() {
		$style = [];

		$table = self::get_table();

		$items = self::get_stats( $node );

		foreach ( $items as $id => $item ) {
			$style[] = '.stats-item-' . $id . ' .item-value { width: ' . $item[ 'value' ] .'%; }';
		}

		return implode( ' ', $style );
	}

	public static function get_dom( $content )
	{
		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		$xpath = new DOMXPath( $dom );

		return $dom;
	}

	public static function get_content( $content )
	{
		$dom = self::get_dom( $content );

		// $dom = new DOMDocument();

		// $dom->loadHTML( $content, LIBXML_NOERROR );

		// $xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/table[contains(@class, \'legal-stats\')]' );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $node ) {
			$stats = $dom->createElement( 'div' );

			$stats->setAttribute( 'class', 'review-stats' );

			ReviewBonus::appendHTML( $stats, self::render_stats( $node ) );

			$node->insertBefore( $stats );
		}

		return $dom->saveHTML();
	}

	public static function get_table()
	{
		$post = get_post();

		$dom = get_dom( $post->post_content );

		$nodes = $xpath->query( './/table[contains(@class, \'legal-stats\')]' );

		if ( $nodes->length == 0 ) {
			return [];
		}

		return $nodes->item( 0 );
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
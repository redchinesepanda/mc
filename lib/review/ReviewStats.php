<?php

class ReviewStats
{
    const CSS = [
        'review-stats' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-stats.css',

			'ver' => '1.0.1',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		ReviewMain::register_inline_style( 'review-stats', self::inline_style() );
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
		if ( !ReviewMain::check() ) {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'review-stats' ], false, self::get_stats( $node ) );

        $output = ob_get_clean();

        return $output;
    }

	public static function inline_style()
	{
		if ( !ReviewMain::check() ) {
            return '';
        }

		$style = [];

		$table = self::get_table();

		if ( $table == null ) {
			return '';
		}

		$items = self::get_stats( $table );

		foreach ( $items as $id => $item ) {
			$style[] = '.stats-item-' . $id . ' .item-value { width: ' . $item[ 'width' ] .'%; }';
		}

		return implode( ' ', $style );
	}

	const CSS_CLASS = [
		'base' => 'legal-stats',
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );
		
		$nodes = $xpath->query( "//table[contains(@class, '" . self::CSS_CLASS[ 'base' ] . "')]" );

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

		foreach ( $nodes as $node )
		{
			$stats = $dom->createElement( 'div' );

			$stats->setAttribute( 'class', 'review-stats' );

			LegalDOM::appendHTML( $stats, self::render_stats( $node ) );

			$node->parentNode->insertBefore( $stats, $node );
		}

		return $dom->saveHTML( $dom );
	}

	public static function get_table()
	{
		$post = get_post();

		if ( empty( $post ) ) {
			return null;
		}

		$dom = LegalDOM::get_dom( $post->post_content );

		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return null;
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
				$value = -1;

				$text = ToolEncode::encode( $cells[ 1 ]->textContent );

				if ( is_numeric( $text ) ) {
					$value = $text;
				}

				if ( strpos( $text, '/' ) ) {
					$part = explode( '/', $text )[ 0 ];

					if ( is_numeric( $part ) ) {
						$value = $part;
					}
				}

				if ( $value != -1 ) {
					$args[] = [
						'title' => ToolEncode::encode( $cells[ 0 ]->textContent ),
	
						'width' => ( round( ( float ) $value ) / 10 ) * 100,
					];
				}
			}
		}

		return $args;
	}
}

?>
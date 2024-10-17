<?php

class ReviewStats
{
    const CSS = [
        'review-stats' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-stats.css',

			'ver' => '1.0.2',
		],
    ];

    const CSS_NEW = [
        'review-stats' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-stats-new.css',

			'ver' => '1.0.1',
		],
    ];

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_style( self::CSS_NEW );
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

    public static function register_inline_style()
    {
		ReviewMain::register_inline_style( 'review-stats', self::inline_style() );
    }

    public static function register()
    {
		if ( self::check_contains_stats() )
		{
			$handler = new self();
	
			add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
	
			add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
	
			add_filter( 'the_content', [ $handler, 'get_content' ] );
		}
    }

	public static function check_contains_stats()
    {
        return LegalComponents::check_contains( self::CSS_CLASS[ 'base' ] );
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

			// $style[] = '.stats-item-' . $id . ' .item-value { background-size: ' . $item[ 'width' ] .'% auto; }';
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

	public static function get_title_rating( $stats_data )
	{
		$amount = count( $stats_data );

		$ratings = array_column( $stats_data, 'rating' );

		$ratings_sum = array_sum( $ratings );

		$rating_average = $ratings_sum / $amount;

		$rating_average_round = self::get_stat_value( $rating_average );

		$ratings_max = array_column( $stats_data, 'rating-max' );

		// $ratings_max_unique = array_unique( $ratings_max );

		$rating_max = array_shift( $ratings_max );

		LegalDebug::debug( [
			'ReviewStats' => 'get_title_rating-1',

			'amount' => $amount,

			'ratings' => $ratings,

			'ratings_sum' => $ratings_sum,

			'rating_average' => $rating_average,

			'rating_average_round' => $rating_average_round,

			'ratings_max' => $ratings_max,

			// 'ratings_max_unique' => $ratings_max_unique,

			'rating_max' => $rating_max,
		] );
	}

	public static function modify_title( $dom, $node_title, $stats_data )
	{
		self::get_title_rating( $stats_data );

		$rating_value = '8.5/10';

		$rating = $dom->createElement( 'span', $rating_value );

		$rating->setAttribute( 'class', 'review-stats-title-rating' );

		$node_title->appendChild( $rating );
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
			$stats_data = self::get_stats( $node );

			// LegalDebug::debug( [
			// 	'ReviewStats' => 'get_content-1',

			// 	'stats_data' => $stats_data,
			// ] );

			$stats = $dom->createElement( 'div' );

			$stats->setAttribute( 'class', 'review-stats' );

			// LegalDOM::appendHTML( $stats, self::render_stats( $node ) );
			
			LegalDOM::appendHTML( $stats, self::render_stats( $stats_data ) );

			$node->parentNode->insertBefore( $stats, $node );

			$node_title = LegalDom::get_previous_element( $dom, $node, 'h2' );

			self::modify_title( $dom, $node_title, $stats_data );

			// LegalDebug::debug( [
			// 	'ReviewStats' => 'get_content-2',

			// 	'node_title' => $node_title,
			// ] );

			$node->parentNode->removeChild( $node );
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

	public static function get_stat_value( $value )
	{
		return round( ( float ) $value );
	}

	public static function get_stat_width( $value )
	{
		return ( round( ( float ) $value ) / 10 ) * 100;
	}

	public static function get_stats ( $node )
	{
		$args = [];

		$rows = $node->getElementsByTagName( 'tr' );

		foreach ( $rows as $row ) {
			$cells = $row->getElementsByTagName( 'td' );
			
			if ( $cells->length ) {
				$value = -1;

				$value_max = -1;

				$text = ToolEncode::encode( $cells[ 1 ]->textContent );

				if ( is_numeric( $text ) ) {
					$value = $text;
				}

				if ( strpos( $text, '/' ) )
				{
					$parts = explode( '/', $text );

					$part = $parts[ 0 ];

					if ( is_numeric( $part ) ) {
						$value = $part;
					}

					$part_max = $parts[ 1 ];

					if ( is_numeric( $part_max ) )
					{
						$value_max = $part_max;
					}
				}

				if ( $value != -1 ) {
					$args[] = [
						'title' => ToolEncode::encode( $cells[ 0 ]->textContent ),

						'description' => ToolEncode::encode( $cells[ 2 ]->textContent ),
	
						// 'width' => ( round( ( float ) $value ) / 10 ) * 100,
						
						'width' => self::get_stat_width( $value ),

						'value' => $text,

						'rating' => $value,

						'rating-max' => $value_max,
					];
				}
			}
		}

		return $args;
	}

	const TEMPLATE = [
		'review-stats' => LegalMain::LEGAL_PATH . '/template-parts/review/review-stats.php',
	];

    // public static function render_stats( $node )
    
	public static function render_stats( $args )
    {
		// if ( !ReviewMain::check() ) {
        //     return '';
        // }

        // ob_start();

        // load_template( self::TEMPLATE[ 'review-stats' ], false, self::get_stats( $node ) );

        // $output = ob_get_clean();

        // return $output;

		// return self::render_main( self::TEMPLATE[ 'review-stats' ], self::get_stats( $node ) );
		
		return self::render_main( self::TEMPLATE[ 'review-stats' ], $args );
    }

    public static function render_main( $tempalte, $args )
    {
		if ( !ReviewMain::check() )
		{
            return '';
        }

        ob_start();

        load_template( $tempalte, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
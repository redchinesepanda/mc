<?php

class ReviewCounter
{
    const CSS = [
        self::CLASSES[ 'base' ] => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-counter.css',

			'ver' => '1.0.4',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		if ( ReviewMain::check() )
        {
            $name = self::CLASSES[ 'base' ];

			wp_register_style( $name, false, [], true, true );
			
			wp_add_inline_style( $name, self::inline_style() );
			
			wp_enqueue_style( $name );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		add_filter( 'the_content', [ $handler, 'get_content' ] );
    }

	const TEMPLATE = [
		self::CLASSES[ 'base' ] => LegalMain::LEGAL_PATH . '/template-parts/review/review-counter.php',
	];

    public static function render_counter( $args )
    {
		if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ self::CLASSES[ 'base' ] ], false, $args );

        $output = ob_get_clean();

        return $output;
    }

	public static function inline_style()
	{
		if ( !ReviewMain::check() )
        {
            return '';
        }

		$style = [];

		$group = get_field( ReviewAbout::FIELD );

		if ( $group )
		{
			$style[] = '.' . self::CLASSES[ 'base' ] . ' { background-color: ' . $group[ ReviewAbout::ABOUT[ 'background' ] ] . '; }';

			$style[] = '.' . self::CLASSES[ 'base' ] . ' .info-logo { background-image: url(\'' . $group[ ReviewAbout::ABOUT[ 'logo' ] ] . '\'); }';
		}

		$tables = self::get_tables();

		if ( !empty( $tables ) && $tables->length != 0 )
		{
			foreach ( $tables as $table_id => $table )
			{
				$items = self::get_counter_items( $table );

				// LegalDebug::debug( [
				// 	'count' => count( $items ),
				// ] );
	
				$amount = count( $items );
	
				if ( $amount == 5 )
				{
					$ovarall = array_shift( $items );
				}
	
				foreach ( $items as $item_id => $item ) {
					$style[] = '.' . self::CLASSES[ 'base' ] . '.counter-item-' . $table_id  . ' .set-item-' . $item_id . ' { --progress: ' . $item[ 'progress' ] .'; }';
				}
			}
		}

		return implode( ' ', $style );
	}

	const CLASSES = [
		'base' => 'legal-review-counter',
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/table[contains(@class, \'' . self::CLASSES[ 'base' ] . '\')]' );

		return $nodes;
	}

	public static function get_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

		$body = $dom->getElementsByTagName( 'body' )->item( 0 );

		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $node_id => $node ) {
			$item = $dom->createElement( 'div' );

			$class[ 'base' ] = self::CLASSES[ 'base' ];

			$class[ 'id' ] = 'counter-item-' . $node_id;

			$class[ 'amount' ] = 'legal-default';

			$args = self::get_counter_data( $node );

			if ( !empty( $args[ 'items_overall' ] ) )
			{
				$class[ 'amount' ] = 'legal-overall';
			}

			$item->setAttribute( 'class', implode( ' ', $class ) );

			LegalDOM::appendHTML( $item, ToolEncode::encode( self::render_counter( $args ) ) );

			// $node->insertBefore( $item );

			try {
				$body->replaceChild( $item, $node );
				
				// $body->insertBefore( $item, $node );
			} catch ( DOMException $e ) {
				LegalDebug::debug( [
					'ReviewCounter::get_content > replaceChild DOMException',
				] );
			}
		}

		return $dom->saveHTML();
	}

	// public static function get_table()
	
	public static function get_tables()
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

		// return $nodes->item( 0 );
		
		return $nodes;
	}

	public static function get_counter_data( $node )
	{
		$ovarall = null;

		$items = self::get_counter_items( $node );

		$amount = count( $items );

		$items_overall = [];

		$title = __( ReviewMain::TEXT[ 'overall-rating' ], ToolLoco::TEXTDOMAIN );

		$rating = 0;

		if ( $amount <= 4 )
		{
			foreach ( $items as $item )
			{
				$rating += $item[ 'value' ];
			}

			$rating = number_format( ( float ) ( $rating / $amount ), 1, '.', '');
		}

		if ( $amount == 5 )
		{
			$ovarall = array_shift( $items );

			$rating = $ovarall[ 'value' ];
		}

		if ( $amount <= 5 )
		{
			$title .= ' ' . $rating;
		}

		if ( $amount > 5 )
		{
			$items_rest = array_slice( $items, 0, -2 );

			$amount = count( $items_rest );

			$items_overall = array_slice( $items, -2 );

			$items = $items_rest;

			$title = ReviewAbout::get_title() . ' - ' . __( ReviewMain::TEXT[ 'rating' ], ToolLoco::TEXTDOMAIN );
		}

		$args = [
			'title' => $title,

			'items' => $items,

			'amount' => $amount,

			'items_overall' => $items_overall,
		];

		return $args;
	}

	public static function get_item( $cells )
	{
		$cell_text = $cells->item( 0 );

		$cell_value = $cells->item( 1 );

		if ( !empty( $cell_text ) && !empty( $cell_value ) )
		{
			$value = -1;

			if ( strpos( $cell_value->textContent, '/' ) )
			{
				$part = explode( '/', $cell_value->textContent )[ 0 ];

				if ( is_numeric( $part ) )
				{
					$value = $part;
				}
			}

			if ( is_numeric( $cell_value->textContent ) ) {
				$value = $cell_value->textContent;
			}

			if ( $value != -1 )
			{
				return [
					'label' => $cell_text->textContent,

					'value' => $value,

					'progress' => ( $value * 10 ) . '%',
				];
			}
		}

		return null;
	}

	public static function get_counter_items( $node )
	{
		$rows = $node->getElementsByTagName( 'tr' );

		if ( $rows->length )
		{
			$rating = 0;
			
			foreach ( $rows as $row ) {
				$cells_th = $row->getElementsByTagName( 'th' );

				$cells_td = $row->getElementsByTagName( 'td' );
				
				if ( $cells_th->length ) {
					$item = self::get_item( $cells_th );

					if ( !empty( $item ) )
					{
						$args[] = $item;
					}
				}

				if ( $cells_td->length ) {
					$item = self::get_item( $cells_td );

					if ( !empty( $item ) )
					{
						$args[] = $item;
					}
				}
			}
		}

		return $args;
	}
}

?>
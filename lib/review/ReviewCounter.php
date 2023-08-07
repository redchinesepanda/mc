<?php

class ReviewCounter
{
    const CSS = [
        self::CLASSES[ 'base' ] => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-counter.css',

			'ver' => '1.0.1',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		$name = self::CLASSES[ 'base' ];

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
		self::CLASSES[ 'base' ] => LegalMain::LEGAL_PATH . '/template-parts/review/review-counter.php',
	];

    public static function render_counter( $node )
    {
        ob_start();

        load_template( self::TEMPLATE[ self::CLASSES[ 'base' ] ], false, self::get_counter_data( $node ) );

        $output = ob_get_clean();

        return $output;
    }

	public static function inline_style() {
		$style = [];

		$table = self::get_table();

		if ( $table == null ) {
			return '';
		}

		$group = get_field( ReviewAbout::FIELD );

		$style[] = '.' . self::CLASSES[ 'base' ] . ' { background-color: ' . $group[ ReviewAbout::ABOUT[ 'background' ] ] . '; }';

		$style[] = '.' . self::CLASSES[ 'base' ] . ' .info-logo { background-image: url(\'' . $group[ ReviewAbout::ABOUT[ 'logo' ] ] . '\'); }';

		$items = self::get_counter_items( $table );

		// LegalDebug::debug( [
		// 	'count' => count( $items ),
		// ] );

		$amount = count( $items );

		if ( $amount > 4 )
		{
			$ovarall = array_shift( $items );
		}

		foreach ( $items as $id => $item ) {
			$style[] = '.' . self::CLASSES[ 'base' ] . ' .set-item-' . $id . ' { --progress: ' . $item[ 'progress' ] .'; }';
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

		$body = $dom->getElementsByTagName( 'body' )->item(0);

		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $node ) {
			$item = $dom->createElement( 'div' );

			$item->setAttribute( 'class', self::CLASSES[ 'base' ] );

			LegalDOM::appendHTML( $item, ToolEncode::encode( self::render_counter( $node ) ) );

			// $node->insertBefore( $item );

			try {
				// $body->replaceChild( $item, $node );
				
				$body->insertBefore( $item, $node );
			} catch ( DOMException $e ) {
				LegalDebug::debug( [
					'ReviewCounter::get_content > replaceChild DOMException',
				] );
			}
		}

		return $dom->saveHTML();
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

	public static function get_counter_data( $node )
	{
		$ovarall = null;

		$items = self::get_counter_items( $node );

		$rating = 0;

		$amount = count( $items );

		LegalDebug::debug( [
			'amount' => $amount,
		] );

		if ( $amount > 4 )
		{
			$ovarall = array_shift( $items );

			$rating = $ovarall[ 'value' ];
		} else
		{
			foreach ( $items as $item )
			{
				$rating += $item[ 'value' ];
			}

			$rating = number_format( ( float ) ( $rating / $amount ), 1, '.', '');
		}

		$args = [
			'title' => __( ReviewMain::TEXT[ 'overall-rating' ], ToolLoco::TEXTDOMAIN ),

			'items' => $items,

			'rating' => $rating,
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

		LegalDebug::debug( [
			'$rows->length' => $rows->length,
		] );

		if ( $rows->length )
		{
			$rating = 0;
			
			foreach ( $rows as $row ) {
				$cells_th = $row->getElementsByTagName( 'th' );

				$cells_td = $row->getElementsByTagName( 'td' );
				
				// LegalDebug::debug( [
				// 	'cells_th->length' => $cells_th->length,

				// 	'cells_td->length' => $cells_td->length,

				// 	'row->textContent' => $row->textContent,
				// ] );
				
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
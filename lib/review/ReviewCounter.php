<?php

class ReviewCounter
{
    const CSS = [
        self::CLASSES[ 'base' ] => LegalMain::LEGAL_URL . '/assets/css/review/review-counter.css',
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		$name = self::CLASSES[ 'base' ] . '-inline';

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

        load_template( self::TEMPLATE[ self::CLASSES[ 'base' ] ], false, self::get_counter( $node ) );

        $output = ob_get_clean();

        return $output;
    }

	public static function inline_style() {
		$style = [];

		$table = self::get_table();

		if ( $table == null ) {
			return '';
		}

		$items = self::get_counter( $table );

		foreach ( $items as $id => $item ) {
			$style[] = '.counter-item-' . $id . ' .item-value { width: ' . $item[ 'width' ] .'%; }';
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

		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $node ) {
			$item = $dom->createElement( 'div' );

			$item->setAttribute( 'class', self::CLASSES[ 'base' ] );

			LegalDOM::appendHTML( $item, self::render_counter( $node ) );

			$node->insertBefore( $item );
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

	public static function get_counter( $node )
	{
		$args = [];

		$rows = $node->getElementsByTagName( 'tr' );

		foreach ( $rows as $row ) {
			$cells = $row->getElementsByTagName( 'td' );
			
			if ( $cells->length ) {
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
						$args[] = [
							'title' => $cell_text->textContent,
		
							'value' => $value,

							'width' => ( $value * 10 ) . '%',
						];
					}

				}
				
				LegalDebug::debug( [
					'args' => $args,
				] );
			}
		}

		return $args;
	}
}

?>
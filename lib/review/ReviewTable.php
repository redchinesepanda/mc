<?php

class ReviewTable
{
	const HANDLE = [
		'table' => 'review-table',
	];

	const CSS = [
        self::HANDLE[ 'table' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-table.css',

            'ver' => '1.1.7',
        ],
    ];

	public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_cell_classes' ] );
	}

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'the_content', [ $handler, 'get_content' ] );
	}

	public static function get_nodes_table( $dom )
	{
		return self::get_nodes(
			$dom,
			
			// '//table[contains(@class, \'' . self::CLASSES[ 'scroll' ] . '\')]'

			'//table[contains(@class, \'' . self::CLASSES[ 'container' ] . '\')] | //table[contains(@class, \'' . self::CLASSES[ 'raw' ] . '\')] | //table[contains(@class, \'' . self::CLASSES[ 'raw-column' ] . '\')] | //table[contains(@class, \'' . self::CLASSES[ 'raw-default' ] . '\')]'
		);
	}

	public static function get_nodes_scroll( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//table[contains(@class, \'' . self::CLASSES[ 'scroll' ] . '\')]'
		);
	}

	public static function get_nodes_tbody( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//table[contains(@class, \'' . self::CLASSES[ 'container' ] . '\')]'
		);
	}

	public static function get_nodes( $dom, $query )
	{
		$xpath = new DOMXPath( $dom );

		// $nodes = $xpath->query( '//table[contains(@class, \'' . self::CLASSES[ 'container' ] . '\')]' );

		$nodes = $xpath->query( $query );

		return $nodes;
	}

	public static function tbody_replace( $dom, $table, $tbodies )
	{
		foreach ( $tbodies as $tbody )
		{
			$tbody_new = $dom->createElement( 'tbody' );

			foreach ( $tbody as $row )
			{
				// LegalDebug::debug( [
				// 	'function' => 'ReviewTable::tbody_replace',

				// 	'row' => substr( $row->textContent, 0, 30 ),
				// ] );

				try
				{
					$tbody_new->appendChild( $row );

					// $row->parentNode->removeChild( $row ); 
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'function' => 'ReviewTable::get_content',

						'row' => substr( $row->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}
			}

			$table->appendChild( $tbody_new );
		}
	}

	public static function replace_td( $dom, $thead )
	{
		$tr = $thead->getElementsByTagName( 'tr' )->item( 0 );

		if ( !empty( $tr ) )
		{
			$tds = $tr->getElementsByTagName( 'td' );

			if ( $tds->length > 0 )
			{
				foreach ( $tds as $td )
				{
					$th = $dom->createElement( 'th', $td->textContent );

					LegalDebug::debug( [
						'function' => 'set_th',
			
						// 'result' => $result,
						
						'td' => substr( $td->textContent, 0, 30 ),

						'th' => substr( $th->textContent, 0, 30 ),
					] );

					try
					{
						// $result = $tr->replaceChild( $th, $td );

						// $result_removeChild = $tr->removeChild( $td );
						
						$tr->appendChild( $th );
					}
					catch ( DOMException $e )
					{
						LegalDebug::debug( [
							'function' => 'set_th',

							'result_removeChild' => $result_removeChild,

							'message' => $e->getMessage(),
						] );
					}
				}
			}

			LegalDebug::debug( [
				'function' => 'set_th',
	
				'tds->length' => $tds->length,
			] );
		}

		return $thead;
	}

	public static function set_th( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $tables = self::get_nodes_table( $dom );

		if ( $tables->length == 0 ) {
			return $content;
		}

		foreach ( $tables as $table )
		{
			// $class_table = $table->getAttribute( 'class' );

			// LegalDebug::debug( [
			// 	'function' => 'set_th',
	
			// 	'class_table' => $class_table,
			// ] );

			$tbody = $table->getElementsByTagName( 'tbody' )->item( 0 );

			if ( !empty( $tbody ) )
			{
				$tr = $table->getElementsByTagName( 'tr' )->item( 0 );

				if ( !empty( $tr ) )
				{
					$thead = $dom->createElement( 'thead' );
					
					$table->insertBefore( $thead, $tr->parentNode );

					$thead->appendChild( $tr );
					
					self::replace_td( $dom, $thead );
				}
			}
		}

		return $dom->saveHTML( $dom );
	}

	public static function set_scroll( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $tables = self::get_nodes_scroll( $dom );

		if ( $tables->length == 0 ) {
			return $content;
		}

		foreach ( $tables as $table )
		{
			$class_table = $table->getAttribute( 'class' );

			$class_table = str_replace( ' ' . self::CLASSES[ 'scroll' ], '', $class_table );

			$class_scroll = self::CLASSES[ 'scroll' ];

			if ( str_contains( $class_table, self::CLASSES[ 'full-width' ] ) )
			{
				$class_table = str_replace( ' ' . self::CLASSES[ 'full-width' ], '', $class_table );

				$class_scroll .= ' ' . self::CLASSES[ 'full-width' ] ;
			}

			$table->setAttribute( 'class', $class_table );

			$scroll = $dom->createElement( 'div' );

			$scroll->setAttribute( 'class', $class_scroll );

			$table->parentNode->insertBefore( $scroll, $table );

			$scroll->appendChild( $table );
		}

		return $dom->saveHTML( $dom );
	}

	public static function get_content( $content )
	{
		$content = self::set_tbody( $content );

		$content = self::set_scroll( $content );

		$content = self::set_th( $content );

		return $content;
	}

	public static function set_tbody( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $tables = self::get_nodes_tbody( $dom );

		if ( $tables->length == 0 ) {
			return $content;
		}

		$tbodies = [];

		$tbody_id = 0;

		foreach ( $tables as $table )
		{
			$rows = $table->getElementsByTagName( 'tr' );

			if ( $rows->length )
			{
				$row_first = $rows->item( 0 );

				$row_first_cells = $row_first->getElementsByTagName( 'td' );

				$amount = $row_first_cells->length;
	
				foreach ( $rows as $row_id => $row )
				{
					$cells = $row->getElementsByTagName( 'td' );
	
					if ( $cells->length == $amount )
					{
						$tbody_id = $row_id;
					}

					if ( $tbody_id > 0 )
					{
						$tbodies[ $tbody_id ][] = $row;
					}
				}
			}

			self::tbody_replace( $dom, $table, $tbodies );
		}

		return $dom->saveHTML( $dom );
	}

	const CLASSES = [
		'container' => 'legal-raw-rawspan',

		'raw' => 'legal-raw',
		
		'column-3' => 'legal-column-3',

		'scroll' => 'legal-scroll',

		'full-width' => 'legal-full-width',

		'raw-column' => 'legal-raw-column',

		'raw-default' => 'legal-raw-default',
	];

	public static function table_classes( $settings )
	{
		$styles = [
			[
				'title' => 'По умолчанию',

				'value' => '',
			],

			[
				'title' => 'По умолчанию 50%',

				'value' => 'legal-column',
			],

			[
				'title' => 'По умолчанию 33.333%',

				'value' => self::CLASSES[ 'column-3' ],
			],

			[
				'title' => 'Ряд и Столбец',

				'value' => 'legal-raw-column',
			],

			[
				'title' => 'Ряд',

				'value' => self::CLASSES[ 'raw' ],
			],

			[
				'title' => 'Ряд 33.333%',

				'value' => self::CLASSES[ 'raw' ] . ' ' . self::CLASSES[ 'column-3' ],
			],

			[
				'title' => 'Ряд Прокрутка',

				'value' => self::CLASSES[ 'raw' ] . ' ' . self::CLASSES[ 'scroll' ],
			],

			[
				'title' => 'Ряд Прокрутка По Ширине',

				'value' => self::CLASSES[ 'raw' ] . ' ' . self::CLASSES[ 'scroll' ] . ' ' . self::CLASSES[ 'full-width' ],
			],

			[
				'title' => 'Ряд Rowspan',

				'value' => self::CLASSES[ 'container' ],
			],

			[
				'title' => 'Ряд Rowspan Прокрутка',

				'value' => self::CLASSES[ 'container' ] . ' ' . self::CLASSES[ 'scroll' ],
			],

			[
				'title' => 'Галка',

				'value' => 'legal-check',
			],

			[
				'title' => 'Статистика',

				'value' => 'legal-stats',
			],

			[
				'title' => 'Счетчик',

				'value' => ReviewCounter::CLASSES[ 'base' ],
			],
		];

		$settings[ 'table_class_list' ] = json_encode( $styles );

		return $settings;
	}

	public static function table_cell_classes( $settings )
	{
		$settings[ 'table_cell_class_list' ] = json_encode( [
			[
				'title' => 'По умолчанию',
				'value' => '',
			],

			[
				'title' => 'Крест',
				'value' => 'legal-cross',
			],
		] );

		return $settings;
	}
}

?>
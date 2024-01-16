<?php

class ReviewTable
{
	const HANDLE = [
		'table' => 'review-table',
	];

	const CSS = [
        self::HANDLE[ 'table' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-table.css',

            'ver' => '1.2.3',
        ],
    ];

	const CSS_NEW = [
        self::HANDLE[ 'table' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-table-new.css',

            'ver' => '1.0.0',
        ],

        'review-table-selectors' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-table-selectors.css',

            'ver' => '1.0.0',
        ],
    ];

	public static function register_style()
    {
		if ( TemplateMain::check_code() )
		{
			ReviewMain::register_style( self::CSS_NEW );
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

	const JS_NEW = [
        self::HANDLE[ 'table' ] => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-table.js',

			'ver' => '1.0.0',
		],
    ];

	public static function register_script()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_script( self::JS_NEW );
		}
    }

	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_table' ] );

		// add_filter( 'tiny_mce_before_init', [ $handler, 'table_classes' ] );

		// add_filter( 'tiny_mce_before_init', [ $handler, 'table_cell_classes' ] );
	}

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

		add_filter( 'the_content', [ $handler, 'get_content' ], 9 );
	}

	// public static function get_nodes_tbody_all( $dom )
	// {
	// 	return self::get_nodes(
	// 		$dom,
			
	// 		'//table/tr'
	// 	);
	// }

	public static function get_nodes_table( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//table[contains(@class, \'' . self::CLASSES[ 'raw-rawspan' ] . '\')] | //table[contains(@class, \'' . self::CLASSES[ 'raw' ] . '\')] | //table[contains(@class, \'' . self::CLASSES[ 'raw-column' ] . '\')] | //table[contains(@class, \'' . self::CLASSES[ 'raw-default' ] . '\')] | //table[contains(@class, \'' . self::CLASSES[ 'stats' ] . '\')]'
		);
	}

	public static function get_nodes_scroll( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//table[contains(@class, \'' . self::CLASSES[ 'scroll' ] . '\')]'
		);
	}

	public static function get_nodes_table_not_scroll( $dom )
	{
		return self::get_nodes(
			$dom,

			// '//table[not([contains(@class, \'' . self::CLASSES[ 'scroll' ] . '\')])]'

			'//table[not(self::node()[contains(concat(" ",normalize-space(@class)," ")," legal-scroll ")])]'
		);
	}

	public static function get_nodes_tbody( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//table[contains(@class, \'' . self::CLASSES[ 'raw-rawspan' ] . '\')]'
		);
	}

	public static function get_nodes_th_td( $dom, $node )
	{
		return self::get_nodes(
			$dom,
			
			'td|th',

			$node
		);
	}

	public static function get_nodes( $dom, $query, $node = null )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( $query, $node );

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
						'function' => 'ReviewTable::tbody_replace',

						'row' => substr( $row->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}
			}

			$table->appendChild( $tbody_new );
		}
	}

	public static function set_th_column( $dom, $table )
	{
		$class_table = $table->getAttribute( 'class' );

		if ( str_contains( $class_table, self::CLASSES[ 'raw-column' ] ) )
		{
			$trs = $table->getElementsByTagName( 'tr' );
			
			if ( $trs->length != 0 )
			{
				foreach ( $trs as $tr )
				{
					$td = $tr->getElementsByTagName( 'td' )->item( 0 );

					if ( !empty( $td ) )
					{
						$th = $dom->createElement( 'th', $td->textContent );

						$td->parentNode->replaceChild( $th, $td );
					}
				}
			}
		}
	}

	// public static function create_thead( $dom, $table )
	
	public static function create_thead( $dom, $tr )
	{
		$thead = $dom->createElement( 'thead' );

		// $tr = $table->getElementsByTagName( 'tr' )->item( 0 );

		if ( !empty( $tr ) )
		{
			$items = $tr->getElementsByTagName( 'td' );

			$ths = [];

			if ( $items->length > 0 )
			{
				foreach ( $items as $td )
				{
					$ths[] = $dom->createElement( 'th', $td->textContent );
				}
			}
			else
			{
				$items = $tr->getElementsByTagName( 'th' );

				foreach ( $items as $th )
				{
					$ths[] = $th;
				}
			}

			if ( !empty( $ths ) )
			{
				$tr = $dom->createElement( 'tr' );

				foreach ( $ths as $th )
				{
					try
					{
						$tr->appendChild( $th );
					}
					catch ( DOMException $e )
					{
						LegalDebug::debug( [
							'function' => 'set_th',

							'message' => $e->getMessage(),
						] );
					}
				}

				$thead->appendChild( $tr );
			}
		}

		return $thead;
	}

	public static function set_thead( $dom, $table )
	{
		// $tbodies = $table->getElementsByTagName( 'tbody' );
		
		// $tbodies = self::get_nodes_tbody_all( $dom );

		// foreach( $table->childNodes as $child )
		// {
		// 	LegalDebug::debug( [
		// 		'function' => 'ReviewTable::set_thead',
	
		// 		// '$child' => $dom->saveHTML( $child ),
				
		// 		'$child' => $child,
		// 	] );
		// }

		$tbody = $table->getElementsByTagName( 'tbody' )->item( 0 );

		// LegalDebug::debug( [
		// 	'function' => 'ReviewTable::set_thead',

		// 	'$table' => $dom->saveHTML( $table ),

		// 	'$tbodies' => $tbodies,

		// 	'$tbody' => $tbody,
		// ] );

		if ( !empty( $tbody ) )
		{
			$tr = $table->getElementsByTagName( 'tr' )->item( 0 );
			
			$thead = self::create_thead( $dom, $tr );

			$table->insertBefore( $thead, $tr->parentNode );

			$tr->parentNode->removeChild( $tr );
		}
	}

	public static function set_th( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $tables = self::get_nodes_table( $dom );
		
		// LegalDebug::debug( [
		// 	'function' => 'ReviewTable::set_th',

		// 	'$tables->length' => $tables->length,
		// ] );

		if ( $tables->length == 0 ) {
			return $content;
		}

		foreach ( $tables as $table )
		{
			self::set_thead( $dom, $table );

			self::set_th_column( $dom, $table );
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

	public static function set_scroll_x_wrapper( $dom, $table )
	{
		$scroll = $dom->createElement( 'div' );

		$scroll->setAttribute( 'class', self::CLASSES[ 'scroll-x' ] );

		$table->parentNode->insertBefore( $scroll, $table );

		$scroll->appendChild( $table );
	}

	public static function set_scroll_x( $content )
	{
		if ( !ReviewMain::check() )
		{
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $tables = self::get_nodes_table_not_scroll( $dom );

		if ( $tables->length == 0 )
		{
			return $content;
		}

		foreach ( $tables as $table )
		{
			$tr_all = $table->getElementsByTagName( 'tr' );

			if ( $tr_all->length > 0 )
			{
				if ( self::get_nodes_th_td( $dom, $tr_all->item( 0 ) )->length > 3 )
				{
					self::set_scroll_x_wrapper( $dom, $table );
				}
			}
		}

		return $dom->saveHTML( $dom );
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

		$tbody_id = 0;

		foreach ( $tables as $table )
		{
			$tbodies = [];

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

	public static function get_content( $content )
	{
		$content = self::set_tbody( $content );

		$content = self::set_scroll( $content );

		$content = self::set_scroll_x( $content );

		$content = self::set_th( $content );

		// LegalDebug::debug( [
		// 	'function' => 'ReviewTable::get_content',

		// 	// 'content' => $content,
		// ] );

		return $content;
	}

	const CLASSES = [
		'raw-rawspan' => 'legal-raw-rawspan',

		'default' => 'legal-default',

		'raw' => 'legal-raw',
		
		'column-3' => 'legal-column-3',

		'scroll' => 'legal-scroll',

		'full-width' => 'legal-full-width',

		'raw-column' => 'legal-raw-column',

		'raw-default' => 'legal-raw-default',

		'stats' => 'legal-stats',

		'column' => 'legal-column',

		'raw-column' => 'legal-raw-column',

		'check' => 'legal-check',

		'stats' => 'legal-stats',

		'cross' => 'legal-cross',

		'scroll-x' => 'legal-scroll-x',
	];

	public static function style_formats_table( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Таблица',

				'items' => [
					[
						'title' => 'По умолчанию',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'default' ],
					],
					
					[
						'title' => 'Колонка 50%',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'column' ],
					],

					[
						'title' => 'Колонка 33.333%',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'column-3' ],
					],

					[
						'title' => 'По умолчанию Ряд',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'raw-default' ],
					],

					[
						'title' => 'Ряд',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'raw' ],
					],
					
					[
						'title' => 'Ряд + Столбец',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'raw-column' ],
					],

					[
						'title' => 'Ряд Rowspan',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'raw-rawspan' ],
					],

					[
						'title' => 'Галка',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'check' ],
					],

					[
						'title' => 'Статистика',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'stats' ],
					],

					[
						'title' => 'Счетчик',
						
						'selector' => 'table',

						'classes' => ReviewCounter::CLASSES[ 'base' ],
					],
					
					[
						'title' => 'Прокрутка По Высоте',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'scroll' ],
					],

					[
						'title' => 'Прокрутка По Ширине',
						
						'selector' => 'table',

						'classes' => self::CLASSES[ 'full-width' ],
					],

					[
						'title' => 'Ячейка Крест',
						
						'selector' => 'td',

						'classes' => self::CLASSES[ 'cross' ],
					],
				],
			],
		] );
	}

	// public static function table_classes( $settings )
	// {
	// 	$styles = [
	// 		// [
	// 		// 	'title' => 'По умолчанию',

	// 		// 	'value' => '',
	// 		// ],

	// 		// [
	// 		// 	'title' => 'По умолчанию Ряд',

	// 		// 	'value' => self::CLASSES[ 'raw-default' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'По умолчанию 50%',

	// 		// 	'value' => 'legal-column',
	// 		// ],

	// 		// [
	// 		// 	'title' => 'По умолчанию 33.333%',

	// 		// 	'value' => self::CLASSES[ 'column-3' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Ряд и Столбец',

	// 		// 	'value' => 'legal-raw-column',
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Ряд',

	// 		// 	'value' => self::CLASSES[ 'raw' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Ряд 33.333%',

	// 		// 	'value' => self::CLASSES[ 'raw' ] . ' ' . self::CLASSES[ 'column-3' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Ряд Прокрутка',

	// 		// 	'value' => self::CLASSES[ 'raw' ] . ' ' . self::CLASSES[ 'scroll' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Ряд Прокрутка По Ширине',

	// 		// 	'value' => self::CLASSES[ 'raw' ] . ' ' . self::CLASSES[ 'scroll' ] . ' ' . self::CLASSES[ 'full-width' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Ряд Rowspan',

	// 		// 	'value' => self::CLASSES[ 'raw-rawspan' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Ряд Rowspan Прокрутка',

	// 		// 	'value' => self::CLASSES[ 'raw-rawspan' ] . ' ' . self::CLASSES[ 'scroll' ],
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Галка',

	// 		// 	'value' => 'legal-check',
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Статистика',

	// 		// 	'value' => 'legal-stats',
	// 		// ],

	// 		// [
	// 		// 	'title' => 'Счетчик',

	// 		// 	'value' => ReviewCounter::CLASSES[ 'base' ],
	// 		// ],
	// 	];

	// 	$settings[ 'table_class_list' ] = json_encode( $styles );

	// 	return $settings;
	// }

	// public static function table_cell_classes( $settings )
	// {
	// 	$settings[ 'table_cell_class_list' ] = json_encode( [
	// 		[
	// 			'title' => 'По умолчанию',
	// 			'value' => '',
	// 		],

	// 		[
	// 			'title' => 'Крест',
	// 			'value' => 'legal-cross',
	// 		],
	// 	] );

	// 	return $settings;
	// }
}

?>
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

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_cell_classes' ] );
	}

	const CLASSES = [
		'container' => 'legal-raw-rawspan',
	];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( '//table[contains(@class, \'' . self::CLASSES[ 'container' ] . '\')]' );

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

	public static function get_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $tables = self::get_nodes( $dom );

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
				'value' => 'legal-column-3',
			],

			[
				'title' => 'Ряд и Столбец',
				'value' => 'legal-raw-column',
			],

			[
				'title' => 'Ряд',
				'value' => 'legal-raw',
			],

			[
				'title' => 'Ряд 33.333%',
				'value' => 'legal-raw legal-column-3',
			],

			[
				'title' => 'Ряд Rowspan',
				'value' => self::CLASSES[ 'container' ],
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
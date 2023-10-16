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
	}

	const CLASSES = [
		'container' => 'legal-rawspan',
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
				LegalDebug::debug( [
					'function' => 'ReviewTable::tbody_replace',

					'row' => substr( $row->textContent, 0, 30 ),
				] );

				$tbody_new->appendChild( $row );

				// try
				// {
				// 	$table->removeChild( $row );
				// }
				// catch ( DOMException $e )
				// {
				// 	LegalDebug::debug( [
				// 		'function' => 'ReviewTable::tbody_replace',

				// 		'row' => substr( $row->textContent, 0, 30 ),

				// 		'message' => $e->getMessage(),
				// 	] );
				// }
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

					$tbodies[ $tbody_id ][] = $row;

					try
					{
						$table->removeChild( $row );
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
			}

			self::tbody_replace( $dom, $table, $tbodies );
		}

		return $dom->saveHTML( $dom );
	}
}

?>
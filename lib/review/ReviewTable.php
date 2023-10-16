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

		// $tbody_amount = 1;

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

					// LegalDebug::debug( [
					// 	'function' => 'ReviewTable::get_content',

					// 	'cells->length' => $cells->length,

					// 	'amount' => $amount,
					// ] );
	
					if ( $cells->length == $amount )
					{
						$tbody_id = $row_id;

						// $tbody_amount = 1;

						// LegalDebug::debug( [
						// 	'function' => 'ReviewTable::get_content',

						// 	'textContent' => substr( $row->textContent, 0, 30 ),

						// 	'tbody_id' => $tbody_id,
						// ] );

						$cell_first = $cells->item( 0 );
	
						if ( $cell_first->hasAttribute( 'rowspan' ) )
						{
							// LegalDebug::debug( [
							// 	'function' => 'ReviewTable::get_content',
				
							// 	'rowspan' => $call->getAttribute( 'rowspan' ),
							// ] );

							// $tbody_amount = $call->getAttribute( 'rowspan' );
						}
					}

					$tbodies[ $tbody_id ][] = $row;
				}
			}

			foreach ( $tbodies as $id => $tbody )
			{
				LegalDebug::debug( [
					'function' => 'ReviewTable::get_content',
	
					'id' => $id,
				] );

				foreach ( $tbody as $row )
				{
					LegalDebug::debug( [
						'function' => 'ReviewTable::get_content',

						'count' => $row->childNodes->count,
		
						// 'textContent' => substr( $row->textContent, 0, 30 ),
					] );
				}
			}
		}

		return $dom->saveHTML( $dom );
	}
}

?>
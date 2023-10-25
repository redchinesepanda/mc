<?php

class NotionMain
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'updated_post_meta', [ $handler, 'billet_list' ], 10, 4 );
	}

	const ACF_FIELD = [
		'parts' => 'billet-list-parts',
	];

	const BILLET_LIST_PARTS = [
		'icon' => 'billet-list-part-icon',

		'direction' => 'billet-list-part-direction',

		'feature' => 'billet-list-part-feature',

		'items' => 'billet-list-part-items',
	];

	const BILLET_LIST_PART_ITEMS = [
		'title' => 'billet-list-part-item-title',
	];

	const META_FIELD = [
		'list' => 'notion_billet_list',
	];

	public static function billet_list( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( self::META_FIELD[ 'list' ] == $meta_key )
		{
			$notion_lists = (array) json_decode( $meta_value, true );

			LegalDebug::die( [
				'function' => 'NotionMain::billet_list',

				// 'meta_id' => $meta_id,

				// 'post_id' => $post_id,

				// 'meta_key' => $meta_key,

				'notion_lists' => $notion_lists,
			] );

			foreach ( $notion_lists as $notion_list )
			{
				$row = [
					const::BILLET_LIST_PARTS[ 'icon' ] => $notion_list[ const::BILLET_LIST_PARTS[ 'icon' ] ],
	
					const::BILLET_LIST_PARTS[ 'direction' ]   => $notion_list[ const::BILLET_LIST_PARTS[ 'direction' ] ],
	
					const::BILLET_LIST_PARTS[ 'feature' ]  => $notion_list[ const::BILLET_LIST_PARTS[ 'feature' ] ],
					
					const::BILLET_LIST_PARTS[ 'items' ]  => [],
				];
				
				add_row( self::ACF_FIELD[ 'parts' ], $row );
			}
		}
	}
}

?>
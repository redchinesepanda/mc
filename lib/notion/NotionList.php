<?php

class NotionList
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_list' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_list' ], 11, 4 );
	}

	const BILLET_LIST_PARTS_KEY = [
		'icon' => 'field_6412f81a9499e',

		'direction' => 'field_6412f8a49499f',

		'feature' => 'field_6492f753cfa1c',

		'items' => 'field_6412f9254d88b',
	];

	const BILLET_LIST_PARTS = [
		'icon' => 'billet-list-part-icon',

		'direction' => 'billet-list-part-direction',

		'feature' => 'billet-list-part-feature',

		'items' => 'billet-list-part-items',
	];

	const BILLET_LIST_PART_ITEMS_KEY = [
		'title' => 'field_6412f96d4d88c',
	];

	const BILLET_LIST_PART_ITEMS = [
		'title' => 'billet-list-part-item-title',
	];

	public static function get_lists( $item )
	{
		if ( is_array( $item ) )
		{
			if ( NotionMain::array_is_list( $item ) )
			{
				return $item;
			}

			return [ $item ];
		}

		return [];
	}

	public static function get_row_items( $list )
	{
		$row_items = [];

		if ( !empty( $list[ self::BILLET_LIST_PARTS[ 'items' ] ] ) )
		{
			foreach (  $list[ self::BILLET_LIST_PARTS[ 'items' ] ] as $item )
			{
				$row_items[] = [
					self::BILLET_LIST_PART_ITEMS_KEY[ 'title' ] => $item[ self::BILLET_LIST_PART_ITEMS[ 'title' ] ],
				];
			}
		}

		return $row_items;
	}

	const TAXONOMY = [
		'billet_feature',
	];

	public static function get_feature( $features )
	{
		return get_terms( [
			'taxonomy' => self::TAXONOMY,

			'slug' => $features,

			'fields' => 'ids',
		] );
	}

	public static function get_row( $list )
	{
		return [
			self::BILLET_LIST_PARTS_KEY[ 'icon' ] => $list[ self::BILLET_LIST_PARTS[ 'icon' ] ],

			self::BILLET_LIST_PARTS_KEY[ 'direction' ] => $list[ self::BILLET_LIST_PARTS[ 'direction' ] ],

			self::BILLET_LIST_PARTS_KEY[ 'feature' ] => self::get_feature( $list[ self::BILLET_LIST_PARTS[ 'feature' ] ] ),
			
			self::BILLET_LIST_PARTS_KEY[ 'items' ]  => self::get_row_items( $list ),
		];
	}

	public static function billet_list( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'list' ] == $meta_key )
		{
			$rows = [];
			
			$notion_lists = json_decode( $meta_value, true );
			
			$lists = self::get_lists( $notion_lists );

			if ( !empty( $lists ) )
			{
	
				foreach ( $lists as $list )
				{
					$rows[] = self::get_row( $list );
				}
	
				update_field( NotionMain::ACF_KEY[ 'parts' ], $rows, $post_id );
			}

			LegalDebug::die( [
				'function' => 'NotionList::billet_list',

				'meta_value' => $meta_value,

				'notion_lists' => $notion_lists,

				'lists' => $lists,

				'rows' => $rows,
			] );
		}
	}
}

?>
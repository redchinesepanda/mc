<?php

class NotionMain
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_list' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_list' ], 11, 4 );

		// add_action( 'edit_form_after_title', [ $handler, 'billet_list_show' ], 10, 4 );

		// add_filter('acf/update_value/key=' . self::ACF_KEY[ 'parts' ], 'update_value_parts', 10, 4);
	}

	const ACF_KEY = [
		'parts' => 'field_6412f442f2c53',
	];

	const ACF_FIELD = [
		'parts' => 'billet-list-parts',
	];

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

	const META_FIELD = [
		'list' => 'notion_billet_list',

		'list-debug' => 'notion_billet_list_debug',
	];

	public static function array_is_list( array $arr )
	{
		if ( $arr === [] )
		{
			return true;
		}

		return array_keys( $arr ) === range( 0, count( $arr ) - 1 );
	}

	public static function get_lists( $item )
	{
		if ( self::array_is_list( $item ) )
		{
			return $item;
		}

		return [ $item ];
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

	public static function get_row( $list )
	{
		return [
			self::BILLET_LIST_PARTS_KEY[ 'icon' ] => $list[ self::BILLET_LIST_PARTS[ 'icon' ] ],

			self::BILLET_LIST_PARTS_KEY[ 'direction' ] => $list[ self::BILLET_LIST_PARTS[ 'direction' ] ],

			self::BILLET_LIST_PARTS_KEY[ 'feature' ] => $list[ self::BILLET_LIST_PARTS[ 'feature' ] ],
			
			self::BILLET_LIST_PARTS_KEY[ 'items' ]  => self::get_row_items( $list ),

			// self::BILLET_LIST_PARTS_KEY[ 'items' ]  => [],
		];
	}

	public static function update_value_parts( $value, $post_id, $field, $original )
	{
		// LegalDebug::die( [
		// 	'function' => 'NotionMain::update_value_parts',

		// 	'value' => $value,

		// 	'post_id' => $post_id,

		// 	'field' => $field,

		// 	'original' => $original,
		// ] );

		return $value;
	}

	public static function billet_list( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( self::META_FIELD[ 'list' ] == $meta_key )
		{
			$result = [];
			
			$notion_lists = json_decode( $meta_value, true );

			$lists = self::get_lists( $notion_lists );

			$rows = [];

			foreach ( $lists as $list )
			{
				$rows[] = self::get_row( $list );

				// $result[] = add_row( self::ACF_KEY[ 'parts' ], $row, $post_id );
			}

			// if ( !empty( $rows ) )
			// {
			// 	$result[] = update_field( self::ACF_KEY[ 'parts' ], $rows, $post_id );
			// }

			update_field( self::ACF_KEY[ 'parts' ], $rows, $post_id );

			// $field = get_field( self::ACF_KEY[ 'parts' ], $post_id );
			
			// LegalDebug::die( [
			// 	'function' => 'NotionMain::billet_list',

			// 	'meta_id' => $meta_id,

			// 	'post_id' => $post_id,

			// 	'meta_key' => $meta_key,

			// 	'lists' => $lists,

			// 	'rows' => $rows,

			// 	'field' => $field,

			// 	'result' => $result,
			// ] );
		}
	}

	public static function billet_list_show( $post )
	{
		$field = get_field( self::ACF_KEY[ 'parts' ], $post->ID );
			
		LegalDebug::debug( [
			'function' => 'NotionMain::billet_list_show',

			'field' => $field,
		] );
	}
}

?>
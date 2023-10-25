<?php

class NotionMain
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'updated_post_meta', [ $handler, 'billet_list' ], 10, 4 );
	}

	const ACF_KEY = [
		'parts' => 'field_6412f442f2c53',
	];

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

	public static function get_lists( $item )
	{
		if ( self::array_is_list( $item ) )
		{
			return $item;
		}

		return [ $item ];
	}

	public static function billet_list( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( self::META_FIELD[ 'list' ] == $meta_key )
		{
			$notion_lists = json_decode( $meta_value, true );

			$lists = self::get_lists( $notion_lists );

			$result = [];

			foreach ( $lists as $list )
			{
				// $row = [
				// 	self::BILLET_LIST_PARTS[ 'icon' ] => $list[ self::BILLET_LIST_PARTS[ 'icon' ] ],
	
				// 	self::BILLET_LIST_PARTS[ 'direction' ]   => $list[ self::BILLET_LIST_PARTS[ 'direction' ] ],
	
				// 	self::BILLET_LIST_PARTS[ 'feature' ]  => $list[ self::BILLET_LIST_PARTS[ 'feature' ] ],
					
				// 	self::BILLET_LIST_PARTS[ 'items' ]  => [],
				// ];
				
				// $result[] = add_row( self::ACF_FIELD[ 'parts' ], $row, $post_id );
				
				$result[] = add_row( self::ACF_KEY[ 'parts' ], $list, $post_id );
			}

			$field = get_field( self::ACF_FIELD[ 'parts' ], $post_id );
			
			LegalDebug::die( [
				'function' => 'NotionMain::billet_list',

				// 'meta_id' => $meta_id,

				// 'post_id' => $post_id,

				// 'meta_key' => $meta_key,

				'lists' => $lists,

				'field' => $field,

				'result' => $result,
			] );
		}
	}

	public static function array_is_list( array $arr )
	{
		if ( $arr === [] )
		{
			return true;
		}

		return array_keys( $arr ) === range( 0, count( $arr ) - 1 );
	}
}

?>
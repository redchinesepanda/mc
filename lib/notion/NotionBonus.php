<?php

class NotionBonus
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_bonus' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_bonus' ], 11, 4 );
	}

	const BILLET_FETURE_BONUS_KEY = [
		'feture-id' => 'field_651ab5083b28e',

		'bonus-id' => 'field_651ab5303b28f',

		'bonus-title' => 'field_651ab5ab3b290',

		'bonus-description' => 'field_651ab5c43b291',
	];

	const BILLET_FETURE_BONUS = [
		'feture-id' => 'billet-feture-id',

		'bonus-id' => 'billet-bonus-id',

		'bonus-title' => 'billet-bonus-title',

		'bonus-description' => 'billet-bonus-description',
	];

	public static function get_bonus( $url )
	{
		$id = url_to_postid( $url );

		if ( !empty( $id ) )
		{
			return $id;
		}

		return '';
	}

	public static function get_row( $item )
	{
		return [
			self::BILLET_FETURE_BONUS_KEY[ 'feture-id' ] => NotionList::get_feature( $item[ self::BILLET_FETURE_BONUS[ 'feture-id' ] ] ),

			self::BILLET_FETURE_BONUS_KEY[ 'bonus-id' ] => self::get_bonus( $item[ self::BILLET_FETURE_BONUS[ 'bonus-id' ] ] ),

			self::BILLET_FETURE_BONUS_KEY[ 'bonus-title' ] => $item[ self::BILLET_FETURE_BONUS[ 'bonus-title' ] ],

			self::BILLET_FETURE_BONUS_KEY[ 'bonus-description' ] => $item[ self::BILLET_FETURE_BONUS[ 'bonus-description' ] ],
		];
	}

	public static function billet_bonus( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'bonus' ] == $meta_key )
		{
			$rows = [];
			
			$notion_bonuses = json_decode( $meta_value, true );
			
			$bonuses = NotionList::get_lists( $notion_bonuses );

			if ( !empty( $bonuses ) )
			{
	
				foreach ( $bonuses as $bonus )
				{
					$rows[] = self::get_row( $bonus );
				}
	
				update_field( NotionMain::ACF_KEY[ 'bonus' ], $rows, $post_id );
			}

			LegalDebug::die( [
				'function' => 'NotionList::billet_bonus',

				'meta_value' => $meta_value,

				'notion_bonuses' => $notion_bonuses,

				'bonuses' => $bonuses,

				'rows' => $rows,
			] );
		}
	}
}

?>
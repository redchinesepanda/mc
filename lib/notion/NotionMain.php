<?php

class NotionMain
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'updated_post_meta', [ $handler, 'billet_list' ], 10, 4 );
	}

	const META_FIELD = [
		'list' => 'notion_billet_list',
	];

	public static function billet_list( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( self::META_FIELD[ 'list' ] == $meta_key )
		{
			LegalDebug::die( [
				'function' => 'NotionMain::billet_list',

				// 'meta_id' => $meta_id,

				// 'post_id' => $post_id,

				// 'meta_key' => $meta_key,

				'meta_value_json_decode' => json_decode( $meta_value, true ),
			] );
		}
	}
}

?>
<?php

class NotionImage
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_logo' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_logo' ], 11, 4 );
	}

	public static function billet_logo( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'about-logo' ] == $meta_key )
		{
			update_field( NotionMain::ACF_KEY[ 'about-logo' ], $meta_value, $post_id );
		}
	}
}

?>
<?php

class NotionContent
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'review_content' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'review_content' ], 11, 4 );
	}

	function remove_comments( $content )
	{
		return preg_replace( '/<!--(.*)-->/Uis', '', $content );
	}

	public static function remove_tags( $content )
	{
		return strip_tags( $content, BonusContent::ALLOWED );
	}

	public static function remove_attr( $content )
	{
		return preg_replace(
			"/<([a-z][a-z0-9]*)[^>]*?(\/?)>/si",
			
			'<$1$2>',
			
			$content
		);
	}

	public static function review_content( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'content' ] == $meta_key )
		{
			$post = get_post( $post_id );

			if ( !empty( $post ) )
			{
				// if ( empty( $post->post_content ) )
				// {
					$meta_value = remove_comments( $meta_value );

					$meta_value = remove_tags( $meta_value );

					$meta_value = remove_attr( $meta_value );

					// $meta_value = preg_replace(
					// 	"/<([a-z][a-z0-9]*)[^>]*?(\/?)>/si",
						
					// 	'<$1$2>',
						
					// 	$meta_value
					// );

					$post->post_content = $meta_value;

					wp_update_post( $post );
				// }
			}

			// LegalDebug::die( [
			// 	'function' => 'NotionAffiliate::billet_afillate',

			// 	'meta_key' => $meta_key,

			// 	'meta_value' => $meta_value,

			// 	'about_afillate_id' => $about_afillate_id,

			// 	'field' => $field,
			// ] );
		}
	}
}

?>
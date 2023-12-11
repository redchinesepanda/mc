<?php

class NotionContent
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'review_content' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'review_content' ], 11, 4 );
	}

	public static function remove_comments( $content )
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

	public static function get_nodes( $dom, $query )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( $query );

		return $nodes;
	}

	public static function get_nodes_code( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//code'
		);
	}

	public static function get_code_content( $dom )
	{
		$nodes = self::get_nodes_code( $dom );

		// LegalDebug::debug( [
		// 	'function' => 'NotionContent::get_code_content',

		// 	'$nodes->length' => $nodes->length,
		// ] );

		$content = [];

		if ( $nodes->length == 0 )
		{
			return '';
		}

		foreach ( $nodes as $node )
		{
			$content[] = htmlspecialchars_decode( $dom->saveHTML( $node ) );
		}

		return implode( '', $content );
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
					$dom = LegalDOM::get_dom( $content );

					$content = self::get_code_html( $meta_value );

					if ( empty( $content ) )
					{
						// $meta_value = self::remove_comments( $meta_value );

						// $meta_value = self::remove_tags( $meta_value );

						// $meta_value = self::remove_attr( $meta_value );

						$content = $meta_value;
					}

					// $post->post_content = $meta_value;

					$post->post_content = $content;

					wp_update_post( $post );
				// }
			}

			// LegalDebug::die( [
			// 	'function' => 'NotionContent::review_content',

			// 	'meta_key' => $meta_key,

			// 	'meta_value' => $meta_value,
			// ] );
		}
	}
}

?>
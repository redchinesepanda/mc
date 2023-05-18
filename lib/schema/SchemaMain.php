<?php

class SchemaMain
{
	public static function register()
    {
        $handler = new self();

        add_filter( 'hunch_schema_markup', [ $handler, 'markup' ] );
    }

	// public static function markup( $SchemaMarkup, $SchemaMarkupType, $post, $PostType )
	
	public static function markup( $SchemaMarkup )
	{
		LegalDebug::debug( [
			'SchemaMarkup' => json_decode( $SchemaMarkup ),
			
			// 'SchemaMarkupType' => $SchemaMarkupType,

			// 'post_title' => $post->post_title,

			// 'PostType' => $PostType,
		] );

		return $SchemaMarkup;
	}
}

?>
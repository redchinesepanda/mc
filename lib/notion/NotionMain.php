<?php

require_once( 'NotionList.php' );

require_once( 'NotionImage.php' );

require_once( 'NotionWPML.php' );

class NotionMain
{
	public static function register_functions()
	{
		$handler = new self();

		// add_action( 'edit_form_after_title', [ $handler, 'billet_list_show' ], 10, 4 );

		NotionList::register_functions();

		NotionImage::register_functions();

		// NotionWPML::register_functions();
	}

	const META_FIELD = [
		'list' => 'notion_billet_list',

		'list-debug' => 'notion_billet_list_debug',

		'language-code' => 'notion_language_code',

		'about-logo' => 'notion_about_logo',
	];

	const ACF_KEY = [
		'parts' => 'field_6412f442f2c53',

		'settings' => 'field_6437de4fa65c9',

		'bonus' => 'field_651ab4be3b28d',
	];

	const ACF_FIELD = [
		'parts' => 'billet-list-parts',

		'settings' => 'review-about',

		'bonus' => 'billet-feture-bonus',
	];

	public static function array_is_list( array $arr )
	{
		if ( $arr === [] )
		{
			return true;
		}

		return array_keys( $arr ) === range( 0, count( $arr ) - 1 );
	}

	public static function billet_list_show( $post )
	{
		LegalDebug::debug( [
			'function' => 'NotionMain::billet_list_show',

			self::ACF_FIELD[ 'settings' ] => get_field( self::ACF_FIELD[ 'settings' ], $post->ID ),

			self::META_FIELD[ 'about-logo' ] => get_post_meta( $post->ID, self::META_FIELD[ 'about-logo' ], true ),
		] );
	}
}

?>
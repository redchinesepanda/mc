<?php

require_once( 'NotionList.php' );

require_once( 'NotionImage.php' );

require_once( 'NotionWPML.php' );

require_once( 'NotionBonus.php' );

require_once( 'NotionAffiliate.php' );

require_once( 'NotionTaxonomy.php' );

require_once( 'NotionContent.php' );

class NotionMain
{
	public static function register_functions()
	{
		// $handler = new self();

		// add_action( 'edit_form_after_title', [ $handler, 'billet_list_show' ], 10, 4 );

		NotionList::register_functions();

		NotionImage::register_functions();

		NotionWPML::register_functions();

		NotionBonus::register_functions();

		NotionAffiliate::register_functions();

		NotionTaxonomy::register_functions();

		NotionContent::register_functions();
	}

	const META_FIELD = [
		// 'list' => 'notion_billet_list',

		'list-debug' => 'notion_billet_list_debug',

		'language-code' => 'notion_language_code',

		// 'bonus' => 'notion_billet_bonus',

		'about-afillate' => 'notion_about_afillate',

		'about-logo' => 'notion_about_logo',

		'feature' => 'notion_billet_feature',

		// 'content' => 'notion_review_content',
	]; 

	const ACF_KEY = [
		'parts' => 'field_6412f442f2c53',

		'settings' => 'field_6437de4fa65c9',

		// 'bonus' => 'field_651ab4be3b28d',
	];

	const ACF_FIELD = [
		'parts' => 'billet-list-parts',

		'settings' => 'review-about',

		// 'bonus' => 'billet-feture-bonus',
	];

	public static function array_is_list( array $arr )
	{
		if ( $arr === [] )
		{
			return true;
		}

		return array_keys( $arr ) === range( 0, count( $arr ) - 1 );
	}

	// public static function billet_list_show( $post )
	// {
	// 	LegalDebug::debug( [
	// 		'function' => 'NotionMain::billet_list_show',

	// 		self::META_FIELD[ 'about-afillate' ] => get_post_meta( $post->ID, self::META_FIELD[ 'about-afillate' ], true ),

	// 		NotionAffiliate::REVIEW_ABOUT_FIELD[ 'afillate' ] => get_field( self::ACF_FIELD[ 'settings' ] . '_' . NotionAffiliate::REVIEW_ABOUT_FIELD[ 'afillate' ], $post->ID, false ),
	// 	] );
	// }
}

?>
<?php

class MultisiteShortcodeSync
{
	const PATTERNS = [
		'regex' => '/%s/',

		'shortcode' => '[%1$s %2$s]',

		'attr-pair' => '%1$s="%2$s"',
	];

	const SHORTCODES = [
		'gallery' => 'gallery',
	];

	// BilletMega::SHORTCODE[ 'mega' ]

	public static function register_functions_debug()
	{
		$handler = new self();

		add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );
	}

	function mc_edit_form_after_title_debug( $post )
	{
		$post_prepared = MultisitePost::get_post( $post->ID );

		self::get_mega_shortcodes_ids( $post->ID, $post_prepared );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'register_functions_admin',

		// 	'post_parent' => $post->post_parent,
		// ] );
	}

	public static function get_mega_shortcodes_ids( $post_id, $post )
    {
        $matches = [];

		$handler = new self();

		$result = preg_match_all( 
			MultisiteGallerySync::get_gallery_shortcode_regexp( self::SHORTCODES ),

			$post[ 'post_content' ],

			$matches,

			PREG_SET_ORDER
		);

		LegalDebug::debug( [
			'MultisiteGallerySync' => 'get_gallery_shortcodes_ids',

			'get_shortcode_regex' => get_shortcode_regex( self::SHORTCODES ),

			'get_gallery_shortcode_regexp' => MultisiteGallerySync::get_gallery_shortcode_regexp( self::SHORTCODES ),

			'matches' => $matches,
		] );

		// $ids = self::get_gallery_matches_ids( $matches );

		// return $ids;
    }
}

?>
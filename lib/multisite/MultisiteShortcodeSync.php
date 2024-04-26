<?php

class MultisiteShortcodeSync
{
	const PATTERNS = [
		'regex' => '/%s/',

		'shortcode' => '[%1$s %2$s]',

		'attr-pair' => '%1$s="%2$s"',
	];

	const SHORTCODES = [
		'mega' => 'billet-mega',
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

		// self::get_mega_shortcodes_ids( $post->ID, $post_prepared );

		self::set_shortcodes( $post->ID, $post_prepared );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'register_functions_admin',

		// 	'post_parent' => $post->post_parent,
		// ] );
	}

	public static function sync_shortcode_ids( $match )
	{
		$atts = shortcode_parse_atts( $match[ 3 ] );

		if ( ! empty( $atts[ 'id' ] ) )
        {
            $ids = explode( ',', $atts[ 'id' ] );
			
			$ids = MultisiteGallerySync::set_gallery_shortcode_moved_ids( $ids );

			$atts[ 'id' ] = implode( ',', $ids );
        }

		return MultisiteGallerySync::get_atts_part( $atts );
	}

	public static function replace_shortcodes_ids( $match )
	{
		$atts = self::sync_shortcode_ids( $match );

		$shortcode = $match[ 2 ];

		$result = sprintf( self::PATTERNS[ 'shortcode' ], $shortcode, $atts );

		// LegalDebug::debug( [
		// 	'MultisiteGallerySync' =>'replace_gallery_shortcodes_ids',

		// 	'match' => $match,

		// 	'result' => $result,
		// ] );

		return $result;
	}

	public static function set_shortcodes( $post_id, $post )
    {
        $handler = new self();

		$result = preg_replace_callback( 
			self::get_shortcodes_regexp(),

			[ $handler, 'replace_shortcodes_ids' ],

			$post[ 'post_content' ]
		);

		$post[ 'post_content' ] = $result;

		LegalDebug::die( [
			'MultisiteGallerySync' =>'set_gallery_shortcode',

			'post_id' => $post_id,

			'result' => $result,
		] );

		// MultisitePost::update_post( $post );
    }

	public static function get_shortcodes()
	{
		return [
			BilletMega::SHORTCODE[ 'mega' ],
		];
	}

	public static function get_shortcodes_regexp()
	{
		return MultisiteGallerySync::get_gallery_shortcode_regexp( self::get_shortcodes() );
	}

	public static function get_mega_shortcodes_ids( $post_id, $post )
    {
        $matches = [];

		$handler = new self();

		$result = preg_match_all( 
			self::get_shortcodes_regexp(),

			$post[ 'post_content' ],

			$matches,

			PREG_SET_ORDER
		);

		LegalDebug::debug( [
			'MultisiteGallerySync' => 'get_gallery_shortcodes_ids',

			'matches' => $matches,
		] );

		// $ids = self::get_gallery_matches_ids( $matches );

		// return $ids;
    }
}

?>
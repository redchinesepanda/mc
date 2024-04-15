<?php

class MultisiteTermSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',
    ];

	const FIELDS = [
	];

	const FIELDS_REPEATER = [
		'feture-bonus' => [
			'name' => 'billet-feture-bonus',

			'key' => 'field_651ab4be3b28d',
		],
	];

	const FIELD_FETURE_BONUS = [
		'feature-id' => [
			'name' => 'billet-feture-id',

			'key' => 'field_651ab5083b28e',
		],
	];

	public static function register_functions_admin()
    {
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();
			
			// add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_terms' ], 10, 2 );

			add_action( 'edit_form_after_title', [ $handler, 'mc_debug_edit_form_after_title_action' ] );
		}
	}

	function mc_debug_edit_form_after_title_action( $post )
	{
		$post = get_post();

		self::set_terms( $post, $post->ID );

		// $all_terms = self::get_post_terms( $post->ID );

		// self::add_post_terms( $post->ID, $terms );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'mc_debug_edit_form_after_title_action',

		// 	'all_terms' => $all_terms,
		// ] );

		// foreach ( $all_terms as $taxonomy => $terms )
		// {
		// 	foreach ( $terms as $term )
		// 	{
		// 		LegalDebug::debug( [
		// 			'MultisiteTerms' => 'mc_debug_edit_form_after_title_action',

		// 			'term_id' => $term->term_id,

		// 			'slug' => $term->slug,
	
		// 			'movef-from' => MultisiteMeta::get_term_moved_from( $term->term_id ),
		// 		] );
		// 	}
		// }
	}

	public static function get_repeaters()
	{
		$fields_repeater = array_column( self::FIELDS_REPEATER, 'name' );

		$repeaters = [];

		foreach ( $fields_repeater as $field_name )
		{
			$repeaters[] = MultisiteACF::get_field( $field_name, $post_id );
		}

		return $repeaters;
	}

	public static function set_terms( $post_id, $post )
    {
		$repeaters = self::get_repeaters();

		LegalDebug::debug( [
			'MultisiteTermSync' => 'set_terms',

			'repeaters' => $repeaters,
		] );

		// $origin_post_ids = self::get_origin_post_ids( $post_id, $post );

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'set_attachments',

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );

		// foreach ( $origin_post_ids as $field_name => $origin_post_id )
		// {
		// 	// LegalDebug::debug( [
		// 	// 	'MultisiteAttachmentSync' => 'set_attachments',

		// 	// 	'origin_post_id' => $origin_post_id,
		// 	// ] );

		// 	if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
		// 	{
		// 		MultisiteACF::update_field( $field_name, $post_moved_id, $post_id );

		// 		// LegalDebug::debug( [
		// 		// 	'MultisiteAttachmentSync' => 'set_attachments',
		
		// 		// 	'post_moved_id' => $post_moved_id,
		// 		// ] );
		// 	}
		// }

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'set_attachments',
		// ] );
    }
}

?>
<?php

class MultisiteHreflang
{
	public static function register_functions_debug()
	{
		$handler = new self();

		add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );

		// add_action( 'category_pre_edit_form', [ $handler, 'mc_category_pre_edit_form_debug' ], 10, 2 );
	}

    function mc_edit_form_after_title_debug( $post )
	{
        $group_items = self::get_group_items( $post->ID );

		LegalDebug::debug( [
			'MultisiteHreflang' => 'mc_edit_form_after_title_debug',

			'group_items' => $group_items,
		] );
    }

	public static function get_group_items( $post_id )
	{
		$translation_groups = WPMLTranslationGroups::get_translation_group( $post_id );

		return [];
	}
}

?>
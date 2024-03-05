<?php

class ToolCategoryRedirect
{
	const META_FIELD = [
		'redirect' => 'page_redirect'
	];

	public static function register()
	{
		$handler = new self();

		add_filter( 'term_link', [ $handler, 'modify_term_link' ], 10, 3 );

		add_action( 'edited_category', [ $handler, 'save_meta' ] );

		add_action( 'create_category', [ $handler, 'save_meta' ] );

		add_action( 'category_edit_form_fields', [ $handler, 'edit_field_redirect' ] );

		add_action( 'category_add_form_fields', [ $handler, 'add_field_redirect' ] );
	}

	public static function modify_term_link( $link, $term )
	{
		return self::get_link( $term->term_id, $link );
	}

	public static function get_link( $term_id, $default_link = '' )
	{
		$redirect_page_id = self::get_redirect_page_id( $term_id );

		if ( (int) $redirect_page_id && !is_admin() )
		{
			$link = get_permalink( $redirect_page_id );
		}

		return empty( $link ) ? $default_link : $link;
	}

	public static function get_redirect_page_id( $term_id )
	{
		return self::get_meta( $term_id, self::META_FIELD[ 'redirect' ] );
	}

	public static function get_meta( $term_id, $meta_field = '', $default_value = null )
	{
		$result = get_term_meta( $term_id, $meta_field, true );

		if ( $meta_field && ( $result === null || $result === false ) )
		{
			$result = $default_value;
		}

		return $result;
	}

	public static function save_meta( $term_id )
	{
		self::save_extra_fields( $term_id );
	}

	public static function save_extra_fields( $term_id )
	{
		if ( isset( $_POST[ self::META_FIELD[ 'redirect' ] ] ) )
		{
			self::set_meta( $term_id, self::META_FIELD[ 'redirect' ], sanitize_text_field( $_POST[ self::META_FIELD[ 'redirect' ] ] ) );
		}
	}

	public static function set_meta( $term_id, $meta_field, $meta_value )
	{
		update_term_meta( $term_id, $meta_field, $meta_value );
	}

	public static function get_selected( $page_id, $redirect_page_id )
	{
		return $page_id === (int) $redirect_page_id ? 'selected' : '';
	}

	public static function get_options( $term_id = 0 )
	{
		$options = [
			[
				'id' => 0,
	
				'title' => __( ToolsMain::TEXT[ 'none' ], ToolLoco::TEXTDOMAIN ),

				'selected' => '',
			],
		];

		$redirect_page_id = 0;

		if ( !empty( $term_id ) )
		{
			$redirect_page_id = self::get_redirect_page_id( $term_id );
		}

		foreach ( get_pages() as $page )
		{
			$options[] = [
				'id' => $page->ID,
	
				'title' => get_the_title( $page->ID ),

				'selected' => self::get_selected( $page->ID, $redirect_page_id )
			];
		}
		
		return $options;
	}

	public static function get( $term_id = 0 )
	{
		return [
			'field' => self::META_FIELD[ 'redirect' ],

			'label' => __( ToolsMain::TEXT[ 'redirect' ], ToolLoco::TEXTDOMAIN ),

			'options' => self::get_options( $term_id ),

			'description' => __( ToolsMain::TEXT[ 'if-set-you-can' ], ToolLoco::TEXTDOMAIN ),
		];
	}

	const TEMPATE = [
		'redirect-add' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-category-redirect-add.php',
		
		'redirect-edit' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-category-redirect-edit.php',
	];
	
	public static function render_add()
    {
        return LegalComponents::render_main( self::TEMPATE[ 'redirect-add' ], self::get() );
    }

	public static function render_edit( $term_id = 0 )
    {
        return LegalComponents::render_main( self::TEMPATE[ 'redirect-edit' ], self::get( $term_id ) );
    }

	public static function add_field_redirect()
	{
		echo self::render_add();
	}

	public static function edit_field_redirect( $term )
	{
		echo self::render_edit( $term->term_id );
	}
}

?>
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

		add_action( 'category_edit_form_fields', [ $handler, 'echo_field_redirect' ] );

		add_action( 'category_add_form_fields', [ $handler, 'echo_field_redirect' ] );
	}

	public static function modify_term_link( $link, $term )
	{
		return self::get_link( $term->term_id, $link );
	}

	public static function get_link( $term_id, $default_link = '' )
	{
		$page_id = self::get_redirect_page_id( $term_id );

		if ( (int) $page_id && !id_admin() )
		{
			$link = get_permalink( $page_id );
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

	public static function get_options()
	{
		$options = [
			[
				'id' => 0,
	
				'title' => __( 'None', ToolLoco::TEXTDOMAIN ),
			],
		];

		foreach ( get_pages() as $page )
		{
			$options[] = [
				'id' => $page->ID,
	
				'title' => get_the_title( $page->ID ),
			];
		}
		
		return $options;
	}

	public static function get()
	{
		return [
			'field' => self::META_FIELD[ 'redirect' ],

			'label' => __( 'Redirect Category to a Page', ToolLoco::TEXTDOMAIN ),

			'options' => self::get_options(),

			'description' => __( 'If set you can replace the WordPress category page with your own highly optimised landing page', ToolLoco::TEXTDOMAIN ),
		];
	}

	const TEMPATE = [
		LegalMain::LEGAL_PATH . '/template-parts/admin/part-notice.php',

		'redirect' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-category-redirect.php',
	];
	
	public static function render()
    {
        return LegalComponents::render_main( self::TEMPATE[ 'redirect' ], self::get() );
    }

	public static function echo_field_redirect()
	{
		echo self::render();
	}
}

?>
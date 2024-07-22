<?php

class BrandFilter
{
	const POST_TYPE = [
		'brand' => 'legal_brand',

		'billet' => 'legal_billet',
	];

	const QUERY_VARS = [
		'ids' => 'legal-brand-ids',
	];

	const FIELD = [
        'brand' => 'billet-brand',
    ];

	const TAXONOMY = [
        'type' => 'brand_type',
    ];

	public static function check_add_bulk_actions()
	{
		return MultisiteMain::check_multisite()
		
			&& MultisiteBlog::check_main_blog();
	}

	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			if ( MultisiteBlog::check_main_domain() )
			{
				$handler = new self();

				// add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_brand_type' ], 10, 2 );
		
				add_action( 'restrict_manage_posts', [ $handler, 'brand_type_filter' ] );
			}
		}

		if ( self::check_add_bulk_actions() )
        {
            $handler = new self();

			// 'edit_post_' . self::POST_TYPE[ 'billet' ]

            add_filter( 'bulk_actions-edit-' . self::POST_TYPE[ 'billet' ], [ $handler, 'add_brand_type_item' ] );

            add_filter( 'handle_bulk_actions-edit-' . self::POST_TYPE[ 'billet' ], [ $handler, 'handle_brand_type_item' ], 10, 3);

            add_action( 'admin_notices', [ $handler, 'notify_brand_type_item' ] );
        }
    }

	const ACTION = [
        'set-brand-type'=> 'set-brand-type',

        'done-brand-type'=> 'done-brand-type',
    ];

	public static function notify_brand_type_item()
    {
    	if ( ! empty( $_REQUEST[ self::ACTION[ 'done-brand-type' ] ] ) )
        {
    		$num_changed = (int) $_REQUEST[ self::ACTION[ 'done-brand-type' ] ];

    		// printf( '<div id="message" class="updated notice is-dismissable"><p>' . __('Published %d posts.', 'txtdomain') . '</p></div>', $num_changed );

    		$message = sprintf( ToolLoco::translate( 'Brand type set for bilets and affiliate links attached to %d posts' ), $num_changed );

            $args = [
                'message' => $message,
			];

            self::print_notices( $args );
    	}
    }

	public static function redirect_clean( $redirect )
	{
		return remove_query_arg( self::ACTION, $redirect );
	}

	public static function handle_brand_type_item( $redirect_url, $action, $post_ids )
    {
        if ( $action == self::ACTION[ 'set-brand-type' ] )
        {
            $redirect_url = self::redirect_clean( $redirect_url );
    	
    		foreach ( $post_ids as $post_id )
            {
    			$post = get_post( $post_id );

                if ( $post )
                {
                    self::set_brand_type( $post_id, $post );
                }
    		}

    		$redirect_url = add_query_arg( self::ACTION[ 'done-brand-type' ], count( $post_ids ), $redirect_url );
    	}

    	return $redirect_url;
    }

    public static function add_brand_type_item( $bulk_actions )
    {
    	$bulk_actions[ self::ACTION[ 'set-brand-type' ] ] = ToolLoco::translate( 'Set Brand Type' );

    	return $bulk_actions;
    }

	public static function brand_type_filter( $post_type = '' )
	{
		$screen = get_current_screen();

		// LegalDebug::debug( [
		// 	'BrandFilter' => 'brand_type_filter',

		// 	'screen' => $screen,
		// ] );

		if ( empty( $post_type ) )
		{
			$post_type = self::POST_TYPE[ 'brand' ];
		}

		// if ( 'edit-' . self::POST_TYPE[ 'brand' ] == $screen->id )
		
		if ( 'edit-' . $post_type == $screen->id )
		{
			$selected = isset( $_GET[ self::TAXONOMY[ 'type' ] ] ) ? $_GET[ self::TAXONOMY[ 'type' ] ] : '';

			$dropdown_options = [ 
				'taxonomy' => self::TAXONOMY[ 'type' ],

				'show_option_all' => ToolLoco::translate( 'View all brand types' ), 

				'hide_empty' => false, 

				'hierarchical' => false,

				 // default is cat which wouldn't filter custom taxonomies

				'value_field' => 'slug',

				'name' => self::TAXONOMY[ 'type' ], 

				'orderby' => 'name',

				'selected' =>  $selected,
			];

			wp_dropdown_categories( $dropdown_options );
		}
	}

	public static function get_brand_term()
	{
		$current_language = WPMLMain::current_language();

		$term_slug = 'legal-brand-' . $current_language;

		$term_exists = term_exists( $term_slug, self::TAXONOMY[ 'type' ] );

		// LegalDebug::die( [
		// 	'BrandFilter' => 'get_brand_term',

		// 	'current_language' => $current_language,

		// 	'term_slug' => $term_slug,

		// 	'term_exists' => $term_exists,
		// ] );

		if ( ! empty( $term_exists ) )
		{
			return $term_slug;
		}

		$term_name = 'Brand-' . strtoupper( $current_language );

		$inserted_term = wp_insert_term( $term_name, self::TAXONOMY[ 'type' ], [ 'slug' => $term_slug ] );

		if ( ! is_wp_error( $inserted_term ) )
		{
			return $term_slug;
		}
		
		return '';
	}

	public static function set_brand_type( $post_id, $post )
    {
        $brand_id = get_field( self::FIELD[ 'brand' ], $post_id );

		if ( $brand_id )
		{
			$term = self::get_brand_term();

			// LegalDebug::debug( [
			// 	'BrandFilter' => 'set_brand_type',

			// 	'brand_id' => $brand_id,

			// 	'term' => $term,
			// ] );

			$term_ids = [];

			if ( ! empty( $term ) )
			{
				if ( ! has_term( $term, self::TAXONOMY[ 'type' ], $brand_id ) )
				{
					$term_ids = wp_set_object_terms( $brand_id, $term, self::TAXONOMY[ 'type' ], true );
				}
			}

			// LegalDebug::die( [
			// 	'BrandFilter' => 'set_brand_type',

			// 	'term_ids' => $term_ids,
			// ] );
		}
    }

	const TEMPLATE = [
        'brand-type-notices' => LegalMain::LEGAL_PATH . '/template-parts/brand/part-brand-type-notices.php',
    ];

    public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'brand-type-notices' ], $args );
    }
}

?>
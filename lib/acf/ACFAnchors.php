<?php

class ACFAnchors
{
	const POST_TYPE = [
		'page' => 'page',
	];

	const ACTION = [
        'set-anchor-fields'=> 'set-anchor-fields',

        'done-anchor-fields'=> 'done-anchor-fields',
    ];

	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			$handler = new self();
	
			add_filter( 'bulk_actions-edit-' . self::POST_TYPE[ 'page' ], [ $handler, 'add_anchor_fields_item' ] );

			add_filter( 'handle_bulk_actions-edit-' . self::POST_TYPE[ 'page' ], [ $handler, 'handle_anchor_fields_item' ], 10, 3);

			add_action( 'admin_notices', [ $handler, 'notify_anchor_fields_item' ] );

			// self::get_cta_data_item();
		}
    }

	public static function add_anchor_fields_item( $bulk_actions )
    {
    	$bulk_actions[ self::ACTION[ 'set-anchor-fields' ] ] = ToolLoco::translate( 'Set Anchor Fields' );

    	return $bulk_actions;
    }
	
	public static function redirect_clean( $redirect )
	{
		return remove_query_arg( self::ACTION, $redirect );
	}
	
	public static function handle_anchor_fields_item( $redirect_url, $action, $post_ids )
    {
        if ( $action == self::ACTION[ 'set-anchor-fields' ] )
        {
            $redirect_url = self::redirect_clean( $redirect_url );
    	
    		foreach ( $post_ids as $post_id )
            {
    			$post = get_post( $post_id );

                if ( $post )
                {
					// LegalDebug::debug( [
					// 	'ToolAnchorAttributes' => 'handle_cta_fields_item',

					// 	'post_id' => $post_id,
					// ] );

                    self::modify_fields( $post_id, $post );
                }
    		}

    		$redirect_url = add_query_arg( self::ACTION[ 'done-anchor-fields' ], count( $post_ids ), $redirect_url );
    	}

    	return $redirect_url;
    }

	public static function notify_anchor_fields_item()
    {
    	if ( ! empty( $_REQUEST[ self::ACTION[ 'done-anchor-fields' ] ] ) )
        {
    		$num_changed = (int) $_REQUEST[ self::ACTION[ 'done-anchor-fields' ] ];

    		$message = sprintf( ToolLoco::translate( 'Anchor Fields set for %d posts' ), $num_changed );

            $args = [
                'message' => $message,
			];

            self::print_notices( $args );
    	}
    }
	
	public static function update_anchor_fields( $anchor_items, $post_id )
	{
		$value = [];

		foreach ( $anchor_items as $anchor_item )
		{
			$value[] = [
				ReviewAnchors::ANCHORS_KEY[ 'id' ] => str_replace( '#', '', $anchor_item[ 'href' ] ),

				ReviewAnchors::ANCHORS_KEY[ 'label' ] => $anchor_item[ 'label' ],
			];
		}

		LegalDebug::debug( [
			'ToolReviewAnchors' =>'modify_fields-0',

            'value' => $value,
		] );

		update_field( ReviewAnchors::FIELD_KEY[ 'anchors' ], $value, $post_id );
	}
	
	public static function modify_fields( $post_id, $post )
	{
		// $bookmaker_name = ReviewAbout::get_title( $post_id );

		$repeater = get_field( ReviewAnchors::FIELD[ 'anchors' ], $post_id );

		// $bookmaker_name = ReviewAbout::get_about_title( $group );

		$anchor_items = ReviewAnchors::get_items_auto( $post_id );

		LegalDebug::debug( [
			'ToolReviewAnchors' =>'modify_fields-0',

			'post_id' => $post_id,

			'repeater' => $repeater,

            'anchor_items' => $anchor_items,
		] );

		if ( empty( $repeater ) && ! empty( $anchor_items ) )
		{
			self::update_anchor_fields( $anchor_items, $post_id );
		}

		LegalDebug::die( [
			'ToolReviewAnchors' =>'modify_fields-1',

			'repeater' => get_field( ReviewAnchors::FIELD[ 'anchors' ], $post_id ),
		] );
	}

	const TEMPLATE = [
        'anchor-fields-notices' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-cta-fields-notices.php',
    ];

    public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'anchor-fields-notices' ], $args );
    }
}

?>
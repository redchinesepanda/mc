<?php

class ToolAnchor
{
	const ACTION = [
        'set-anchor-href'=> 'set-anchor-href',

        'done-anchor-href'=> 'done-anchor-href',
    ];

	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			$handler = new self();
	
			add_filter( 'bulk_actions-edit-page', [ $handler, 'add_anchor_href_item' ] );
	
			add_filter( 'handle_bulk_actions-edit-page', [ $handler, 'handle_anchor_href_item' ], 10, 3);
	
			add_action( 'admin_notices', [ $handler, 'notify_anchor_href_item' ] );
		}
    }

	public static function notify_anchor_href_item()
    {
    	if ( ! empty( $_REQUEST[ self::ACTION[ 'done-anchor-href' ] ] ) )
        {
    		$num_changed = (int) $_REQUEST[ self::ACTION[ 'done-anchor-href' ] ];

    		$message = sprintf( ToolLoco::translate( 'Anchor href set for %d posts' ), $num_changed );

            $args = [
                'message' => $message,
			];

            self::print_notices( $args );
    	}
    }

	public static function redirect_clean( $redirect )
	{
		// LegalDebug::die( [
		// 	'ToolAnchor' =>'redirect_clean-1',

		// 	'redirect' => $redirect,
		// ] );

		return remove_query_arg( self::ACTION, $redirect );
	}

	public static function handle_anchor_href_item( $redirect_url, $action, $post_ids )
    {
        if ( $action == self::ACTION[ 'set-anchor-href' ] )
        {
            $redirect_url = self::redirect_clean( $redirect_url );
    	
    		foreach ( $post_ids as $post_id )
            {
    			$post = get_post( $post_id );

                if ( $post )
                {
					self::modify_content( $post_id, $post );
                }
    		}

    		$redirect_url = add_query_arg( self::ACTION[ 'done-anchor-href' ], count( $post_ids ), $redirect_url );
    	}

    	return $redirect_url;
    }

    public static function add_anchor_attributes_item( $bulk_actions )
    {
    	$bulk_actions[ self::ACTION[ 'set-anchor-href' ] ] = ToolLoco::translate( 'Set Anchor href' );

    	return $bulk_actions;
    }

	public static function get_nodes_anchors_href( $dom )
	{
		$query = self::PATTERNS[ 'a-href-go' ];

		return LegalDOM::get_nodes( $dom, $query );
	}

	public static function modify_anchors_href( $dom )
	{
		$nodes_anchors_go = self::get_nodes_anchors_go( $dom );

		self::add_rel_nofollow( $nodes_anchors_go );
	}

	public static function modify_content( $post_id, $post )
    {
		if ( $post )
		{
			$dom = LegalDOM::get_dom( $post->post_content );
	
			self::modify_anchors_href( $dom );
	
			$content = $dom->saveHTML( $dom );

			$post_modified = [
				'ID' => $post_id,

                'post_content' => $content,
			];

			wp_update_post( $post_modified );

			// LegalDebug::die( [
			// 	'ToolAnchorAttributes' => 'modify_content-1',

			// 	'content' => $content,
			// ] );
		}
    }
}

?>
<?php

class AffiliateHref
{
	const PATTERNS = [
		'a-href-go' => "//a[contains(@href,'/go/')]",
	];

	const ATTRIBUTE = [
		'href' => 'href',
	];

	const POST_TYPE = [
		'page' => 'page',

		'post' => 'post',
	];

	const ACTION = [
        'set-affiliate-href'=> 'set-affiliate-href',

        'done-affiliate-href'=> 'done-affiliate-href',
    ];

	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			$handler = new self();
	
			add_filter( 'bulk_actions-edit-' . self::POST_TYPE[ 'page' ], [ $handler, 'add_affiliate_href_item' ] );
	
			add_filter( 'handle_bulk_actions-edit-' . self::POST_TYPE[ 'page' ], [ $handler, 'handle_affiliate_href_item' ], 10, 3);

			add_filter( 'bulk_actions-edit-' . self::POST_TYPE[ 'post' ], [ $handler, 'add_affiliate_href_item' ] );
	
			add_filter( 'handle_bulk_actions-edit-' . self::POST_TYPE[ 'post' ], [ $handler, 'handle_affiliate_href_item' ], 10, 3);
	
			add_action( 'admin_notices', [ $handler, 'notify_affiliate_href_item' ] );
		}
    }

	public static function notify_affiliate_href_item()
    {
    	if ( ! empty( $_REQUEST[ self::ACTION[ 'done-affiliate-href' ] ] ) )
        {
    		$num_changed = (int) $_REQUEST[ self::ACTION[ 'done-affiliate-href' ] ];

    		$message = sprintf( ToolLoco::translate( 'Affiliate href set for %d posts' ), $num_changed );

            $args = [
                'message' => $message,
			];

            self::print_notices( $args );
    	}
    }

	public static function redirect_clean( $redirect )
	{
		// LegalDebug::die( [
		// 	'ToolAnchorAttributes' =>'redirect_clean-1',

		// 	'redirect' => $redirect,
		// ] );

		return remove_query_arg( self::ACTION, $redirect );
	}
	
	public static function handle_affiliate_href_item( $redirect_url, $action, $post_ids )
    {
        if ( $action == self::ACTION[ 'set-affiliate-href' ] )
        {
            $redirect_url = self::redirect_clean( $redirect_url );
    	
    		foreach ( $post_ids as $post_id )
            {
    			$post = get_post( $post_id );

                if ( $post )
                {
					// LegalDebug::debug( [
					// 	'ToolAnchorAttributes' => 'handle_affiliate_href_item-1',

					// 	'post_id' => $post_id,
					// ] );

                    self::modify_content( $post_id, $post );
                }
    		}

    		$redirect_url = add_query_arg( self::ACTION[ 'done-affiliate-href' ], count( $post_ids ), $redirect_url );
    	}

    	return $redirect_url;
    }

	public static function add_affiliate_href_item( $bulk_actions )
    {
    	$bulk_actions[ self::ACTION[ 'set-affiliate-href' ] ] = ToolLoco::translate( 'Set Anchor Attributes' );

    	return $bulk_actions;
    }
	
	public static function modify_href_domain( $nodes )
	{
		if ( ! empty( $nodes ) )
		{


			foreach ( $nodes as $node )
			{
				$href = $node->getAttribute( self::ATTRIBUTE[ 'href' ] );

				$href_parsed = parse_url( $href );

				LegalDebug::debug( [
					'ToolAnchorAttributes' => 'get_nodes_anchors_go-1',

					'href' => $href,

					'href_parsed' => $href_parsed,
				] );
	
				$node->setAttribute( self::ATTRIBUTE[ 'href' ], $href );
			}
		}
	}

	public static function get_nodes_anchors_go( $dom )
	{
		$query = self::PATTERNS[ 'a-href-go' ];

		return LegalDOM::get_nodes( $dom, $query );
	}

	public static function modify_anchors_go_href( $dom )
	{
		$nodes_anchors_go_href = self::get_nodes_anchors_go_href( $dom );

		self::modify_href_domain( $nodes_anchors_go_href );
	}

	public static function modify_content( $post_id, $post )
    {
		if ( $post )
		{
			$dom = LegalDOM::get_dom( $post->post_content );

			self::modify_anchors_go_href( $dom );
	
			$content = $dom->saveHTML( $dom );

			$post_modified = [
				'ID' => $post_id,

                'post_content' => $content,
			];

			wp_update_post( $post_modified );

			// LegalDebug::die( [
			// 	'AffiliateHref' => 'modify_content-1',

			// 	'content' => $content,
			// ] );
		}
    }

	const TEMPLATE = [
        'affiliate-href-notices' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-affiliate-href-notices.php',
    ];

    public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'affiliate-href-notices' ], $args );
    }
}

?>
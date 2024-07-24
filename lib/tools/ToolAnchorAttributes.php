<?php

class ToolAnchorAttributes
{
	const PATTERNS = [
		'a-all' => "//a",
		
		'a-href-external' => "//a[not(contains(@href, '%s'))][not(self::node()[contains(@href,'mailto:')])][not(self::node()[contains(@href,'tel:')])]",
		
		'a-href-internal' => "//a[contains(@href, '%s')][not(self::node()[contains(@href,'mailto:')])][not(self::node()[contains(@href,'tel:')])]",
	];

	const ATTRIBUTE = [
		'target' => 'target',

		'rel' => 'rel',
	];

	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			$handler = new self();
	
			add_filter( 'bulk_actions-edit-page', [ $handler, 'add_anchor_attributes_item' ] );
	
			add_filter( 'handle_bulk_actions-edit-page', [ $handler, 'handle_anchor_attributes_item' ], 10, 3);
	
			add_action( 'admin_notices', [ $handler, 'notify_anchor_attributes_item' ] );
		}
    }

	const ACTION = [
        'set-anchor-attributes'=> 'set-anchor-attributes',

        'done-anchor-attributes'=> 'done-anchor-attributes',
    ];

	public static function notify_anchor_attributes_item()
    {
    	if ( ! empty( $_REQUEST[ self::ACTION[ 'done-anchor-attributes' ] ] ) )
        {
    		$num_changed = (int) $_REQUEST[ self::ACTION[ 'done-anchor-attributes' ] ];

    		$message = sprintf( ToolLoco::translate( 'Anchor attributes set for %d posts' ), $num_changed );

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

	public static function handle_anchor_attributes_item( $redirect_url, $action, $post_ids )
    {
        if ( $action == self::ACTION[ 'set-anchor-attributes' ] )
        {
            $redirect_url = self::redirect_clean( $redirect_url );
    	
    		foreach ( $post_ids as $post_id )
            {
    			$post = get_post( $post_id );

                if ( $post )
                {
					LegalDebug::debug( [
						'ToolAnchorAttributes' => 'handle_anchor_attributes_item',

						'post_id' => $post_id,
					] );

                    self::modify_content( $post_id, $post );
                }
    		}

    		$redirect_url = add_query_arg( self::ACTION[ 'done-anchor-attributes' ], count( $post_ids ), $redirect_url );
    	}

    	return $redirect_url;
    }

    public static function add_anchor_attributes_item( $bulk_actions )
    {
    	$bulk_actions[ self::ACTION[ 'set-anchor-attributes' ] ] = ToolLoco::translate( 'Set Anchor Attributes' );

    	return $bulk_actions;
    }

	public static function add_attributes( $nodes )
	{
		foreach ( $nodes as $node )
		{
			$node->setAttribute( self::ATTRIBUTE[ 'target' ], '_blank' );

			$node->setAttribute( self::ATTRIBUTE[ 'rel' ], 'noreferrer nofollow' );
		}
	}

	public static function get_nodes_anchors_external( $dom )
	{
		$domain = MultisiteBlog::get_domain();
		
		$query = sprintf( self::PATTERNS[ 'a-href-external' ], $domain );

		return LegalDOM::get_nodes( $dom, $query );
	}

	public static function modify_external( $dom )
	{
		$nodes_anchors_external = self::get_nodes_anchors_external( $dom );
		
		LegalDebug::debug( [
			'ToolAnchorAttributes' => 'modify_external-1',

			'nodes_anchors_external' => $nodes_anchors_external,
		] );

		self::add_attributes( $nodes_anchors_external );
	}

	public static function remove_attributes( $nodes )
	{
		foreach ( $nodes as $node )
		{
			$node->removeAttribute( self::ATTRIBUTE[ 'target' ] );

			$node->removeAttribute( self::ATTRIBUTE[ 'rel' ] );
		}
	}

	public static function get_nodes_anchors_internal( $dom )
	{
		$domain = MultisiteBlog::get_domain();
		
		$query = sprintf( self::PATTERNS[ 'a-href-internal' ], $domain );

		// LegalDebug::debug( [
		// 	'ToolAnchorAttributes' => 'get_nodes_anchors_internal-1',

		// 	'domain' => $domain,

		// 	'query' => $query,
		// ] );

		return LegalDOM::get_nodes( $dom, $query );
	}

	public static function modify_internal( $dom )
	{
		$nodes_anchors_internal = self::get_nodes_anchors_internal( $dom );

		LegalDebug::debug( [
			'ToolAnchorAttributes' => 'modify_internal-1',

			'nodes_anchors_internal' => $nodes_anchors_internal,
		] );

		self::remove_attributes( $nodes_anchors_internal );
	}

	public static function modify_anchors( $dom )
	{
		self::modify_internal( $dom );

		self::modify_external( $dom );
	}

	public static function get_nodes_anchors_all( $dom )
	{
		$domain = MultisiteBlog::get_domain();
		
		$query = self::PATTERNS[ 'a-all' ];

		LegalDebug::debug( [
			'ToolAnchorAttributes' => 'get_nodes_anchors_all-1',

			'query' => $query,
		] );

		return LegalDOM::get_nodes( $dom, $query );
	}

	public static function get_all( $dom )
	{
		$nodes_anchors_all = self::get_nodes_anchors_all( $dom );

		LegalDebug::debug( [
			'ToolAnchorAttributes' => 'get_all-1',

			'nodes_anchors_all' => $nodes_anchors_all,
		] );
	}

	public static function modify_content( $post_id, $post )
    {
		if ( $post )
		{
			$dom = LegalDOM::get_dom( $post->post_content );

			self::get_all( $dom );
	
			self::modify_anchors( $dom );
	
			$content = $dom->saveHTML( $dom );

			$post_modified = [
				'ID' => $post_id,

                'post_content' => $content,
			];

			wp_update_post( $post_modified );

			LegalDebug::die( [
				'ToolAnchorAttributes' => 'modify_content-1',

				'content' => $content,
			] );
		}
    }

	const TEMPLATE = [
        'anchor-attributes-notices' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-anchor-attributes-notices.php',
    ];

    public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'anchor-attributes-notices' ], $args );
    }
}

?>
<?php

class ToolPermalink
{
    const POST_TYPE = [
		'page' => 'page',

		'post' => 'post',
	];

    public static function register_functions()
    {
        // $handler = new self();

        // add_filter( 'post_type_link', [ $handler, 'wpse_101072_flatten_hierarchies' ], 10, 2 );
        
        // add_filter( 'permalink_manager_filter_query', [ $handler, 'mc_permalink_manager_filter_query' ], 10, 6 );

        if ( MultisiteMain::check_multisite() )
        {
            if ( MultisiteBlog::check_main_domain && MultisiteBlog::check_not_main_blog() )
            {
                add_filter( 'edit_post_' . self::POST_TYPE[ 'page' ], [ $handler, 'set_custom_permalink' ], 10, 2 );
            }
        }
    }

    public static function set_post_uri( $post_id, $custom_permalink )
    {
        if ( self::check_front_page( $post_id ) )
        {
            return false;
        }

        $permalink_manager_uris = get_option( 'permalink-manager-uris' );

        // LegalDebug::debug( [
        //     'ToolPermalink' => 'get_post_uri',

        //     'post_id' => $post_id,

        //     'permalink_manager_uris' => $permalink_manager_uris,
        // ] );

        if ( $permalink_manager_uris )
        {
            // if ( ! empty( $permalink_manager_uris[ $post_id ] ) )
            // {
                // LegalDebug::debug( [
                //     'ToolPermalink' => 'get_post_uri',

                //     'permalink_manager_uris' => $permalink_manager_uris[ $post_id ],
                // ] );

                $permalink_manager_uris[ $post_id ] = $custom_permalink;

                update_option( 'permalink-manager-uris', $permalink_manager_uris );

                return true;
            // }
        }

        return false;
    }

    public static function set_custom_permalink( $post_id, $post )
    {
        $post_moved_id = MultisiteMeta::get_post_moved_id( $post_id );

        $main_blog_id = MultisiteBlog::get_main_blog_id();

        MultisiteBlog::set_blog( $main_blog_id );

        $custom_permalink = self::get_post_uri( $post_moved_id );

        MultisiteBlog::restore_blog();

        if ( !empty( $custom_permalink ) )
        {
            self::set_post_uri( $post_id, $custom_permalink );
        }

        LegalDebug::die( [
            'ToolPermalink' => 'set_custom_permalink',

            'post_id' => $post_id,

            'post_moved_id' => $post_moved_id,

            'custom_permalink' => $custom_permalink,
        ] );
    }

    public static function check_front_page( $post_id )
    {
		$front_page_id = get_option( 'page_on_front' );

        // LegalDebug::debug( [
        //     'ToolPermalink' => 'check_front_page',

        //     'post_id' => $post_id,

        //     'front_page_id' => $front_page_id,
        // ] );
		
        return ( ! empty( $front_page_id ) && $post_id == $front_page_id ) ? true : false;
	}

    public static function get_post_uri( $post_id )
    {
        if ( self::check_front_page( $post_id ) )
        {
            return '';
        }

        $permalink_manager_uris = get_option( 'permalink-manager-uris' );

        // LegalDebug::debug( [
        //     'ToolPermalink' => 'get_post_uri',

        //     'post_id' => $post_id,

        //     'permalink_manager_uris' => $permalink_manager_uris,
        // ] );

        if ( $permalink_manager_uris )
        {
            if ( ! empty( $permalink_manager_uris[ $post_id ] ) )
            {
                // LegalDebug::debug( [
                //     'ToolPermalink' => 'get_post_uri',

                //     'permalink_manager_uris' => $permalink_manager_uris[ $post_id ],
                // ] );

                return $permalink_manager_uris[ $post_id ];
            }
        }

        $post = get_post( $post_id );

        if ( $post )
        {
            // LegalDebug::debug( [
            //     'ToolPermalink' => 'get_post_uri',

            //     'post_name' => $post->post_name,
            // ] );

            return $post->post_name;
        }

        return '';
    }

    // public static function mc_permalink_manager_filter_query( $query, $old_query, $uri_parts, $pm_query, $content_type, $element_object )
    // {
    //     global $sitepress;

    //     $current_language = $sitepress->get_current_language();

    //     LegalDebug::debug( [
    //         'ToolPermalink' => 'mc_permalink_manager_filter_query',

    //         'current_language' => $current_language,

    //         'query' => $query,

    //         'old_query' => $old_query,

    //         'uri_parts' => $uri_parts,

    //         'pm_query' => $pm_query,

    //         'content_type' => $content_type,

    //         'element_object' => $element_object->ID,
    //     ] );

    //     // $uri_parts[ 'lang' ] = 'eng';

    //     // $pm_query[ 'lang' ] = 'eng';

    //     return $query;
    // }

    // public static function wpse_101072_flatten_hierarchies( $post_link, $post )
    // {
    //     if ( $post->ID != 318095 )
    //         return $post_link;
    
    //     $uri = '';
        
    //     foreach ( $post->ancestors as $parent ) {
    //         $uri = get_post( $parent )->post_name . "/" . $uri;
    //     }
    
    //     return str_replace( $uri, '', $post_link );
    // }
}

?>
<?php

class ToolPermalink
{
    public static function register_functions()
    {
        $handler = new self();

        // add_filter( 'post_type_link', [ $handler, 'wpse_101072_flatten_hierarchies' ], 10, 2 );

        // apply_filters( 'permalink_manager_filter_query', $query, $old_query, $uri_parts, $pm_query, $content_type, $element_object )
        
        add_filter( 'permalink_manager_filter_query', [ $handler, 'mc_permalink_manager_filter_query' ], 10, 6 );
    }

    public static function mc_permalink_manager_filter_query( $query, $old_query, $uri_parts, $pm_query, $content_type, $element_object )
    {
        global $sitepress;

        $current_language = $sitepress->get_current_language();

        LegalDebug::debug( [
            'ToolPermalink' => 'mc_permalink_manager_filter_query',

            'current_language' => $current_language,

            'query' => $query,

            'old_query' => $old_query,

            'uri_parts' => $uri_parts,

            'pm_query' => $pm_query,

            'content_type' => $content_type,

            'element_object' => $element_object->ID,
        ] );

        // $uri_parts[ 'lang' ] = 'eng';

        $pm_query[ 'lang' ] = 'eng';

        return $query;
    }

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
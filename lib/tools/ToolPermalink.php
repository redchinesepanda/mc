<?php

class ToolPermalink
{
    public static function register()
    {
        $handler = new self();

        // add_filter( 'post_type_link', [ $handler, 'wpse_101072_flatten_hierarchies' ], 10, 2 );
    }

    public static function wpse_101072_flatten_hierarchies( $post_link, $post )
    {
        if ( $post->ID != 318095 )
            return $post_link;
    
        $uri = '';
        
        foreach ( $post->ancestors as $parent ) {
            $uri = get_post( $parent )->post_name . "/" . $uri;
        }
    
        return str_replace( $uri, '', $post_link );
    }
}

?>
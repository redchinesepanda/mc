<?php

class ToolPosts
{
    const CSV = WP_CONTENT_DIR . '/uploads/csv/posts.csv';

    public static function register()
    {
        $handler = new self();

        // add_action( 'in_admin_footer', [ $handler, 'csv' ] );
    }

    public static function csv()
    {
        $fields = self::get_fields();

        $message['path'] = self::CSV;
        
        $file = fopen( self::CSV, 'w' );
        
        foreach ($fields as $field) {
            fputcsv( $file, $field );
        }
        
        fclose( $file );

        LegalDebug::debug( $message );
    }

    public static function get_fields()
    {
        $posts = self::get_posts();

        $args = [];

        foreach ( $posts as $post ) {
            $args[] = self::map( $post );
        }

        return $args;
    }
    
    public static function map( $post ) {
        $permalink = get_post_permalink($post->ID);

        return [
            $post->ID,

            $post->post_title,
            
            $post->post_name,

            $permalink,

            strpos( $permalink, $post->post_name ),
        ];
    }
    
    public static function get_posts()
    {
        $args = [
            'post_type' => [ 'post', 'page' ],

            'post_status' => 'publish',

            'posts_per_page' => -1,

            'ignore_sticky_posts' => true,
        ];

        return get_posts( $args );
    }
}

?>
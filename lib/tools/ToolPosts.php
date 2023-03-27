<?php

class ToolPosts
{
    // const CSV = WP_CONTENT_DIR . '/uploads/csv/posts.csv';

    public static function register()
    {
        $handler = new self();

        add_action( 'in_admin_footer', [ $handler, 'csv' ] );
    }

    public static function csv()
    {
        $fields = self::get_fields();

    
        $upload_dir = wp_upload_dir();
        
        $csv = $upload_dir['path'] . '/uploads/csv/posts.csv';

        $message['path'] = $csv;
        
        $fp = fopen( $csv, 'w' );
        
        // foreach ($fields as $field) {
        //     fputcsv($fp, $field);
        // }
        
        fclose($fp);

        self::debug( $message );
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
        return [
            $post->ID,

            $post->post_title,
            
            $post->post_name,

            get_post_permalink($post->ID)
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

    public static function debug( $message )
    {
        echo '<pre>ToolPosts::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>
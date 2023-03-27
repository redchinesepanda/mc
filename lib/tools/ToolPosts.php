<?php

class ToolPosts
{
    public static function register()
    {
        $handler = new self();

        add_action( 'admin_init', [ $handler, 'csv' ] );
    }

    public static function csv()
    {
        $fields = self::get_fields();

        $message['path'] = Template::LEGAL_PATH . 'posts.csv';
        
        // $fp = fopen( Template::LEGAL_PATH . 'posts.csv', 'w' );
        
        // foreach ($fields as $field) {
        //     fputcsv($fp, $field);
        // }
        
        // fclose($fp);

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
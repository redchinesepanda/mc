<?php

class YoastMain
{
    public static function get()
    {
        $message['function'] = 'get';

        $post = get_post();

        $args['title'] = YoastSEO()->meta->for_post( $post->ID )->title;

        $args['description'] = YoastSEO()->meta->for_post( $post->ID )->description;

        $message['args'] = $args;

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
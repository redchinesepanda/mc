<?php

class YoastMain
{
    public static function get()
    {
        $message['function'] = 'get';

        $post = get_post();

        $message['get_title'] = YoastSEO()->meta->for_post( $post->ID )->title;

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
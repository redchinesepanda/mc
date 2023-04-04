<?php

class YoastMain
{
    public static function get()
    {
        $message['function'] = 'get';

        $message['get_title'] = YoastSEO()->meta->for_post( POST_ID )->title;

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
<?php

class YoastMain
{
    public static function get()
    {
        $message['function'] = 'get';

        $Title_Presenter = new Title_Presenter();

        $message['get_title'] = $Title_Presenter->get_title();

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
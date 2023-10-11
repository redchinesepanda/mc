<?php

class LegalDebug
{
    public static function check()
    {
        $permission = false;

        $current_user = wp_get_current_user();

        if( $current_user->exists() ){
            if ( $current_user->user_login == 'redchinesepanda' ) {
                $permission = true;
            }
        }

        return $permission;
    }

    public static function debug( $message )
    {
        // if ( self::check() )
        // {
            echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' . PHP_EOL );
        // }
        
    }

    public static function die( $message )
    {
        // if ( self::check() )
        // {
            wp_die ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' . PHP_EOL );
        // }
        
    }
}

?>
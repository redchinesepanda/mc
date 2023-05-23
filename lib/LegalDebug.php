<?php

class LegalDebug
{
    public static function debug( $message )
    {
        $permission = false;

        $current_user = wp_get_current_user();

        if( $current_user->exists() ){
            if ( $current_user->user_login == 'redchinesepanda' ) {
                $permission = true;
            }
        }

        // if( current_user_can( 'administrator' ) ) {

        if( $permission ) {
            echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
        }
        
    }
}

?>
<?php

class LegalDebug
{
    public static function debug( $message )
    {
        if( current_user_can( 'administrator' ) ) {
            echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
        }
        
    }
}

?>
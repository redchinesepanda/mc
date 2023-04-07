<?php

class BilletBonus
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php';
    
    private static function get_bonus( $billet )
    {
        // $message['function'] = 'get_bonus';

        // $message['billet'] = $billet;

        if ( !empty( $billet['bonus'] ) ) {
            $args = BilletMain::href( $billet['url']['bonus'] );

            $args['title'] = $billet['bonus']['title'];

            $args['description'] = $billet['bonus']['description'];
            
            // $message['args'] = $args;

            // self::debug( $message );

            return $args;
        }

        // self::debug( $message );

        return [];
    }

    public static function get( $billet )
    {
        // $message['function'] = 'get';

        $enabled = true;

        if ( !empty( $billet['filter'] ) ) {
            $enabled = $billet['filter']['bonus'];
        }

        // $message['enabled'] = ( $enabled ? 'true' : 'false' );

        // self::debug( $message );

        if ( $enabled ) {
            return self::get_bonus( $billet );
        }

        return [];
    }

    public static function render( $billet )
    {
        // $message['function'] = 'render';

        $args = self::get( $billet );

        // $message['args'] = $args;

        // self::debug( $message );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE, false, $args );
        }
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
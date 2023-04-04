<?php

class BilletBonus
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php';
    
    private static function get_bonus( $billet )
    {
        $message['function'] = 'get_bonus';
        
        // $args = BilletMain::href( $billet['url']['bonus'] );

        // $args['label'] = get_field( 'billet-play-bonus-title', $billet['id'] );

        // $args['description'] = get_field( 'billet-play-bonus-description', $billet['id'] );

        if ( !empty( $billet['bonus'] ) ) {
            $args = BilletMain::href( $billet['bonus']['url'] );

            $args['label'] = $billet['bonus']['title'];

            $args['description'] = $billet['bonus']['description'];
            
            $message['args'] = $args;

            self::debug( $message );

            return $args;
        }

        self::debug( $message );

        return [];
    }

    public static function get( $billet )
    {
        $message['function'] = 'get';

        $message['billet'] = $billet;

        $enabled = true;

        if ( !empty( $billet['compilation'] ) ) {
            $enabled = $billet['compilation']['bonus'];
        }

        $message['enabled'] = ( $enabled ? 'true' : 'false' );

        self::debug( $message );

        if ( $enabled ) {
            return self::get_bonus( $billet );
        }

        return [];
    }

    public static function render( $billet )
    {
        $args = self::get( $billet );

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
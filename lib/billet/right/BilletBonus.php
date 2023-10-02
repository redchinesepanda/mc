<?php

class BilletBonus
{
    private static function get_bonus( $billet )
    {
        if ( !empty( $billet[ 'bonus' ] ) ) {
            $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

            $args[ 'title' ] = $billet[ 'bonus' ][ 'title' ];

            $args[ 'description' ] = $billet[ 'bonus' ][ 'description' ];

            return $args;
        }

        return [];
    }

    public static function get( $billet )
    {
        LegalDebug::debug( [
            'function' => 'BilletBonus::get',

            'billet' => $billet,
        ] );

        $enabled = true;

        if ( !empty( $billet[ 'filter' ] ) ) {
            $enabled = $billet[ 'filter' ][ 'bonus' ];
        }

        if ( $enabled ) {
            return self::get_bonus( $billet );
        }

        return [];
    }

    const TEMPLATE = [
        'bonus' => LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php',
    ];

    public static function render( $billet )
    {
        $args = self::get( $billet );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE[ 'bonus' ], false, $args );
        }
    }
}

?>
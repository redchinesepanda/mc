<?php

class BilletProfit
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-profit.php';

    public static function get_profit( $id )
    {
        $args['class'] = get_field( 'billet-play-profit-type', $id );

        $args['label'] = __( 'Margin', ToolLoco::TEXTDOMAIN );

        $args['value'] = get_field( 'billet-play-profit-value', $id );

        self::debug( [
            'profit' => get_field( 'billet-play-profit-value', $id ),
        ] );

        return $args;
    }

    public static function get( $billet )
    {
        $args = [];

        $enabled = true;

        if ( !empty( $billet[ 'filter' ] ) ) {
            $enabled = $billet['filter']['profit'];
        }

        if ( $enabled ) {
            $args['profit'] = self::get_profit( $billet['id'] );
        }

        return $args;
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
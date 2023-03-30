<?php

class BilletProfit
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-profit.php';

    public static function get( $id )
    {
        $args['class'] = get_field( 'billet-play-profit-type', $id );

        $args['label'] = __( 'Margin', 'Thrive' );

        $args['value'] = get_field( 'billet-play-profit-value', $id );

        return $args;
    }

    public static function render( $id )
    { 
        load_template( self::TEMPLATE, false, self::get( $id ) );
    }
}

?>
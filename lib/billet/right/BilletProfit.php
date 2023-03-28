<?php

class BilletProfit
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus-profit.php';

    public static function get()
    {
        $args['class'] = get_field( 'billet-play-profit-type' );

        $args['label'] = __( 'Margin', 'Thrive' );

        $args['value'] = get_field( 'billet-play-profit-value' );

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
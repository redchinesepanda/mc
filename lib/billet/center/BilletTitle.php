<?php

class BilletTitle
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-title.php';

    public static function get( $billet )
    {
        $args['id'] = $billet['id'];

        $args['href'] = $billet['url']['title'];

        $args['class'] = BilletMain::disabled( $billet['url']['title'] );

        $args['label'] = get_field( 'billet-title-text', $billet['id'] );

        $args['rating'] = get_field( 'billet-title-rating', $billet['id'] );

        return $args;
    }

    public static function render( $billet )
    {
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>
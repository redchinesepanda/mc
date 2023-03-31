<?php

class BilletTitle
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-title.php';

    const ORDER_VALUE = 'legal-title';

    public static function get( $billet )
    {
        $args = BilletMain::href( $billet['url']['title'] );

        $args['order'] = self::ORDER_VALUE;

        $args['achievement'] = BilletAchievement::TYPE_IMAGE;

        $args['rating'] = get_field( 'billet-title-rating', $billet['id'] );

        if ( array_key_exists( 'compilation', $billet ) ) {
            $args['order'] = $billet['compilation']['order'];

            $args['achievement'] = $billet['compilation']['achievement'];

            if ( !$billet['compilation']['rating'] ) {
                $args['rating'] = 0;
            }
        }

        $args['id'] = $billet['id'];

        $args['label'] = get_field( 'billet-title-text', $billet['id'] );

        return $args;
    }

    public static function render( $billet )
    {
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>
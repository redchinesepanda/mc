<?php

class BilletTitle extends LegalDebug
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-title.php';

    const ORDER_TYPE = 'legal-title';

    public static function get( $billet )
    {
        $args = BilletMain::href( $billet['url']['title'] );

        $args['id'] = $billet['id'];

        $args['order'] = ( !empty( $billet['filter']['order'] ) ? $billet['filter']['order'] : self::ORDER_TYPE );

        $args['achievement'] = ( !empty( $billet['filter']['achievement'] ) ? $billet['filter']['achievement'] : BilletAchievement::TYPE_IMAGE );

        $args['rating'] = ( !empty( $billet['filter']['rating'] ) ? get_field( 'billet-title-rating', $billet['id'] ) : 0 );

        $args['label'] = get_field( 'billet-title-text', $billet['id'] );

        self::debug( [
            'rating' => get_field( 'billet-title-rating', $billet['id'] ),
        ] );

        return $args;
    }

    public static function render( $billet )
    {
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>
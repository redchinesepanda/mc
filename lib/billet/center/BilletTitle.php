<?php

class BilletTitle
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-title.php';

    const ORDER_VALUE = 'legal-title';

    // const ACHIEVEMENT_IMAGE = 'legal-image';

    // const ACHIEVEMENT_BACKGROUND = 'legal-background';

    public static function get( $billet )
    {
        $args = BilletMain::href( $billet['url']['title'] );

        $args['order'] = self::ORDER_VALUE;

        // $args['achievement'] = self::ACHIEVEMENT_IMAGE;

        if ( array_key_exists( 'compilation', $billet ) ) {
            $args['order'] = $billet['compilation']['order'];

            // $args['achievement'] = $billet['compilation']['achievement'];
        }

        $args['id'] = $billet['id'];

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
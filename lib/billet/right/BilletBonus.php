<?php

class BilletBonus
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php';
    
    private static function get_bonus( $billet )
    {
        // $args = BilletMain::href( $billet['url']['bonus'] );

        // $args['label'] = get_field( 'billet-play-bonus-title', $billet['id'] );

        // $args['description'] = get_field( 'billet-play-bonus-description', $billet['id'] );

        if ( !empty( $billet['bonus'] ) ) {
            $args = BilletMain::href( $billet['bonus']['url'] );

            $args['label'] = $billet['bonus']['title'];

            $args['description'] = $billet['bonus']['description'];

            return $args;
        }

        return [];
    }

    public static function get( $billet )
    {
        $args = [];

        $enabled = true;

        if ( !empty( $billet['compilation'] ) ) {
            $enabled = $billet['compilation']['bonus'];
        }

        if ( $enabled ) {
            $args['bonus'] = self::get_bonus( $billet );
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
}

?>
<?php

class BilletSpoilerButton
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-spoiler-button.php';

    private static function get_spoiler()
    {
        $args['open'] = __( 'More Details', 'Thrive' );

        $args['close'] = __( 'Close Details', 'Thrive' );

        return $args;
    }

    public static function get( $billet )
    {
        $args = [];

        $enabled = true;

        if ( array_key_exists( 'compilation', $billet ) ) {
            $enabled = $billet['compilation']['spoiler'];
        }

        if ( $enabled ) {
            $args['spoiler'] = self::get_spoiler( $billet['id'] );
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
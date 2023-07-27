<?php

class BilletSpoilerButton
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-spoiler-button.php';

    private static function get_spoiler()
    {
        $args['open'] = __( BilletMain::TEXT[ 'more-details' ], ToolLoco::TEXTDOMAIN );

        $args['close'] = __( BilletMain::TEXT[ 'close-details' ], ToolLoco::TEXTDOMAIN );

        return $args;
    }

    public static function get( $billet )
    {
        $args = [];

        $enabled = true;

        if ( !empty( $billet['filter'] ) ) {
            $enabled = $billet['filter']['spoiler'];
        }

        if ( $enabled ) {
            $args['id'] = $billet['id'];

            $args['spoiler'] = self::get_spoiler();
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
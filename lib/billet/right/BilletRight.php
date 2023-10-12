<?php

require_once( 'BilletBonus.php' );

require_once( 'BilletMobile.php' );

require_once( 'BilletProfit.php' );

require_once( 'BilletSpoilerButton.php' );

class BilletRight
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-right.php';
    
    private static function get_play( $billet )
    {
        $args = BilletMain::href( $billet['url']['play'] );
        
        $args['label'] = __( BilletMain::TEXT[ 'bet-now' ], ToolLoco::TEXTDOMAIN );

        if ( !empty( $billet['filter']['play']['label'] ) ) {
            $args['label'] = $billet['filter']['play']['label'];
        }

        return $args;
    }

    private static function get_license( $billet )
    {
        LegalDebug::debug( [
            'function' => 'BilletRight::get_license',

            $billet[ 'filter' ],
        ] );

        if ( !empty( $billet[ 'filter' ][ 'license' ] ) )
        {
            return [
                'label' => __( BilletMain::TEXT[ 'no-license' ], ToolLoco::TEXTDOMAIN ),
            ];
        }

        return [];
    }

    public static function get( $billet )
    {
        return [
            'id' => $billet['id'],

            'url' => $billet['url'],

            'bonus' => $billet['bonus'],

            'play' => self::get_play( $billet ),

            'license' => self::get_license( $billet ),

            'filter' => ( !empty( $billet['filter'] ) ? $billet['filter'] : [] ),
        ];
    }

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>
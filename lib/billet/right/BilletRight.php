<?php

require_once( 'BilletBonus.php' );

require_once( 'BilletMobile.php' );

require_once( 'BilletProfit.php' );

require_once( 'BilletSpoilerButton.php' );

class BilletRight
{
    const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-right.php',

        'new' => LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-right-new.php',
    ];
    
  /*   private static function get_footer_control()
    {
        return [
            'default' => __( BilletMain::TEXT[ 'show-tnc' ], ToolLoco::TEXTDOMAIN ),

            'active' => __( BilletMain::TEXT[ 'hide-tnc' ], ToolLoco::TEXTDOMAIN ),
        ];
    } */

    private static function get_play( $billet )
    {
        $args = BilletMain::href( $billet['url']['play'] );

        $args[ 'nofollow' ] = $billet[ 'url' ][ 'play-nofollow' ];
        
        $args['label'] = __( BilletMain::TEXT[ 'bet-now' ], ToolLoco::TEXTDOMAIN );

        if ( !empty( $billet['filter']['play']['label'] ) ) {
            $args['label'] = $billet['filter']['play']['label'];
        }

        return $args;
    }

    private static function get_license( $billet )
    {
        // LegalDebug::debug( [
        //     'function' => 'BilletRight::get_license',

        //     $billet[ 'filter' ],
        // ] );

        if ( !empty( $billet[ 'filter' ][ 'no-license' ] ) )
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

            // 'footer-control' => self::get_footer_control(),

            'filter' => ( !empty( $billet['filter'] ) ? $billet['filter'] : [] ),
        ];
    }

    // public static function render( $billet )
    // { 
    //     load_template( self::TEMPLATE[ 'main' ], false, self::get( $billet ) );
    // }

    public static function render( $billet )
    { 
        if ( TemplateMain::check_new() )
        {
            return self::render_main( self::TEMPLATE[ 'new' ], self::get( $billet ) );
        }

        return self::render_main( self::TEMPLATE[ 'main' ], self::get( $billet ) );
    }

    public static function render_main( $template, $args )
    {
		ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
<?php

class BilletLogo
{
    const DEFAULT_LOGO = LegalMain::LEGAL_URL . '/assets/img/legal-blank.svg';

    const ORDER_VALUE = 'legal-logo';

    const FIELD = [
        'about' => 'review-about',
    ];

    const ABOUT = [
        'font' => 'about-font',

        'logo' => 'about-logo',

        'mega' => 'about-logo-mega',
    ];

    public static function get_logo( $id )
    {
        $src = self::DEFAULT_LOGO;

        $group = get_field( self::FIELD[ 'about' ], $id );

        LegalDebug::debug( [
            'group' => $group,
        ] );

        if ( $group )
        {
            if ( !empty( $group[ self::ABOUT[ 'logo' ] ] ) )
            {
                $src = $group[ self::ABOUT[ 'logo' ] ];
            }
        }
    }

    public static function get( $billet )
    {
        $font = '';

        $src = self::DEFAULT_LOGO;

        $group = get_field( self::FIELD[ 'about' ], $billet['id'] );

        if ( $group )
        {
            $font = $group[ self::ABOUT[ 'font' ] ];

            if ( !empty( $group[ self::ABOUT[ 'logo' ] ] ) )
            {
                $src = $group[ self::ABOUT[ 'logo' ] ];
            }
        }

        $args['review'] = BilletMain::href( $billet['url']['review'] );

        $args['review']['label'] = ( !empty( $billet['filter']['review']['label'] ) ? $billet['filter']['review']['label'] : __( BilletMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ) );

        // $args['review'][ 'font' ] = get_field( 'billet-font', $billet['id'] );

        $args['review'][ 'font' ] = $font;

        $args['index'] = $billet['index'];

        $args['order'] = ( !empty( $billet['filter']['order'] ) ? $billet['filter']['order'] : self::ORDER_VALUE );

        $args['logo'] = BilletMain::href( $billet['url']['logo'] );

        // $src = get_field( 'billet-logo-url', $billet['id'] );

        // $args['logo']['src'] = ( !empty( $src ) ? $src : self::DEFAULT_LOGO );

        $args['logo']['src'] = $src;

        return $args;
    }

    const TEMPLATE = [
        'logo' => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-logo.php'
    ];

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE[ 'logo' ], false, self::get( $billet ) );
    }
}

?>
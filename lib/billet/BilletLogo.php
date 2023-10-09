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

        'title' => 'about-title',
    ];

    public static function get( $billet )
    {
        $font = '';

        $src = self::DEFAULT_LOGO;

        $alt = 'bookmaker logo';

        $group = get_field( self::FIELD[ 'about' ], $billet['id'] );

        if ( $group )
        {
            $font = $group[ self::ABOUT[ 'font' ] ];

            if ( !empty( $group[ self::ABOUT[ 'logo' ] ] ) )
            {
                $src = $group[ self::ABOUT[ 'logo' ] ];

                $alt = $group[ self::ABOUT[ 'title' ] ] . ' logo';
            }
        }

        $args['review'] = BilletMain::href( $billet['url']['review'] );

        $args['review']['label'] = ( !empty( $billet['filter']['review']['label'] ) ? $billet['filter']['review']['label'] : __( BilletMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ) );

        // $args['review'][ 'font' ] = get_field( 'billet-font', $billet['id'] );

        $args['review'][ 'font' ] = $font;

        $args['index'] = $billet['index'];

        $args['order'] = ( !empty( $billet['filter']['order'] ) ? $billet['filter']['order'] : self::ORDER_VALUE );

        $args['logo'] = BilletMain::href( $billet['url']['logo'] );

        $args['logo']['src'] = $src;

        $args['logo']['alt'] = $alt;

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
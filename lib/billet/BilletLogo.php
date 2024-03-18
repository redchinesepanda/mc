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

        'square' => 'about-logo-square',

        'title' => 'about-title',
    ];

    // $billet['id']

    // $billet['index']

    // $billet['url']['review']

    // $billet['url']['logo']

    // $billet[ 'url' ][ 'logo-nofollow' ]

    // $billet['filter']['review']['label']

    // $billet['filter']['order']

    public static function get_logo( $id, $index, $url, $filter )
    {
        $font = '';

        $src = self::DEFAULT_LOGO;

        $alt = 'bookmaker logo';

        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            $font = $group[ self::ABOUT[ 'font' ] ];

            $alt = $group[ self::ABOUT[ 'title' ] ] . ' logo';
        }

        if ( $brand_src = BrandMain::get_logo_billet( $id ) )
        {
            $src = $brand_src;
        }
        else
        {
            if ( $group )
            {
                if ( TemplateMain::check_new() )
                {
                    if ( !empty( $group[ self::ABOUT[ 'square' ] ] ) )
                    {
                        $src = $group[ self::ABOUT[ 'square' ] ];
                    }
                    else
                    {
                        if ( !empty( $group[ self::ABOUT[ 'logo' ] ] ) )
                        {
                            $src = $group[ self::ABOUT[ 'logo' ] ];
                        }
                    }
                }
                else
                {
                    if ( !empty( $group[ self::ABOUT[ 'logo' ] ] ) )
                    {
                        $src = $group[ self::ABOUT[ 'logo' ] ];

                    }
                }
            }
        }

        $args['review'] = BilletMain::href( $url['review'] );

        $args['review']['label'] = ( !empty( $filter['review']['label'] ) ? $filter['review']['label'] : __( BilletMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ) );

        $args['review'][ 'font' ] = $font;

        $args['index'] = $index;

        $args['order'] = ( !empty( $filter['order'] ) ? $filter['order'] : self::ORDER_VALUE );

        $args['logo'] = BilletMain::href( $url['logo'] );

        $args[ 'logo' ][ 'nofollow' ] = $url[ 'logo-nofollow' ];

        $args['logo']['src'] = $src;

        $args['logo']['alt'] = $alt;

        // LegalDebug::debug( [
        //     'BilletLogo' => 'get_logo',

        //     'id' => $id,

        //     'index' => $index,

        //     'url' => $url,

        //     'filter' => $filter,
        // ] );

        return $args;
    }
    public static function get( $billet )
    {
        // $font = '';

        // $src = self::DEFAULT_LOGO;

        // $alt = 'bookmaker logo';

        // $group = get_field( self::FIELD[ 'about' ], $billet['id'] );

        // if ( $group )
        // {
        //     $font = $group[ self::ABOUT[ 'font' ] ];

        //     if ( !empty( $group[ self::ABOUT[ 'logo' ] ] ) )
        //     {
        //         $src = $group[ self::ABOUT[ 'logo' ] ];

        //         $alt = $group[ self::ABOUT[ 'title' ] ] . ' logo';
        //     }
        // }

        // $args['review'] = BilletMain::href( $billet['url']['review'] );

        // $args['review']['label'] = ( !empty( $billet['filter']['review']['label'] ) ? $billet['filter']['review']['label'] : __( BilletMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ) );

        // $args['review'][ 'font' ] = $font;

        // $args['index'] = $billet['index'];

        // $args['order'] = ( !empty( $billet['filter']['order'] ) ? $billet['filter']['order'] : self::ORDER_VALUE );

        // $args['logo'] = BilletMain::href( $billet['url']['logo'] );

        // $args[ 'logo' ][ 'nofollow' ] = $billet[ 'url' ][ 'logo-nofollow' ];

        // $args['logo']['src'] = $src;

        // $args['logo']['alt'] = $alt;

        // // LegalDebug::debug( [
        // //     'function' => 'BilletLogo::get',

        // //     'billet' => $billet,

        // //     'args' => $args,
        // // ] );

        // return $args;

        // LegalDebug::debug( [
        //     'BilletLogo' => 'get',

        //     '$billet' => $billet,
        // ] );

        return self::get_logo( $billet[ 'id' ], $billet[ 'index' ], $billet[ 'url' ], $billet[ 'filter' ] );
    }

    const TEMPLATE = [
        'logo' => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-logo.php'
    ];

    public static function render( $logo )
    { 
        // return self::render_main( self::TEMPLATE[ 'logo' ], self::get( $billet ) );

        return LegalComponents::render_main( self::TEMPLATE[ 'logo' ], $logo );
    }

    // public static function render_logo( $logo )
    // { 
    //     return self::render_main( self::TEMPLATE[ 'logo' ], $logo );
    // }

    public static function render_main( $template, $args )
    {
		ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
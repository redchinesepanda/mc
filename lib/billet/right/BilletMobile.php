<?php

class BilletMobile
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-mobile.php';

    public static function prepare_mobile( $id )
    {
        $args['iphone'] = BilletMain::href( get_field( 'billet-play-mobile-iphone', $id ) );

        $args['android'] = BilletMain::href( get_field( 'billet-play-mobile-android', $id ) );

        $args['site'] = BilletMain::href( get_field( 'billet-play-mobile-site', $id ) );

        return $args;
    }

    public static function get( $billet )
    {
        return self::get_mobile( $billet[ 'id' ], $billet[ 'filter' ] );
    }

    public static function get_mobile( $id, $filter )
    {
        $args = [];

        $enabled = true;

        if ( !empty( $filter ) ) {
            $enabled = $filter[ 'mobile' ];
        }

        if ( $enabled ) {
            $args[ 'mobile' ] = self::prepare_mobile( $id );
        }

        return $args;
    }

    public static function render( $billet )
    {
        // $args = self::get( $billet );

        // if ( !empty( $args ) ) {
        //     load_template( self::TEMPLATE, false, $args );
        // }

        return LegalComponents::render_main( self::TEMPLATE, self::get( $billet ) );
    }

    public static function render_mobile( $mobile )
    {
        if ( empty( $mobile ) )
        {
            return '';    
        }

        return LegalComponents::render_main( self::TEMPLATE, $mobile );
    }

    // public static function render_main( $template, $args )
    // {
	// 	ob_start();

    //     load_template( $template, false, $args );

    //     $output = ob_get_clean();

    //     return $output;
    // }
}

?>
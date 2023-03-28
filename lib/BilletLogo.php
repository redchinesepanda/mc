<?php

class BilletLogo
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-logo.php';

    const DEFAULT_LOGO = Template::LEGAL_URL . '/assets/img/legal-blank.svg';

    public static function get( $billet )
    {
        $args['logo'] = self::href( $billet['url']['logo'] );

        $args['logo']['src'] = get_the_post_thumbnail_url( $billet['id'] );

        if ( $args['logo']['src'] === false ) {
            $args['logo']['src'] = self::DEFAULT_LOGO;
        }

        $args['review'] = self::href( $billet['url']['review'] );

        $args['review']['label'] = get_field( 'billet-button-review' );

        return $args;
    }

    public static function href( $url )
    {
        $args['href'] = url;

        $args['class'] = self::disabled( url );

        return $args;
    }

    public static function disabled( $url )
    {
        return ( $url == '' ? 'legal-disabled' : '' );
    }

    public static function render( $billet = [] )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>
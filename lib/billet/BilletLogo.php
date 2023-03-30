<?php

class BilletLogo
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-logo.php';

    const DEFAULT_LOGO = LegalMain::LEGAL_URL . '/assets/img/legal-blank.svg';

    public static function get( $billet )
    {
        $args['order'] = 'legal-logo';

        if ( array_key_exists( 'compilation', $billet ) ) {
            $args['order'] = $billet['compilation']['order'];
        }

        $args['logo'] = BilletMain::href( $billet['url']['logo'] );

        $args['logo']['src'] = get_the_post_thumbnail_url( $billet['id'] );

        if ( $args['logo']['src'] === false ) {
            $args['logo']['src'] = self::DEFAULT_LOGO;
        }

        $args['review'] = BilletMain::href( $billet['url']['review'] );

        $args['review']['label'] = get_field( 'billet-button-review', $billet['id'] );

        return $args;
    }

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>
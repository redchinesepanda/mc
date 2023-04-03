<?php

class BilletLogo
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-logo.php';

    const DEFAULT_LOGO = LegalMain::LEGAL_URL . '/assets/img/legal-blank.svg';

    const ORDER_VALUE = 'legal-logo';

    public static function get( $billet )
    {
        // $message['billet'] = $billet;

        $args['order'] = self::ORDER_VALUE;

        $args['review'] = BilletMain::href( $billet['url']['review'] );

        $args['review']['label'] = get_field( 'billet-button-review', $billet['id'] );

        if ( array_key_exists( 'compilation', $billet ) ) {
            $args['order'] = $billet['compilation']['order'];

            if ( !empty( $billet['compilation']['review'] ) ) {
                $args['review'] = BilletMain::href( $billet['url']['review'] );

                $args['review']['label'] = $billet['compilation']['review']['label'];
            }
        }

        $args['logo'] = BilletMain::href( $billet['url']['logo'] );

        $args['logo']['src'] = get_the_post_thumbnail_url( $billet['id'] );

        if ( $args['logo']['src'] === false ) {
            $args['logo']['src'] = self::DEFAULT_LOGO;
        }

        // self::debug( $message );

        return $args;
    }

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
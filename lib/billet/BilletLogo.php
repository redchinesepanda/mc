<?php

class BilletLogo
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-logo.php';

    const DEFAULT_LOGO = LegalMain::LEGAL_URL . '/assets/img/legal-blank.svg';

    const ORDER_VALUE = 'legal-logo';

    public static function get( $billet )
    {
        // $message['billet'] = $billet;

        $args['order'] = ( !empty( $billet['compilation']['order'] ) ? $billet['compilation']['order'] : self::ORDER_VALUE );

        // $args['review'] = ( !empty( $billet['compilation']['review']['type'] ) ? BilletMain::href( $billet['url']['bonus'] ) : BilletMain::href( $billet['url']['review'] ) );

        $args['review'] = BilletMain::href( $billet['url']['review'] );

        $args['review']['label'] = ( !empty( $billet['compilation']['review']['label'] ) ? $billet['compilation']['review']['label'] : __( 'Review', ToolLoco::TEXTDOMAIN ) );

        $args['logo'] = BilletMain::href( $billet['url']['logo'] );

        $src = get_the_post_thumbnail_url( $billet['id'] );

        $args['logo']['src'] = ( $src !== false ? $src : self::DEFAULT_LOGO );

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
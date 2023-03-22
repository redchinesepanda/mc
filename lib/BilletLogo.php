<?php

class BilletLogo
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-logo.php';

    const DEFAULT_LOGO = Template::LEGAL_URL . '/assets/img/legal-blank.svg';

    public static function get()
    {
        $post = get_post();

        $args['logo'] = get_the_post_thumbnail_url( $post->ID );

        if ( $args['logo'] === false ) {
            $args['logo'] = self::DEFAULT_LOGO;
        }

        return $args;
    }

    public static function render( $url = [] )
    { 
        $args = self::get();

        if ( !empty( $url ) ) {
            $args['url'] = $url;
        }

        load_template( self::TEMPLATE, false, $args );
    }
}

?>
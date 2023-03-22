<?php

class BilletMain
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-main.php';

    const DEFAULT_COLOR = 'rgb(0,46,90)';

    const CSS = [
        'billet-main' => Template::LEGAL_URL . '/assets/css/billet-main.css',

        'billet-spoiler' => Template::LEGAL_URL . '/assets/css/billet-spoiler.css',
    ];

    public static function print()
    {
        foreach ( self::CSS as $key => $url ) {
            echo '<link id="' . $key . '" href="' . $url . '" rel="stylesheet" />';
        }
    }

    private static function get_url()
    {
        $referal_url = get_field( 'billet-referal-url' );

        $card_id = get_field( 'billet-card-id' );

        $card_url = '';
        
        if ( !empty( $card_id ) ) {
            $card_url = get_post_permalink( $card_id );
        }

        $oops = '#oops';

        $args['logo'] = ( $referal_url != '' ? $referal_url : ( $card_url !== false ? $card_url : '' ) );

        $args['review'] = ( $card_url !== false ? $card_url : '' );

        $args['title'] = ( $card_url !== false ? $card_url : ( $referal_url != '' ? $referal_url : '' ) );

        $args['bonus'] = ( $referal_url != '' ? $referal_url : ( $oops != '' ? $oops : '' ) );

        $args['play'] = $args['bonus'];

        return $args;
    }

    public static function get()
    {
        $post = get_post();

        $args['data']['id'] = $post->ID;

        $args['selector'] = 'billet-' . $post->ID;

        $args['color'] = get_field( 'billet-color' );

        if ( empty( $args['color'] ) ) {
            $args['color'] = self::DEFAULT_COLOR;
        }

        $args['url'] = self::get_url();

        $args['description'] = get_field( 'billet-description' );

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
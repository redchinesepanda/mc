<?php

require_once( 'BilletLogo.php' );

require_once( 'center/BilletTitle.php' );

require_once( 'center/BilletList.php' );

require_once( 'center/BilletAchievement.php' );

require_once( 'right/BilletRight.php' );

require_once( 'BilletSpoiler.php' );

class BilletMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-main.php';

    const DEFAULT_COLOR = 'rgb(0,46,90)';

    const CSS = [
        'billet-main' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-main.css',

        'billet-spoiler' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-spoiler.css',
    ];

    const JS = [
        'billet-spoiler' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-spoiler.js'
    ];

    public static function print()
    {
        foreach ( self::CSS as $key => $url ) {
            echo '<link id="' . $key . '" href="' . $url . '" rel="stylesheet" />';
        }
        
        foreach ( self::JS as $key => $src ) {
            echo '<script id="' . $key . '" src="' . $src . '"></script>';
        }
    }

    private static function get_url( $billet )
    {
        $referal_url = get_field( 'billet-referal-url', $billet['id'] );

        $card_id = get_field( 'billet-card-id', $billet['id'] );

        $card_url = '';
        
        if ( !empty( $card_id ) ) {
            $card_url = get_post_permalink( $card_id );
        }

        $bonus_url = get_field( 'billet-bonus-id', $billet['id'] );

        // $message['bonus_url'] = $bonus_url;

        $review_url = $card_url;
        if ( array_key_exists( 'compilation', $billet ) ) {
            if ( $billet['compilation']['review']['type'] == 'legal-bonus' ) {
                $review_url = $bonus_url;
            }
        }

        $oops = '#oops';

        $args['logo'] = ( $referal_url != '' ? $referal_url : ( $card_url !== false ? $card_url : '' ) );

        $args['review'] = ( $review_url !== false ? $review_url : '' );

        $args['title'] = ( $card_url !== false ? $card_url : ( $referal_url != '' ? $referal_url : '' ) );

        $args['bonus'] = ( $referal_url != '' ? $referal_url : ( $oops != '' ? $oops : '' ) );

        $args['play'] = $args['bonus'];

        // self::debug( $message );

        return $args;
    }

    private static function get_field_default( $id, $field, $value )
    {
        $result = get_field( $field, $id );

        if ( !empty( $result ) ) {
            return $result;
        }

        return $value;
    }

    private static function get_bonus( $id )
    {
        $bonus_id = get_field( 'billet-bonus', $id );

        if ( !empty( $bonus_id ) ) {
            $args['url'] = self::get_field_default( $bonus_id, 'billet-afillate-link', '/#oops' );

            $args['title'] = self::get_field_default( $bonus_id, 'billet-bonus-title', __( 'Not set', ToolLoco::TEXTDOMAIN ) );

            $args['description'] = self::get_field_default( $bonus_id, 'billet-bonus-description', __( 'Not set', ToolLoco::TEXTDOMAIN ) );

            return $args;
        }

        return [];
    }

    private static function get( $billet )
    {
        $id = 0;

        $args['index'] = 1;

        if ( !empty( $billet ) ) {
            $id = $billet['id'];

            $args['index'] = $billet['index'];

            if ( array_key_exists( 'compilation', $billet ) ) {
                $args['compilation'] = $billet['compilation'];
            }
        } else {
            $post = get_post();
    
            $id = $post->ID;
        }

        $args['id'] = $id;
        
        $args['url'] = self::get_url( $args );

        $args['bonus'] = self::get_bonus( $id );

        $args['selector'] = 'billet-' . $id;

        $args['color'] = self::get_color( $id );

        $args['description'] = get_field( 'billet-description', $id );

        return $args;
    }

    private static function get_color( $id )
    {
        $color = get_field( 'billet-color', $id );

        if ( empty( $color ) ) {
            $color = self::DEFAULT_COLOR;
        }

        return $color;
    }

    public static function disabled( $url )
    {
        return ( $url == '' ? 'legal-disabled' : '' );
    }

    public static function href( $url )
    {
        $args['href'] = $url;

        $args['class'] = self::disabled( $url );

        return $args;
    }

    public static function render( $billet = [] )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
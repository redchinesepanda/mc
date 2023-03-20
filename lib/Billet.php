<?php

class Billet
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet.php';

    const DEFAULT_LOGO = Template::LEGAL_PATH . '/assets/img/billet/legal-blank.svg';

    const DEFAULT_COLOR = 'rgb(0,46,90)';

    // public static function register()
    // {
    //     $handler = new self();

    //     add_action( 'wp_enqueue_scripts', [ $handler, 'register_script'] );
    // }

    // public function register_script()
    // {
	// 	wp_enqueue_style( 'billet', Template::LEGAL_URL . '/assets/css/billet.css' );
    // }

    public static function print()
    {
		echo '<link id="billet" href="' . Template::LEGAL_URL . '/assets/css/billet.css" rel="stylesheet" />';
    }

    public static function get()
    {
        $post = get_post();

        $args['selector'] = 'billet-' . $post->ID;

        $args['featured-image'] = get_the_post_thumbnail_url( $post->ID );

        if ( $args['featured-image'] === false ) {
            $args['featured-image'] = self::DEFAULT_LOGO;
        }

        $args['description'] = get_field( 'billet-description' );

        $args['color'] = get_field( 'billet-color' );

        if ( empty( $args['color'] ) ) {
            $args['color'] = self::DEFAULT_COLOR;
        }

        $referal-url = get_field( 'billet-referal-url' );

        $card_id = get_field( 'billet-card-id' );

        $card-url = get_post_permalink( $card_id );

        $oops = '#oops';

        $args['url']['logo'] = ( $referal-url != '' ? $referal-url : ( $card-url !== false ? $card-url : '' ) );

        $args['url']['review'] = ( $card-url !== false ? $card-url : '' );

        $args['url']['title'] = ( $card-url !== false ? $card-url : ( $referal-url != '' ? $referal-url : '' ) );

        $args['url']['bonus'] = ( $referal-url != '' ? $referal-url : ( $oops != '' ? $oops : '' ) );

        $args['url']['play'] = $args['url']['bonus'];

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
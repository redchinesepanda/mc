<?php

class BilletBonus
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-bonus.php';

    const STYLE = Template::LEGAL_URL . '/assets/css/billet-bonus.css';

    // public static function register()
    // {
    //     $handler = new self();

    //     add_action( 'wp_enqueue_scripts', [ $handler, 'register_script'] );
    // }

    // public function register_script()
    // {
	// 	wp_enqueue_style( 'billet',  BilletBonus::STYLE );
    // }

    public static function print()
    {
		echo '<link id="billet" href="' . BilletBonus::STYLE . '" rel="stylesheet" />';
    }
    

    public static function get()
    {
        $args['bonus-title'] = get_field( 'billet-play-bonus-title' );

        $args['bonus-url'] = get_field( 'billet-play-bonus-url' );

        $args['bonus-description'] = get_field( 'billet-play-bonus-description' );

        $args['mobile-iphone'] = get_field( 'billet-play-mobile-iphone' );
        
        $args['mobile-android'] = get_field( 'billet-play-mobile-android' );

        $args['profit-type'] = get_field( 'billet-play-profit-type' );

        $args['profit-value'] = get_field( 'billet-play-profit-value' );

        $args['bonus-button'] = __( 'Bet now', 'Thrive' );

        $args['spoiler-button'] = __( 'Spoiler', 'Thrive' );

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
<?php

class BilletTitle
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-title.php';

    const STYLE = Template::LEGAL_URL . '/assets/css/billet-title.css';

    // public static function register()
    // {
    //     $handler = new self();

    //     add_action( 'wp_enqueue_scripts', [ $handler, 'register_script'] );
    // }

    // public function register_script()
    // {
	// 	wp_enqueue_style( 'billet',  BilletTitle::STYLE );
    // }

    public static function print()
    {
		echo '<link id="billet" href="' . BilletTitle::STYLE . '" rel="stylesheet" />';
    }
    

    public static function get()
    {
        $args['billet-title-text'] = get_field( 'billet-title-text' );

        $args['billet-title-rating'] = get_field( 'billet-title-rating' );

        $args['billet-title-best'] = __( 'Leader in Hi-Tech Features', 'Thrive' );

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
<?php

class Billet
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet.php';

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

        $args['ID'] = $post->ID;

        $args['billet-selector'] = 'billet-' . $post->ID;

        $args['featured-image'] = get_the_post_thumbnail_url();

        $args['billet-description'] = get_field( 'billet-description' );

        $args['billet-color'] = get_field( 'billet-color' );

        $args['billet-url'] = get_field( 'billet-url' );

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
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
    
    private static function get_achievement() {
        $args = [];

        $post = get_post();

        $terms = wp_get_post_terms( $post->ID, 'billet_achievement', [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) ) {
            $term = $terms[0];
            
            $args['achievement-name'] = $term->name;

            $args['achievement-color'] = get_field( 'achievement-color', $post->ID );

            $args['achievement-image'] = get_field( 'achievement-image', $post->ID );
        }

        return $args;
    }

    public static function get()
    {
        $args['billet-achievement'] = self::get_achievement();

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
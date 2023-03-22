<?php

class BilletTitle
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-title.php';

    const CSS = [
        'billet-title' => Template::LEGAL_URL . '/assets/css/billet-title.css'
    ];

    public static function print()
    {
        foreach ( self::CSS as $key => $url ) {
            echo '<link id="' . $key . '" href="' . $url . '" rel="stylesheet" />';
        }
    }
    
    private static function get_achievement() {
        $args = [];

        $post = get_post();

        $terms = wp_get_post_terms( $post->ID, 'billet_achievement', [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) && !empty( $terms ) ) {
            $term = $terms[0];
            
            $args['achievement-selector'] = 'achievement-' . $term->term_id;

            $args['achievement-name'] = $term->name;

            $args['achievement-color'] = get_field( 'achievement-color', 'billet_achievement' . '_' . $term->term_id );

            $args['achievement-image'] = get_field( 'achievement-image', 'billet_achievement' . '_' . $term->term_id );
        }

        return $args;
    }

    public static function get()
    {
        $args['achievement'] = self::get_achievement();

        $args['title'] = get_field( 'billet-title-text' );

        $args['rating'] = get_field( 'billet-title-rating' );

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
<?php

class BilletTitle
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-title.php';
    
    private static function get_achievement( $billet ) {
        $args = [];

        $terms = wp_get_post_terms( $billet['id'], 'billet_achievement', [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) && !empty( $terms ) ) {
            $term = $terms[0];
            
            $args['achievement-selector'] = 'achievement-' . $term->term_id;

            $args['achievement-name'] = $term->name;

            $args['achievement-color'] = get_field( 'achievement-color', 'billet_achievement' . '_' . $term->term_id );

            $args['achievement-image'] = get_field( 'achievement-image', 'billet_achievement' . '_' . $term->term_id );
        }

        return $args;
    }

    public static function get( $billet )
    {
        $args['achievement'] = self::get_achievement( $billet );

        $args['title']['href'] = $billet['url']['title'];

        $args['title']['class'] = BilletMain::disabled( $billet['url']['title'] );

        $args['title']['label'] = get_field( 'billet-title-text' );

        $args['rating'] = get_field( 'billet-title-rating' );

        return $args;
    }

    public static function render( $billet = [] )
    {
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>
<?php

class BilletAchievement
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement.php';

    const TAXONOMY = 'billet_achievement';
    
    private static function get( $title ) {
        $args = [];

        $terms = wp_get_post_terms( $title['id'], self::TAXONOMY, [ 'term_id', 'name', 'slug' ] );

        // $args['class'] = $title['achievement'];

        if ( !is_wp_error( $terms ) && !empty( $terms ) ) {
            $term = array_shift( $terms );
            
            $args['selector'] = 'achievement-' . $term->term_id;

            $args['name'] = $term->name;

            $args['color'] = get_field( 'achievement-color', self::TAXONOMY . '_' . $term->term_id );

            $args['image'] = get_field( 'achievement-image', self::TAXONOMY . '_' . $term->term_id );
        }

        return $args;
    }

    public static function render( $title )
    { 
        $args = self::get( $title );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE, false, $args );
        }
    }
}

?>
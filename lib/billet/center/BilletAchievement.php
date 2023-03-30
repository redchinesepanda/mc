<?php

class BilletAchievement
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement.php';

    const TAXONOMY = 'billet_achievement';
    
    private static function get( $id ) {
        $args = [];

        $terms = wp_get_post_terms( $id, self::TAXONOMY, [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) && !empty( $terms ) ) {
            $term = array_shift( $terms );
            
            $args['selector'] = 'achievement-' . $term->term_id;

            $args['name'] = $term->name;

            $args['color'] = get_field( 'achievement-color', self::TAXONOMY . '_' . $term->term_id );

            $args['image'] = get_field( 'achievement-image', self::TAXONOMY . '_' . $term->term_id );
        }

        return $args;
    }

    public static function render( $id = 0 )
    { 
        $args = self::get( $id );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE, false, $args );
        }
    }
}

?>
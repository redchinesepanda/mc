<?php

class BilletAchievement
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-achievement.php';

    const TAXONOMY = 'billet_achievement';
    
    private static function get() {
        $args = [];

        $post = get_post();

        $terms = wp_get_post_terms( $post->ID, self::TAXONOMY, [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) ) {
            $term = $terms[0];
            
            $args['selector'] = 'achievement-' . $term->term_id;

            $args['name'] = $term->name;

            $args['color'] = get_field( 'achievement-color', self::TAXONOMY . '_' . $term->term_id );

            $args['image'] = get_field( 'achievement-image', self::TAXONOMY . '_' . $term->term_id );
        }

        echo '<pre>' . print_r( $args, true ) . '</pre>';

        return $args;
    }

    public static function render()
    { 
        $args = self::get();

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE, false,  );
        }
    }
}

?>
<?php

class BilletAchievement
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-achievement.php';

    // const STYLE = Template::LEGAL_URL . '/assets/css/billet-achievement.css';

    // public static function print()
    // {
	// 	echo '<link id="billet" href="' . BilletTitle::STYLE . '" rel="stylesheet" />';
    // }
    
    private static function get() {
        $args = [];

        $post = get_post();

        $terms = wp_get_post_terms( $post->ID, 'billet_achievement', [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) ) {
            $term = $terms[0];
            
            $args['selector'] = 'achievement-' . $term->term_id;

            $args['name'] = $term->name;

            $args['color'] = get_field( 'achievement-color', 'billet_achievement' . '_' . $term->term_id );

            $args['image'] = get_field( 'achievement-image', 'billet_achievement' . '_' . $term->term_id );
        }

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
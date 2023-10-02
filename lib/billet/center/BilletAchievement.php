<?php

class BilletAchievement
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement.php';

    const TAXONOMY = 'billet_achievement';

    const TYPE_DISABLED = 'legal-disabled';

    const TYPE_IMAGE = 'legal-image';

    const TYPE_BACKGROUND = 'legal-background';

    const TYPE = [
        'about' => 'legal-about',
    ];

    const FIELD = [
        'feture-achievement' => 'billet-feture-achievement',
    ];
    
    public static function get( $title )
    {
        LegalDebug::debug( [
            'function' => 'BilletAchievement::get',

            'title' => $title,
        ] );

        $args = [];

        $terms = wp_get_post_terms( $title['id'], self::TAXONOMY, [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) && !empty( $terms ) ) {
            $args['class'] = $title['achievement'];

            $term = array_shift( $terms );
            
            $args['selector'] = 'achievement-' . $term->term_id;

            $args['name'] = __( $term->name, ToolLoco::TEXTDOMAIN );

            $args['color'] = get_field( 'achievement-color', self::TAXONOMY . '_' . $term->term_id );

            $args['image'] = get_field( 'achievement-image', self::TAXONOMY . '_' . $term->term_id );
        }

        return $args;
    }

    public static function render( $title )
    {
        // LegalDebug::debug( [
        //     'function' => 'BilletAchievement::render',

        //     'title' => $title,
        // ] );

        if ( $title['achievement'] != self::TYPE_DISABLED ) {
            $args = self::get( $title );
    
            if ( !empty( $args ) ) {
                load_template( self::TEMPLATE, false, $args );
            }
        }
    }
}

?>
<?php

class BilletSpoiler
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-spoiler.php';
    
    private static function check()
    {
        return get_field( 'billet-spoiler-enabled');
    }

    private static function get_repeater( $repeater_field = '', $item_fields = [] )
    {
        $args = [];

        $repeater = get_field( $field );

        if( $repeater ) {
            foreach( $repeater as $key => $item ) {
                foreach( $item_fields as $field_key => $field_value ) {
                $args[$key][$field_key] = $item[$field_value];
            }
        }

        return $args;
    }

    public static function get() {
        $post = get_post();

        $args['selector'] = 'spoiler-' . $post->ID;

        $args['description'] = get_field( 'billet-spoiler-description');

        $args['review'] = __( 'Read more about', 'Thrive' ) . ' ' . get_field( 'billet-title-text');

        $args['stats'] = self::get_repeater(
            'billet-spoiler-stats',
            [
                'title' => 'stat-title', 

                'description' => 'stat-description', 
            ]
        );

        $args['progress'] = self::get_repeater(
            'billet-spoiler-progress',
            [
                'title' => 'progress-item-title', 

                'value' => 'progress-item-value', 
            ]
        );

        return $args;
    }

    public static function render( $url = [] )
    { 
        if ( self::check() ) {
            $args = self::get();
    
            if ( !empty( $url ) ) {
                $args['url'] = $url;
            }
            
            load_template( self::TEMPLATE, false, $args );
        }
    }
}

?>
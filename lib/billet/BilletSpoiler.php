<?php

class BilletSpoiler
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-spoiler.php';
    
    public static function check()
    {
        return get_field( 'billet-spoiler-enabled');
    }

    private static function get_repeater( $repeater_field = '', $item_fields = [] )
    {
        $args = [];

        $repeater = get_field( $repeater_field );

        if( $repeater ) {
            foreach( $repeater as $key => $item ) {
                foreach( $item_fields as $field_key => $field_value ) {
                    $args[$key][$field_key] = $item[$field_value];
                }
            }
        }

        return $args;
    }

    private static function replace( $args )
    {
        $length = count( $args );

        for ( $i = 0; $i < $length; $i++ ) {
            $args[$i]['class'] = str_replace( '.', '-', $args[$i]['value'] );

            $args[$i]['value'] = str_replace( '.', ',', $args[$i]['value'] );
        }

        return $args;
    }

    private static function get_progress()
    {
        $args = self::get_repeater(
            'billet-spoiler-progress',
            [
                'title' => 'progress-item-title', 

                'value' => 'progress-item-value', 
            ]
        );

        $args = self::replace( $args );

        return $args;
    }

    public static function get( $billet ) {
        $args['selector'] = 'spoiler-' . $billet['id'];

        $args['description'] = get_field( 'billet-spoiler-description');

        $args['review']['label'] = __( 'Read more about', 'Thrive' ) . ' ' . get_field( 'billet-title-text');
        
        $args['review']['href'] = $billet['url']['review'];

        $args['review']['class'] = BilletMain::disabled( $billet['url']['review'] );

        $args['stats'] = self::get_repeater(
            'billet-spoiler-stats',
            [
                'title' => 'stat-title', 

                'description' => 'stat-description', 
            ]
        );

        $args['progress'] = self::get_progress();

        return $args;
    }

    public static function render( $billet = [] )
    { 
        if ( self::check() ) {
            load_template( self::TEMPLATE, false, self::get( $billet ) );
        }
    }
}

?>
<?php

require_once( LegalMain::LEGAL_PATH . '/lib/billet/BilletMain.php' );

class CompilationMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php';

    public static function print()
    {
        BilletMain::print();
    }

    public static function get_billets( $posts, $compilation )
    {
        $data = [];

        foreach ( $posts as $index => $post ) {
            $data[$index]['index'] = $index + 1;

            $data[$index]['id'] = $post->ID;
            
            $data[$index]['compilation'] = $compilation;
        }

        return $data;
    }
    
    public static function get_compilation( $id )
    {
        $message['function'] = $get_compilation;

        if ( $id == 0 ) {
            $post = get_post();
    
            $id = $post->ID;
        }

        $data['id'] = $id;

        $data['review']['label'] = get_field( 'compilation-review-label', $id );

        $data['review']['type'] = get_field( 'compilation-review-type', $id );

        $data['play']['label'] = get_field( 'compilation-play-label', $id );

        $data['order'] = get_field( 'billet-order-type', $id );

        $data['rating'] = get_field( 'billet-rating-enabled', $id );

        $data['achievement'] = get_field( 'billet-achievement-type', $id );

        $data['list'] = get_field( 'billet-list-type', $id );

        $data['bonus'] = get_field( 'billet-bonus-enabled', $id );

        $data['mobile'] = get_field( 'billet-mobile-enabled', $id );

        $data['profit'] = get_field( 'billet-profit-enabled', $id );

        $data['spoiler'] = get_field( 'billet-spoiler-enabled', $id );

        $message['data'] = $data;

        self::debug( $message );

        return $data;
    }

    public static function get( $id )
    {
       $args = [
            'numberposts' => -1,

            'post_type' => 'legal_billet',

            'suppress_filters' => 0,

            'tax_query' => [
                [
                    'taxonomy' => 'billet_feature',

                    'field' => 'term_id',

                    'terms' => get_field( 'compilation-filter', $id ),

                    'operator' => 'AND'
                ]
            ]
        ];

        return [
            'billets' => self::get_billets( get_posts( $args ), self::get_compilation( $id ) ),

            'achievement' => 'to_do'
        ];
    }

    public static function render( $id = 0 )
    { 
        load_template( self::TEMPLATE, false, self::get( $id ) );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
<?php

require_once( LegalMain::LEGAL_PATH . '/lib/billet/BilletMain.php' );

class CompilationMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php';

    public static function print()
    {
        BilletMain::print();
    }

    // public static function get_settings( $post )
    // {
    //     $id = $post->ID;

    //     $data['id'] = $id;

    //     $data['order'] = get_field( 'billet-order-type', $id );

    //     $data['spoiler'] = get_field( 'billet-spoiler-enabled', $id );

    //     return $data;
    // }

    public static function get()
    {
        $args = [
            'numberposts' => -1,

            'post_type' => 'legal_billet',
        ];

        $posts = get_posts( $args );

        $data = [];

        foreach ( $posts as $post ) {
            // $data[] = self::get_settings( $post );

            $data[] = $post->ID;
        }

        return $data;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
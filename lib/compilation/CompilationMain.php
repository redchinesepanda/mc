<?php

require_once( LegalMain::LEGAL_PATH . '/lib/billet/BilletMain.php' );

class CompilationMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php';

    public static function print() {}

    public static function get()
    {
        $args = [
            'numberposts' => -1,

            'post_type' => 'legal_billet',
        ];

        $posts = get_posts( $args );

        $data = [];

        foreach ( $posts as $post ) {
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
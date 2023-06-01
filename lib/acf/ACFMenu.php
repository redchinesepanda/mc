<?php

class ACFMenu
{
    const FIELD = [
        'class' => 'menu-item-class',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'class' ], [ $handler, 'choices' ] );
    }

    function choices( $field )
    {
        $langs = WPMLMain::get_all_languages();

        LegalDebug::debug( [
            'function' => 'ACFMenu::choices',

            'langs' => $langs,
        ] );

        // $post = get_post();

        // $post_id = $post->ID;

        // $args = [
        //     'post_type' => 'page',

        //     'page_type' => 'bookmaker-card'
        // ];

        // $posts = get_posts( $args );

        // if ( !empty( $posts ) ) {
        //     foreach( $posts as $post ) {
        //         $field['choices'][$post->ID] = $post->post_title; 
        //     }
        // }

        return $field;
    }
}

?>
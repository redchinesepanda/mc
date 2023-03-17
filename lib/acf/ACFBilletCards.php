<?php

class ACFBilletCards
{
    const FIELD = 'billet-card-id';

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD, [ $handler, 'choices' ] );
    }

    function choices( $field )
    {
        $post = get_post();

        $post_id = $post->ID;

        $args = [
            'post_type' => 'page',

            'page_type' => 'bookmaker-card'
        ];

        $posts = get_posts( $args );

        if ( !empty( $posts ) ) {
            foreach( $posts as $post ) {
                $field['choices'][$post->ID] = $post->post_title; 
            }
        }

        return $field;
    }
}

?>
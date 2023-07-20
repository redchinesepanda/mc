<?php

class AdminBillet
{
    const META_KEY = [
        'page-template' => '_wp_page_template',
    ];

    const META_VALUE = [
        'legal_billet' => 'single-legal_billet.php',

        'legal_compilation' => 'template-compilation.php',
    ];

    // При создании нового поста POST_TYPE будет выбран шаблон TEMPLATE в блоке Post Attributes > Template

    public static function register()
    {
        $handler = new self();

        // add_action( 'wp_insert_post', [ $handler, 'meta_template' ], 10, 3 );

        // add_action( 'acf/save_post', [ $handler, 'my_acf_save_post' ] );
    }

    public static function my_acf_save_post( $post_id )
    {
        // Get newly saved values.
        $values = get_fields( $post_id );

        // Check the new value of a specific field.
        $hero_image = get_field('hero_image', $post_id);

        if( $hero_image ) {
            // Do something...
        }
    }

    public static function meta_template( $post_ID, $post, $update )
    {
        if ( !empty( self::META_VALUE[ $post->post_type ] ) ) {
            update_post_meta( $post_ID, self::META_KEY[ 'page-template' ], self::META_VALUE[ $post->post_type ] );
        }
    }
}

?>
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
    }

    function meta_template( $post_ID, $post, $update )
    {
        if ( !empty( self::META_VALUE[ $post->post_type ] ) ) {
            update_post_meta( $post_ID, self::META_KEY[ 'page-template' ], self::META_VALUE[ $post->post_type ] );
        }
    }
}

?>
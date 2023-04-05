<?php

class AdminBillet
{
    const POST_TYPE = 'legal_billet';

    const META_KEY = '_wp_page_template';

    const TEMPLATE = 'single-legal_billet.php';

    const META_VALUE = [
        'legal_billet' => 'single-legal_billet.php',

        'legal_compilation' => 'template-compilation.php',
    ];

    public static function register()
    {
        $handler = new self();

        // При создании нового поста POST_TYPE будет выбран шаблон TEMPLATE в блоке Post Attributes > Template

        add_action( 'wp_insert_post', [ $handler, 'meta_template' ], 10, 3 );
    }

    function meta_template( $post_ID, $post, $update ) {
        if ( !empty( self::META_VALUE[ $post->post_type ] ) ) {
            update_post_meta( $post_ID, self::META_KEY, self::META_VALUE[ $post->post_type ] );
        }

        // if ( $post->post_type == self::POST_TYPE ) {
        //     update_post_meta( $post_ID, self::META_KEY, self::TEMPLATE );
        // }
    }
}

?>
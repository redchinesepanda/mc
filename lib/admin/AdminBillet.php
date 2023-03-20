<?php

class AdminBillet
{
    const POST_TYPE = 'legal_billet';

    const META_KEY = '_wp_page_template';

    const TEMPLATE = 'single-legal_billet.php';

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_insert_post', [ $handler, 'meta_template' ], 10, 3 );
    }

    function meta_template( $post_ID, $post, $update ) {
        if ( $post->post_type == self::POST_TYPE ) {
            update_post_meta( $post_ID, self::META_KEY, self::TEMPLATE );
        }

    }
}

?>
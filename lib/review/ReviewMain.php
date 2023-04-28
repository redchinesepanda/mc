<?php

require_once( 'ReviewAbout.php' );

require_once( 'ReviewAnchors.php' );

require_once( 'ReviewGroup.php' );

require_once( 'ReviewProsCons.php' );

require_once( 'ReviewGallery.php' );

require_once( 'ReviewFAQ.php' );

require_once( 'ReviewStats.php' );

require_once( 'ReviewBonus.php' );

class ReviewMain
{
    const CSS = [
        'review-main' => LegalMain::LEGAL_URL . '/assets/css/review/review-main.css',

        'review-overview' => LegalMain::LEGAL_URL . '/assets/css/review/review-overview.css',

        'review-list' => LegalMain::LEGAL_URL . '/assets/css/review/review-list.css',

        'review-title' => LegalMain::LEGAL_URL . '/assets/css/review/review-title.css',

        'review-table' => LegalMain::LEGAL_URL . '/assets/css/review/review-table.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        
        add_action( 'save_post', [ $handler, 'character_replace' ], 10, 3 );

        ReviewAbout::register();

        ReviewAnchors::register();

        ReviewGroup::register();

        ReviewProsCons::register();

        ReviewGallery::register();

        ReviewFAQ::register();

        ReviewStats::register();

        ReviewBonus::register();
    }

    function character_replace( $post_id, $post, $update ){
        // 195, 8218, 194

        // $post->post_content = str_replace( chr( 195 ).chr( 8218 ).chr( 194 ), '', $post->post_content );

        // $post->post_content = preg_replace( '/[^a-z0-9$¢£€¥ ]+/ui', '', $post->post_content );

        $post->post_content = mb_convert_encoding( $post->post_content, 'HTML-ENTITIES','UTF-8' );

        // wp_die( LegalDebug::debug( [
        //     '$post->post_content' => $post->post_content,
        // ] ) );

        wp_die( LegalDebug::debug( [
            'iconv1' => iconv( 'ISO-8859-1', 'UTF-8', $post->post_content ),

            'iconv2' => iconv( 'UTF-8', 'ISO-8859-1', $post->post_content ),

            'mb_convert_encoding1' => mb_convert_encoding( $post->post_content, 'UTF-8', 'ISO-8859-1' ),

            'mb_convert_encoding2' => mb_convert_encoding( $post->post_content, 'HTML-ENTITIES','UTF-8' ),
        ] ) );
    }
}

?>
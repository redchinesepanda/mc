<?php

class WPMLLangSwitcher
{
    public static function register() {
        $message[] = 'WPMLLangSwitcher::register';

        $handler = new self();

        // [legal-lang-switcher]

        add_shortcode( 'legal-lang-switcher', [ $handler, 'get' ] );

        self::debug( $message );
    }

    public function get()
    {
        $message['function'] = 'WPMLLangSwitcher::get';

        $post = get_post();

        $message['$post->ID'] = $post->ID;

        $trid = apply_filters( 'wpml_element_trid', NULL, $post->ID, 'post_page' );

        $message['$trid'] = $trid;

        $translations = apply_filters( 'wpml_get_element_translations', NULL, $trid, 'post_page' );

        $message['translations'] = $translations;

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>
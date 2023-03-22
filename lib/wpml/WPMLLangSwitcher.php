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

    function get_all() {
        $message['function'] = 'WPMLLangSwitcher::get_all';

        $languages = apply_filters(
            'wpml_active_languages',

            NULL,
            [
                'skip_missing' => 1, 

                // 'link_empty_to' => 'http://domain.com/missing-translation-contact-form',

                'orderby' => 'id',

                'order' => 'asc',
            ]
        );
     
        $message['languages'] = $languages;

        return $languages;
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
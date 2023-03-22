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

    public static function get_current()
    {
        $post = get_post();

        $trid = apply_filters( 'wpml_element_trid', NULL, $post->ID, 'post_page' );

        $translations = apply_filters( 'wpml_get_element_translations', NULL, $trid, 'post_page' );

        return $translations;
    }

    function get_all() {
        $languages = apply_filters(
            'wpml_active_languages',

            NULL,
            [
                'skip_missing' => 0,

                'orderby' => 'id',

                'order' => 'asc',
            ]
        );

        return $languages;
    }

    public function get()
    {
        $message['function'] = 'WPMLLangSwitcher::get';

        // $message['translations'] = self::get_current();

        $message['languages'] = self::get_all();

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>
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
        $message[] = 'WPMLLangSwitcher::get';

        $translations = apply_filters( 'wpml_get_element_translations', NULL, 2, 'post_page' );

        var_dump( $translations );

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>
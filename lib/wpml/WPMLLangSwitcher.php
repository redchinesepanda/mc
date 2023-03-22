<?php

class WPMLLangSwitcher
{
    public static function register() {
        $handler = new self();

        add_shortcode( 'legal-lang-switcher', [ $handler, 'get' ] );
    }

    public static function get()
    {
        $translations = apply_filters( 'wpml_get_element_translations', NULL, 2, 'post_page' );

        var_dump( $translations );
    }
}

?>
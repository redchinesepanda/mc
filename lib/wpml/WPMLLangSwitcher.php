<?php

class WPMLLangSwitcher
{
    public static function register() {
        $handler = new self();

        // [legal-lang-switcher]

        add_shortcode( 'legal-lang-switcher', [ $handler, 'get' ] );
    }

    public function get()
    {
        $translations = apply_filters( 'wpml_get_element_translations', NULL, 2, 'post_page' );

        var_dump( $translations );
    }
}

?>
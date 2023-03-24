<?php

class WPMLTrid
{
    public static function register()
    {
        $handler = new self();

        add_action( 'edit_form_after_title', [ $handler, 'render' ] );
    }

    function render( $post )
    {
        $message = self::get();

        self::debug( $message );
    }

    public static function get() {
        $post = get_post();

        return apply_filters( 'wpml_element_trid', NULL, $post->ID, 'post_page' );  
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>
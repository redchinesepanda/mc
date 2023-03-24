<?php

class WPMLTrid
{
    public static function register()
    {
        $handler = new self();

        add_action( 'edit_form_after_title', [ $handler, 'render' ] );
    }

    public static function render( $post )
    {
        $trid = self::get();

        // $message['trid'] = $trid;

        // $message['translation_group'] = self::get_translation_group( $trid );

        $message['all'] = self::get_all( $trid );

        self::debug( $message );
    }

    public static function get_all()
    {
        global $wpdb;

        $query = "SELECT
            DISTINCT `trid`
            FROM `wp_icl_translations`
            WHERE `element_type` = 'post_page'
            LIMIT 10";

        $posts = $wpdb->get_results( $query );

        return $posts;
    }

    public static function get_translation_group( $trid )
    {
        return apply_filters( 'wpml_get_element_translations', NULL, $trid, 'post_page' );
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
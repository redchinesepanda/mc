<?php

class WPMLTrid
{
    public static function register() {}
    
    public static function render( $post )
    {
        $all = self::get( $trid );

        $message['all'] = $all;

        self::debug( $message );
    }

    public static function get()
    {
        global $wpdb;

        $query = "SELECT
                DISTINCT `wp_icl_translations`.`trid` AS `legal_trid`,
                COUNT( `wp_icl_translations`.`element_id` ) AS `legal_elements`,
                `wp_icl_translations`.`element_id` AS `legal_element_id`,
                `wp_posts`.`post_title` AS `legal_title`,
                GROUP_CONCAT( `language_code` ) as 'legal_language_codes'
            FROM `wp_icl_translations`
            INNER JOIN `wp_posts` ON `element_id` = `ID`
            WHERE
                `element_type` = 'post_page'
                AND `post_status` = 'publish'
            GROUP BY `trid`";
        
        $posts = $wpdb->get_results( $query );

        return $posts;
    }

    public static function get_translation_group( $trid )
    {
        return apply_filters( 'wpml_get_element_translations', NULL, $trid, 'post_page' );
    }

    public static function get_trid() {
        $post = get_post();

        return apply_filters( 'wpml_element_trid', NULL, $post->ID, 'post_page' );  
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>
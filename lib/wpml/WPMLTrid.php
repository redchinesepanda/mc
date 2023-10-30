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
                `element_type` IN ( 'post_page', 'post_legal_billet' )
                AND `post_status` = 'publish'
            GROUP BY `trid`
            ORDER BY `legal_title`, `legal_elements`";
        
        $posts = $wpdb->get_results( $query );

        return $posts;
    }

    public static function get_translation_group( $trid )
    {
        return apply_filters( 'wpml_get_element_translations', NULL, $trid, 'post_page' );
    }

    public static function get_trid( $id = 0 )
    {
        if ( $id == 0 )
        {
            $post = get_post();

            if ( !empty( $post ) )
            {
                $id = $post->ID;
            }
        }
        
        if ( $id != 0 )
            return apply_filters( 'wpml_element_trid', NULL, $id, self::get_element_type( $id ) );

        return 0;
    }
}

?>
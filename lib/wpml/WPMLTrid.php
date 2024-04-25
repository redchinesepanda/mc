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

    public static function get_query( $position = 0, $limit = 100 )
    {
        return "SELECT
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
            GROUP BY `trid`
            ORDER BY `legal_title`, `legal_elements`
            LIMIT $position, $limit";
    }

    public static function get()
    {
        global $wpdb;

        // $posts = [];

        $position = 0;

        $limit = 100;
        
        // do
        // {
        //     $result = $wpdb->get_results( self::get_query( $position, $limit ) );

        //     $posts = array_merge( $posts, $result );

        //     $position += $limit;
        // }
        // while ( !empty( $result ) );
        
        return $wpdb->get_results( self::get_query( $position, $limit ) );
    }

    public static function get_translation_group( $trid )
    {
        $group = apply_filters( 'wpml_get_element_translations', NULL, $trid, 'post_page' );

        // LegalDebug::debug( [
        // 	'WPMLTrid' => 'get_translation_group',

        // 	'trid' => $trid,
            
        // 	'group' => $group,
        // ] );

        if ( !empty ( $group ) )
        {
            return $group;
        }

        return [];
    }

    public static function get_trid( $id = 0 )
    {
        if ( empty( $id ) )
        {
            $post = get_post();

            if ( $post )
            {
                $id = $post->ID;
            }
        }
        
        // LegalDebug::debug( [
        // 	'function' => 'WPMLTrid::get_trid',

        // 	'id' => $id,

        // 	'get_element_type' => WPMLMain::get_element_type( $id ),

        // 	'wpml_element_trid' => apply_filters( 'wpml_element_trid', NULL, $id, WPMLMain::get_element_type( $id ) ),
        // ] );
        
        if ( !empty( $id ) )
        {
            return apply_filters( 'wpml_element_trid', NULL, $id, WPMLMain::get_element_type( $id ) );
        }

        return false;
    }
}

?>
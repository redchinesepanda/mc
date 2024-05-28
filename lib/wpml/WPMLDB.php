<?php

class WPMLDB
{
	public static function multisite_all_languages_query( $wpdb, $display_language_code )
    {
        return $wpdb->prepare(
            "SELECT wp_icl_languages.code,
			wp_icl_languages.id,
			wp_icl_languages_translations.language_code,
			wp_icl_languages.major,
			wp_icl_languages.default_locale,

            FROM wp_icl_languages

			INNER JOIN wp_icl_languages_translations ON wp_icl_languages.code = wp_icl_languages_translations.language_code

            WHERE wp_icl_languages.active = 2
				AND wp_icl_languages_translations.display_language_code = %s",

            [
                $display_language_code,
            ]
        );
    }

    public static function multisite_all_languages()
    {
        // LegalDebug::debug( [
        //     'WPMLMain' => 'multisite_all_languages',

        //     'data' => $data,

        //     'element' => $element,
        // ] );

        global $wpdb;

        $language_code = MultisiteSiteOptions::get_blog_language();

        $all_languages_query = self::multisite_all_languages_query( $wpdb, $language_code );

        // LegalDebug::debug( [
        //     'WPMLMain' => 'multisite_all_languages',

        //     'all_languages_query' => $all_languages_query,
        // ] );
        
        $result = $wpdb->get_results( $all_languages_query );

        // $language_code = $wpdb->get_var( $all_languages_query );

        LegalDebug::debug( [
            'WPMLMain' => 'multisite_all_languages',

            'result' => $result,
        ] );

        // if ( $language_code != 'en' )
        // {
        //     return $language_code;
        // }

        // return '';

        // return $language_code;
        
        // return $wpdb->get_var( $language_code_query );
    }
}

?>
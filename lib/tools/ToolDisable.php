<?php

class ToolDisable
{
    public static function register()
    {
        $handler = new self();

        // Stop WordPress from reserving slugs for media items?

        add_filter( 'wp_unique_post_slug_is_bad_attachment_slug', '__return_true' );

        // add_filter( 'wp_unique_post_slug_is_bad_attachment_slug', [ $handler, 'legal_attachment_slug' ], 10, 2 );

        // Attachment name prefix and transliterate in wp_handle_upload_prefilter filter

        add_filter( 'wp_handle_upload_prefilter', [ $handler, 'legal_upload_prefilter' ] );

        add_filter( 'rest_authentication_errors', [ $handler, 'disable_rest_api' ] );

        add_filter( 'wpo_purge_cache_hooks', [ $handler, 'disable_wp_optimize_hooks' ] );

        LegalDebug::debug( [
            'ToolDisable' => 'register',
        ] );
    }

    public static function disable_wp_optimize_hooks( $actions )
    {
        // $actions[] = 'my_custom_action';

        LegalDebug::debug( [
            'ToolDisable' => 'disable_wp_optimize_hooks',

            'actions' => $actions,
        ] );

        return $actions;
    }

    public static function check_admin()
	{
		return is_admin();
	}

    public static function check_logged_in()
	{
		return is_user_logged_in();
	}

    public static function check_rest_api()
	{
		return self::check_logged_in();
	}

    function disable_rest_api( $access )
    {
        if ( self::check_rest_api() )
        {
            return $access;
        }

        return self::rest_api_error_not_logged_in();
    }
    
    function rest_api_error_not_logged_in()
    {
        return new WP_Error(
            'rest_not_logged_in',

            __('The WordPress REST API has been disabled. You are not currently logged in.'),

            [ 'status' => rest_authorization_required_code() ]
        );
    }

    function rest_api_error_disabled()
    {
        return new WP_Error(
            'rest_disabled',

            __('The WordPress REST API has been disabled.'),

            [ 'status' => rest_authorization_required_code() ]

            // [
            //     'status' => rest_authorization_required_code(),

            //     'check_admin' => self::check_admin(),

            //     'check_logged_in' => self::check_logged_in(),
            // ]
        );
    }
    

    // public static function legal_attachment_slug( $bad_slug, $slug ) {
    //     return true;
    // }

    public static function legal_upload_prefilter( $file )
    {
        $path_parts = pathinfo( $file['name'] );
    
        $filename = iconv("UTF-8", "ISO-8859-1//TRANSLIT",  mb_substr( $path_parts['filename'], 0, 10 ) );
        
        $file['name'] = 'image-' . uniqid() . '-' . $filename . '.' . $path_parts['extension'];
    
        $current_user = wp_get_current_user();
    
        if ( $current_user->user_login == 'redchinesepanda' ) {
            $message['function'] = 'legal_upload_prefilter';
    
            $message['file'] = $file;
        }
    
        return $file;
    }
}

?>
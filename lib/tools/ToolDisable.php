<?php

class ToolDisable
{
    public static function register()
    {
        $handler = new self();

        // Stop WordPress from reserving slugs for media items?

        // add_filter( 'wp_unique_post_slug_is_bad_attachment_slug', '__return_true' );

        // add_filter( 'wp_unique_post_slug_is_bad_attachment_slug', [ $handler, 'legal_attachment_slug' ], 10, 2 );

        // Attachment name prefix and transliterate in wp_handle_upload_prefilter filter

        add_filter( 'wp_handle_upload_prefilter', [ $handler, 'legal_upload_prefilter' ] );
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
    
            // echo( '<pre>' . print_r( $message, true ) . '</pre>' );
        }
    
        return $file;
    }
}

?>
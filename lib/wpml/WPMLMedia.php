<?php

class WPMLMedia
{
	public static function register()
	{
        $handler = new self();

        // add_action( 'wp_loaded', [ $handler, 'delete_translated_media' ] );
        
		// add_action( 'wp_loaded', [ $handler, 'check_media' ] );
    }

	public static function count()
	{
		return count( apply_filters( 'wpml_active_languages', NULL, '' ) );
	}

	public static function delete_translated_media()
	{
		global $wpdb;
 
		/* Delete translated media posts */

		// Get IDs of all translated media

		// $query = "SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE element_type = 'post_attachment' AND source_language_code IS NOT null";
		
		$query = "SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE element_type = 'post_attachment' AND source_language_code IS NOT null LIMIT 10";

		$results = $wpdb->get_results( $query, OBJECT );

		LegalDebug::debug( [
			'function' => 'WPMLMedia::delete_translated_media',

			'results' => $results,
		] );

		foreach ( $results as $result ) {
			// delete the attachment post but not the media file

			// cannot use wp_delete_attachment because it deletes the media file

			// cannot use wp_delete_post because for attachments it switches to wp_delete_attachment

			// solution is to first switch post type to something else then use wp_delete_post

			// use direct query to avoid overhead of wp_update_post
			 
			$wpdb->update(
				"{$wpdb->prefix}posts",
				array( 'post_type' => 'for-deletion' ),
				array( 'ID' => $result->element_id ),
				array( '%s' ),
				array( '%d' )
			);

			// delete safely using wp_delete_post

			wp_delete_post( $result->element_id, true );
		}
	}

	public static function check_media()
	{
		global $wpdb, $sitepress;
 
		// set how many languages site has

		// $langs = 3;
		
		$langs = self::count();
		
		$query = "SELECT ID, post_title, count(ID) AS cnt FROM {$wpdb->prefix}posts WHERE post_type LIKE 'attachment' GROUP BY post_title HAVING cnt > " .  $langs;

		$duplicated = $wpdb->get_results( $query );

		LegalDebug::debug( [
			'duplicated' => $duplicated,
		] );
		
		$issues = [];

		$i = 0;

		foreach ( $duplicated as $duplicat ) {
			
			$trid = $sitepress->get_element_trid( $duplicat->ID, 'post_attachment' );
			
			if ( !$trid ) {
				continue;
			}
			
			$translations = $sitepress->get_element_translations( $trid, 'post_attachment' );
			
			if ( count( $translations ) < 1 ) {
				continue;
			}
			
			foreach ( $translations as $lang => $tr ) {
				$issues[ $i ][ 'notin' ][] = $tr->element_id;
			}
			
			$issues[ $i ][ 'post_title' ] = $duplicat->post_title;
		
			$i++;
		}
		
		
		foreach ( $issues as $issue ) {
			$notin = implode( ",", $issue[ 'notin' ] );

			$query = "DELETE FROM {$wpdb->prefix}posts WHERE `ID` NOT IN ($notin) AND `post_title` LIKE '" . $issue['post_title'] . "' AND `post_type` LIKE 'attachment'";
			
			$result = $wpdb->query( $query );
		}
	}
}

?>
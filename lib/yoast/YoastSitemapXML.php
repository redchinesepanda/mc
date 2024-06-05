<?php

class YoastSitemapXML
{
	public static function register_functions()
    {
        $handler = new self();

        // Exclude a post type
	
		add_filter( 'wpseo_sitemap_exclude_post_type', [ $handler, 'sitemap_exclude_post_type' ], 10, 2 );

        // Exclude a taxonomy
	
		add_filter( 'wpseo_sitemap_exclude_taxonomy', [ $handler, 'sitemap_exclude_taxonomy' ], 10, 2 );

		// Exclude an author
	 
		add_filter( 'wpseo_sitemap_exclude_author', [ $handler, 'sitemap_exclude_authors' ] );
		
		// use it to remove the '/homepage/' part from any sitemap entries

		add_filter( 'wpseo_xml_sitemap_post_url', [ $handler, 'sitemap_post_url' ], 10, 2 );
    }

	public static function check_front_page( $post_id )
    {
		// $front_page_id = get_option( 'page_on_front' );
		
        // return ( ! empty( $front_page_id ) && $post_id == $front_page_id ) ? true : false;

		return WPMLTrid::get_trid( $post_id ) == WPMLTrid::get_trid( get_option( 'page_on_front' ) );
	}

	const PATTERNS = [
		'path' => '/%s/',

		'url' => '%s://%s%s',
	];
	
	public static function sitemap_post_url( $url, $post )
	{  
		// return str_replace('/homepage/', '/', $url); 

		if ( self::check_front_page( $post->ID ) )
		{
			$parsed_url = parse_url( $url );

			$path = trim( $parsed_url[ 'path' ], '/' );

			$path_array = explode( '/', $path );

			if ( count( $path_array ) > 1 )
			{
				$folder = array_shift( $path_array );

				$parsed_url[ 'path' ] = sprintf( self::PATTERNS[ 'path' ], $folder );
			}

			$unparsed_url = sprintf( self::PATTERNS[ 'url' ], $parsed_url[ 'scheme' ], $parsed_url[ 'host' ], $parsed_url[ 'path' ] );

			LegalDebug::debug( [
				'YoastSitemapXML' =>'sitemap_post_url',

				'url' => $url,

				'post_id' => $post->ID,

				'parsed_url' => $parsed_url,

				'unparsed_url' => $unparsed_url,
			] );

			return $unparsed_url;
		}

		return $url;
	}

	const POST_TYPES = [
        'affiliate-links',

        // 'author',
    ];

	public static function sitemap_exclude_post_type( $excluded, $post_type )
	{
		// return $post_type === 'recipes';
		
		return in_array( $post_type, self::POST_TYPES );
	}

	const TAXONOMY = [
        'post_tag',

        'translation_group',

        'offer_group',

        'page_group',

        'billet_achievement',

        'media_type',

        'billet_type',

        'page_type',

        'billet_feature',
    ];

	public static function sitemap_exclude_taxonomy( $excluded, $taxonomy )
	{
		// return $post_type === 'recipes';
		
		return in_array( $taxonomy, self::TAXONOMY );
	}
	
	public static function sitemap_exclude_authors( $users )
	{
		// return array_filter( $users, function( $user ) {
		// 	 if ( $user->ID === 5 ) {
		// 		 return false;
		// 	 }
	 
		// 	 return true;
		//  } );

		return false;
	}
}

?>
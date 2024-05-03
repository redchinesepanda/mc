<?php

class AdminBrand
{
	const POST_TYPES = [
		'brand' => 'legal_brand',
	];
	
	public static function register()
    {
        // $handler = new self();

        // add_action( 'restrict_manage_posts', [ $handler, 'filter_dropdown'] );
    }

	public static function check_brand( $post_type )
	{
		return $post_type == self::POST_TYPES[ 'brand' ];
	}

	public static function filter_dropdown( $post_type )
    {
        if ( self::check_brand( $post_type ) )
		{
			// $languages = WPMLMain::get_all_languages();

			// $language = WPMLMain::current_language();
	
			// LegalDebug::debug( [
			// 	'AdminBrand' => 'filter_dropdown',
	
			// 	'post_type' => $post_type,

			// 	'language' => $language,
	
			// 	'languages' => $languages,
			// ] );
	
			// foreach ( $languages as $code => $language )
			// {
				// LegalDebug::debug( [
				// 	'AdminBrand' => 'filter_dropdown',
	
				// 	'code' => $code,
	
				// 	'language' => $language,
				// ] );
	
				// foreach ( $taxonomies as $taxonomy )
				// {
				//     // LegalDebug::debug( [
				//     //     'post_type' => $post_type,
				//     // ] );
	
				//     if ( $typenow == $post_type )
				//     {
				//         $selected = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
			
				//         $info_taxonomy = get_taxonomy( $taxonomy );
	
				//         if ( $info_taxonomy )
				//         {
				//             wp_dropdown_categories( [
				//                 'show_option_all' => sprintf( __( 'Show all %s', ToolLoco::TEXTDOMAIN ), $info_taxonomy->label ),
								
				//                 'taxonomy'        => $taxonomy,
								
				//                 'name'            => $taxonomy,
								
				//                 'orderby'         => 'name',
								
				//                 'selected'        => $selected,
								
				//                 'show_count'      => true,
								
				//                 'hide_empty'      => true,
				//             ] );
		
				//             // LegalDebug::debug( [
				//             //     'function' => 'AdminTaxonomy::filter_dropdown',
		
				//             //     'typenow' => $typenow,
				
				//             //     'taxonomies' => $taxonomies,
		
				//             //     'taxonomy' => $taxonomy,
		
				//             //     'label' => $info_taxonomy->label,
				//             // ] );
				//         }
				//     };
				// }
			// }
		}
    }
}

?>
<?php

class AdminBrand
{
	public static function register()
    {
        $handler = new self();

        add_action( 'restrict_manage_posts', [ $handler, 'filter_dropdown'] );
    }

	public static function filter_dropdown( $post_type, $which )
    {
        // global $typenow;

		$languages = WPMLMain::get_all_languages();

		LegalDebug::debug( [
			'AdminBrand' => 'filter_dropdown',

			'languages' => $languages,
		] );

        foreach ( $languages as $code => $language )
        {
			LegalDebug::debug( [
				'AdminBrand' => 'filter_dropdown',
				
			    'code' => $code,

				'language' => $language,
			] );

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
        }
    }
}

?>
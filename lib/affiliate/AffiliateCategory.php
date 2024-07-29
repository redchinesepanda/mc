<?php

class AffiliateCategory
{
	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			// if ( MultisiteBlog::check_main_domain() )
			// {
				$handler = new self();

				add_filter( 'post_type_link', [ $handler, 'post_type_link' ], 10, 3 );
			// }
		}
	}

	public static function post_type_link( $permalink, $post_id, $leavename )
	{
		LegalDebug::debug( [
			'AffiliateCategory' => 'post_type_link-1',

			'permalink' => $permalink,

			'post_id' => $post_id,

			'leavename' => $leavename,
		] );

        // $post = get_post( $post_id );

        // if ( !empty( $permalink ) ) {

        //     if ( $post->post_type == self::$post_type ) {

        //         $terms = wp_get_object_terms( $post->ID, self::$taxonomy );

        //         if( !empty( $terms ) ) {

        //             usort( $terms, '_usort_terms_by_ID' ); // order by ID

        //             $term = $terms[0]->slug;

        //             if( !empty( $term ) ) {

        //                 $slug = $this->get_slug();

        //                 $permalink = str_replace( $slug, $slug . '/' . $term , $permalink );

        //             }

        //         }

        //     }

        // }

        return $permalink;

    }
}

?>
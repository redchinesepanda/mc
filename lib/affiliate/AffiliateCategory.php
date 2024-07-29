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

				add_filter( 'post_type_link', [ $handler, 'post_type_link' ], 11, 3 );
			// }
		}
	}

	public static function post_type_link( $permalink, $post, $leavename )
	{
		$terms = wp_get_object_terms( $post->ID, 'affiliate-links-cat' );

		if( ! empty( $terms ) )
		{
			// $term = $terms[0]->slug;
			
			$term = array_shift( $terms );

			if( ! empty( $term->slug ) )
			{
				$slug = $this->get_slug();

				$permalink = str_replace( $slug, $slug . '/' . $term->slug , $permalink );
			}
		}

		LegalDebug::debug( [
			'AffiliateCategory' => 'post_type_link-1',

			'permalink' => $permalink,

			'post->ID' => $post->ID,

			'leavename' => $leavename,

			'terms' => $terms,
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
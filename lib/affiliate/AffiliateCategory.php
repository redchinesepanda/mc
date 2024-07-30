<?php

class AffiliateCategory
{
	public static function register_functions_admin()
	{
		// if ( MultisiteMain::check_multisite() )
		// {
		// 	// if ( MultisiteBlog::check_main_domain() )
		// 	// {
		// 		$handler = new self();

		// 		// add_filter( 'post_type_link', [ $handler, 'post_type_link' ], 11, 3 );
		// 	// }
		// }
	}

	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			$handler = new self();

			add_action( 'init', [ $handler, 'register_rewrite_rules' ] );
		}
	}

	const POST_TYPE = [
		'affiliate' => 'affiliate-links',
	];

	const TAXONOMY = [
		'affiliate' => 'affiliate-links-cat'
	];

	public static function register_rewrite_rules()
	{

        // $slug = $this->get_slug();

        // add_rewrite_rule( "$slug/([^/]+)?/?$", 'index.php?' . self::$post_type . '=$matches[1]', 'top' );
        
		// add_rewrite_rule( "$slug/([^/]+)?/?([^/]+)?/?", 'index.php?' . self::$post_type . '=$matches[2]&' . self::$taxonomy . '=$matches[1]', 'top' );

		add_rewrite_rule( "go/([^/]+)?/?$", 'index.php?' . self::POST_TYPE[ 'affiliate' ] . '=$matches[1]', 'bottom' );

		add_rewrite_rule( "go/([^/]+)?/?([^/]+)?/?", 'index.php?' . self::POST_TYPE[ 'affiliate' ] . '=$matches[2]&' . self::TAXONOMY[ 'affiliate' ] . '=$matches[1]', 'bottom' );
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
				$slug = 'go';

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
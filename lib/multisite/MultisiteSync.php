<?php

class MultisiteSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',
    ];

	const FIELDS = [
		'about' => [
			'name' => 'review-about',

			'key' => 'field_6437de4fa65c9',
		],
	];

	const FIELD_ABOUT = [
		'logo' => [
			'name' => 'about-logo',

			'key' => 'field_6437df25a65cd',
		],
	];

	const PATTERNS = [
		'group-field' => '%1$s_%2$s',
	];

	public static function register_functions_admin()
    {
		$handler = new self();

		add_filter( 'save_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_attachments' ], 10, 2 );
	}

	public static function set_attachments( $post_id, $post )
    {
		$field_name = sprintf(
			self::PATTERNS[ 'group-field' ],
			
			self::FIELDS[ 'about' ][ 'name' ],

			self::FIELD_ABOUT[ 'logo' ][ 'name' ]
		);

		LegalDebug::debug( [
			'MultisiteSync' => 'set_attachments',

			'post_id' => $post_id,

			'field_name' => $field_name,
		] );

		if ( $origin_post_id = MultisiteACF::get_field_raw( $field_name, $post_id ) )
		{
			self::get_post_moved_id( $post_origin_id );
			
			// if ( $post_moved_id = MultisiteMeta::get_post_moved_id( $origin_post_id ) )
			// {
			// 	LegalDebug::debug( [
			// 		'MultisiteSync' => 'set_attachments',
		
			// 		'post_moved_id' => $post_moved_id,
			// 	] );
			// }

			LegalDebug::die( [
				'MultisiteSync' => 'set_attachments',

				'origin_post_id' => $origin_post_id,
			] );
		}

		LegalDebug::die( [
			'MultisiteSync' => 'set_attachments',

			'field' => $field,
		] );

		// if ( $post_moved_id = MultisiteMeta::get_post_moved_id( $origin_post_id ) )
		// {

		// }

        // if ( self::POST_TYPE[ 'billet' ] == $post->post_type )
        // {
            // $args = 0;

            // $about = get_field( self::GROUP[ 'about' ], $post_id );

            // if ( $about )
            // {
            //     if ( $title = $about[ BilletTitle::ABOUT[ 'title' ] ] )
            //     {
            //         $brands = self::get_brand( $title );

            //         // LegalDebug::die( [
            //         //     'ACFBillet' => 'billet_set_brand',

            //         //     'brands' => $brands,
            //         // ] );

            //         $args = array_shift( $brands );
            //     }
            // }

            // // LegalDebug::die( [
            // //     'ACFBillet' => 'billet_set_brand',

            // //     'args' => $args,
            // // ] );

            // if ( !empty( $args ) && empty( get_field( self::GROUP[ 'brand' ], $post_id ) ) )
            // {
            //     update_field( self::GROUP[ 'brand' ], $args, $post_id );
            // }
        // }
    }
}

?>
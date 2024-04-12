<?php

class MultisiteSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',
    ];

	const FIELDS = [
		'logo' => [
			'name' => 'about-logo',

			'key' => 'field_6437df25a65cd',
		],
	];

	public static function register_functions_admin()
    {
		$handler = new self();

		add_filter( 'save_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_attachments' ], 10, 2 );
	}

	public static function set_attachments( $post_id, $post )
    {
		$field_name = self::FIELDS[ 'logo' ][ 'key' ];

		LegalDebug::die( [
			'MultisiteSync' => 'set_attachments',

			'post_id' => $post_id,

			'field_name' => $field_name,
		] );

		if ( $field = MultisiteACF::get_field_raw( $field_name, $post_id ) )
		{
			LegalDebug::die( [
				'MultisiteSync' => 'set_attachments',

				'field' => $field,
		}

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
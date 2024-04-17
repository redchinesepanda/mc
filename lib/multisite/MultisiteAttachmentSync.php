<?php

class MultisiteAttachmentSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',

        'page' => 'page',
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

		'logo-contrast' => [
			'name' => 'about-logo-mega',

			'key' => 'field_64c23d34d8c9a',
		],

		'logo-square' => [
			'name' => 'about-logo-square',

			'key' => 'field_64490745cce76',
		],
	];

	const PATTERNS = [
		'group-field' => '%1$s_%2$s',

		'regex' => '/%s/',

		'shortcode' => '[%1$s %2$s]',

		'attr-pair' => '%1$s="%2$s"',

		'gallery-id' => 'gallery-%1$s-%2$s',
	];
	
	const SHORTCODES = [
		'gallery' => 'gallery',
	];

	public static function register_functions_admin()
    {
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();
	
			// add_filter( 'save_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_attachments' ], 10, 2 );
			
			add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_attachments' ], 10, 2 );

			add_filter( 'edit_post_' . self::POST_TYPE[ 'page' ], [ $handler, 'set_attachments_shortcode' ], 10, 2 );
		}
	}

	public static function register_functions_debug()
	{
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			add_action( 'edit_form_after_title', [ $handler, 'mc_debug_edit_form_after_title_action' ] );
		}
	}

	public static function mc_debug_edit_form_after_title_action( $post )
	{
		// $matches = self::get_gallery_shortcodes();

		// $ids = self::get_shortcodes_attr_ids( $matches );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'mc_debug_edit_form_after_title_action',

		// 	'ids' => $ids,
		// ] );

		$result = self::set_attachments_shortcode( $post->ID, $post );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'mc_debug_edit_form_after_title_action',

		// 	'result' => $result,
		// ] );
	}

	public static function get_atts_pair( $v, $k )
	{
		return sprintf( self::PATTERNS[ 'attr-pair' ], $k, $v );
	}

	public static function get_atts_part( $atts )
	{
		$handler = new self();

		return implode( ' ', array_map(
			[ $handler, 'get_atts_pair' ],

			$atts,

			array_keys( $atts )
		) );
	}

	public static function set_gallery_shortcode_moved_ids( $attachment_ids )
	{
		foreach ( $attachment_ids as $key => $origin_post_id )
		{
			if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
			{
				$attachment_ids[ $key ] = $post_moved_id;
			}
		}

		return $attachment_ids;
	}

	public static function sync_gallery_shortcode_ids( $match )
	{
		$atts = shortcode_parse_atts( $match[ 3 ] );

		if ( ! empty( $atts[ 'ids' ] ) )
        {
            $ids = explode( ',', $atts[ 'ids' ] );

			// $ids = [ 0 ];
			
			$ids = self::set_gallery_shortcode_moved_ids( $ids );

			// sync ids

			$atts[ 'ids' ] = implode( ',', $ids );
        }

		return self::get_atts_part( $atts );
	}

	public static function replace_gallery_shortcodes_ids( $match )
	{
		// $atts = shortcode_parse_atts( $match[ 3 ] );

		$atts = self::sync_gallery_shortcode_ids( $match );

		$result = sprintf( self::PATTERNS[ 'shortcode' ], self::SHORTCODES[ 'gallery' ], $atts );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'get_gallery_shortcodes',

		// 	// 'match' => $match,

		// 	'atts' => $atts,

		// 	'result' => $result,
        // ] );

		return $result;
	}

	public static function set_attachments_shortcode( $post_id, $post )
    {
		$ids = self::get_gallery_attachment_ids( $post );

		$origin_post_ids = MultisitePost::get_post_moved_id_all( $ids );

        $regex = sprintf( self::PATTERNS[ 'regex' ], get_shortcode_regex( self::SHORTCODES ) );

		LegalDebug::debug( [
			'MultisiteAttachment' => 'set_attachments_shortcode',

			'ids' => $ids,

			'origin_post_ids' => $origin_post_ids,

		    'regex' => $regex,
		] );

		$handler = new self();

		$result = preg_replace_callback( 
			$regex,

			[ $handler, 'replace_gallery_shortcodes_ids' ],

			$post->post_content
		);

		// $post->post_content = $result;

		// MultisitePost::update_post( $post );
    }

	public static function get_gallery_shortcodes_attr_ids( $galleries )
    {
        $ids = [];

        foreach ( $galleries as $gallery_id => $gallery )
		{
			$atts = shortcode_parse_atts( $gallery[ 3 ] );

			if ( ! empty( $atts[ 'ids' ] ) )
			{
				foreach ( explode( ',', $atts[ 'ids' ] ) as $attachment_index => $attachment_id )
				{
					$gallery_index = sprintf( self::PATTERNS[ 'gallery-id' ], $gallery_id, $attachment_index );

					$ids[ $gallery_index ] = $attachment_id;
				}
			}
		}

        return $ids;
    }

	public static function get_gallery_matches( $post )
	{
		$matches = [];

		$regex = sprintf( self::PATTERNS[ 'regex' ], get_shortcode_regex( self::SHORTCODES ) );

		$amount = preg_match_all( 
			$regex,

			$post->post_content,

			$matches,

			PREG_SET_ORDER
		);

		return $matches;
	}

	public static function get_gallery_attachment_ids( $post )
    {
        $galleries = self::get_gallery_matches( $post );

        // $post = get_post();

        // if ( $post )
        // {
            // $regex = sprintf( self::PATTERNS[ 'regex' ], get_shortcode_regex( self::SHORTCODES ) );

			// // LegalDebug::debug( [
			// // 	'MultisiteAttachment' => 'get_gallery_shortcodes',

            // //     'regex' => $regex,
			// // ] );

            // $amount = preg_match_all( 
            //     $regex,
    
            //     $post->post_content,
    
            //     $galleries,
    
            //     PREG_SET_ORDER
            // );
        // }

		$ids = self::get_gallery_shortcodes_attr_ids( $galleries );

        return $ids;
    }

	public static function get_subfield_names( $subfields )
	{
		return array_column( $subfields, 'name' );
	}

	public static function get_field_names( $field, $subfields = [] )
	{
		$field_names = [];

		$subfield_names = self::get_subfield_names( $subfields );

		foreach ( $subfield_names as $subfield_name )
		{
			$field_names[] = sprintf(
				self::PATTERNS[ 'group-field' ],
				
				$field[ 'name' ],
	
				$subfield_name
			);
		}

		return $field_names;
	}

	public static function get_origin_post_ids( $post_id, $post )
	{
		$origin_post_ids = [];

		$field_names = self::get_field_names( self::FIELDS[ 'about' ], self::FIELD_ABOUT );

		foreach ( $field_names as $field_name )
		{
			if ( $origin_post_id = MultisiteACF::get_field_raw( $field_name, $post_id ) )
			{
				$origin_post_ids[ $field_name ] = $origin_post_id;
			}
		}

		return $origin_post_ids;
	}

	public static function set_attachments( $post_id, $post )
    {
		$origin_post_ids = self::get_origin_post_ids( $post_id, $post );

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'set_attachments',

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );

		foreach ( $origin_post_ids as $field_name => $origin_post_id )
		{
			// LegalDebug::debug( [
			// 	'MultisiteAttachmentSync' => 'set_attachments',

			// 	'origin_post_id' => $origin_post_id,
			// ] );

			if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
			{
				MultisiteACF::update_field( $field_name, $post_moved_id, $post_id );

				// LegalDebug::debug( [
				// 	'MultisiteAttachmentSync' => 'set_attachments',
		
				// 	'post_moved_id' => $post_moved_id,
				// ] );
			}
		}

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'set_attachments',
		// ] );
    }
}

?>
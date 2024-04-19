<?php

class MultisiteTermSync
{
	// const POST_TYPE = [
    //     'billet' => 'legal_billet',
    // ];

	const FIELDS_SIMPLE = [
		'compilation-type' => [
			'name' => 'compilation-type',

			'key' => 'field_64943cb4bd61f',
		],

		'compilation-filter' => [
			'name' => 'compilation-filter',

			'key' => 'field_64943cb4bd61f',
		],

		'_yoast_wpseo_primary_category' => [
			'name' => '_yoast_wpseo_primary_category',

			'key' => '',
		],
	];

	const FIELDS_REPEATER = [
		'billet-feture-bonus' => [
			'name' => 'billet-feture-bonus',

			'key' => 'field_651ab4be3b28d',

			'fields' => [
				'feature-id' => [
					'name' => 'billet-feture-id',
		
					'key' => 'field_651ab5083b28e',
				],
			],
		],

		'billet-list-parts' => [
			'name' => 'billet-list-parts',

			'key' => 'field_6412f442f2c53',

			'fields' => [
				'feature-id' => [
					'name' => 'billet-list-part-feature',
		
					'key' => 'field_6492f753cfa1c',
				],
			],
		],

		'billet-feture-achievement' => [
			'name' => 'billet-feture-achievement',

			'key' => 'field_651aa238a7b35',

			'fields' => [
				'feature-id' => [
					'name' => 'billet-feture-id',
		
					'key' => 'field_651aa298e2e4a',
				],

				'achievement-id' => [
					'name' => 'billet-achievement-id',
		
					'key' => 'field_651aa2e4e2e4b',
				],
			],
		],

		'billet-profit-items' => [
			'name' => 'billet-profit-items',

			'key' => 'field_64340371d58e4',

			'fields' => [
				'feature-id' => [
					'name' => 'profit-item-feature',
		
					'key' => 'field_643403cbd58e5',
				],

				'pair-id' => [
					'name' => 'profit-item-pair',
		
					'key' => 'field_649c318052136',
				],
			],
		],

		'billet-feture-main-description' => [
			'name' => 'billet-feture-main-description',

			'key' => 'field_6523a4f9e9751',

			'fields' => [
				'feature-id' => [
					'name' => 'billet-feture-id',
		
					'key' => 'field_6523b09bdf712',
				],
			],
		],
	];

	const PATTERNS = [
		'edit-post' => 'edit_post_%s',
	];

	const ROW_FIELDS = [
		'feature' => 'feature-id',

		'achievement' => 'achievement-id',

		'pair' => 'pair-id',
	];

	public static function register_functions_subsite()
    {
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			MultisiteAdmin::add_filter_all(
				MultisiteAdmin::PATTERNS[ 'handle-bulk-actions' ],
				
				// MultisiteAdmin::POST_TYPES_CUSTOM,
				
				MultisiteAdmin::get_post_types_post(),
				
				$handler,
				
				'mc_bulk_action_sync_terms',
				
				10,
				
				3
			);

			// MultisiteAdmin::add_filter_all(
			// 	self::PATTERNS[ 'edit-post' ],
				
			// 	MultisitePost::POST_TYPES,
				
			// 	$handler,
				
			// 	'set_terms',
				
			// 	10,
				
			// 	2
			// );
			
			// add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_terms' ], 10, 2 );

			// add_action( 'edit_form_after_title', [ $handler, 'mc_debug_edit_form_after_title_action' ] );
		}
	}

	public static function mc_bulk_action_sync_terms( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		// LegalDebug::die( [
		// 	'MultisiteTermSync' =>'mc_bulk_action_sync_terms',

		// 	'doaction' => $doaction,

		// 	'check_doaction' => MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-terms' ] ),
		// ] );

		if ( MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-terms' ] ) )
		{
			foreach ( $object_ids as $post_id )
			{
				self::set_terms( $post_id );
			}

			$redirect = MultisiteAdmin::redirect_set(
				$redirect,
				
				MultisiteAdmin::QUERY_ARG[ 'terms-synced' ],
				
				count( $object_ids ),
				
				MultisiteBlog::get_current_blog_id()
			);
		}

		return $redirect;
	}

	// function mc_debug_edit_form_after_title_action( $post )
	// {
	// 	$post = get_post();

	// 	self::set_terms( $post->ID, $post );
	// }

	public static function get_repeaters( $post_id, $fields_repeater = [] )
	{
		$repeaters = [];

		if ( empty( $fields_repeater) )
		{
			$fields_repeater = self::FIELDS_REPEATER;
		}

		// foreach ( self::FIELDS_REPEATER as $repeater )
		
		foreach ( $fields_repeater as $repeater )
		{
			$repeater_name = $repeater[ 'name' ];

			if ( $repeater_value = MultisiteACF::get_field( $repeater_name, $post_id ) )
			{
				$repeaters[ $repeater_name ] = $repeater_value;
			}
		}

		return $repeaters;
	}

	public static function get_field_names()
	{
		// $group_field_names = MultisiteAttachmentSync::get_group_field_names( self::FIELDS[ 'review-about' ], self::FIELD_REVIEW_ABOUT );

		$group_field_names = [];

		// $simple_field_names = [
		// 	self::FIELDS[ 'compilation-type' ][ 'name' ],

		// 	self::FIELDS[ 'compilation-filter' ][ 'name' ],
		// ];

		$simple_field_names = array_column( self::FIELDS_SIMPLE, 'name' );

		return array_merge( $group_field_names, $simple_field_names );
	}

	public static function get_fields( $post_id, $simple_fields = [] )
	{
		$fields = [];

		if ( empty( $simple_fields ) )
		{
			// $simple_fields = self::FIELDS;
			
			$simple_fields = self::get_field_names();
		}

		// foreach ( self::FIELDS as $field )
		
		// foreach ( $simple_fields as $field )
		
		foreach ( $simple_fields as $field_name )
		{
			// $field_name = $field[ 'name' ];

			if ( $field_value = MultisiteACF::get_field_raw( $field_name, $post_id ) )
			{
				$fields[ $field_name ] = $field_value;
			}
		}

		return $fields;
	}

	public static function get_field_name( $repeater_name, $row_field, $fields_repeater = [] )
	{
		if ( empty( $fields_repeater ) )
		{
			$fields_repeater = self::FIELDS_REPEATER;
		}

		// if ( !empty( self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ $row_field ][ 'name' ] ) )
		// {
		// 	return self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ $row_field ][ 'name' ];
		// }
		
		if ( !empty( $fields_repeater[ $repeater_name ][ 'fields' ][ $row_field ][ 'name' ] ) )
		{
			return $fields_repeater[ $repeater_name ][ 'fields' ][ $row_field ][ 'name' ];
		}

		return false;
	}
	
	public static function get_pair( $field_value )
	{
		$field_value_parts = explode( '-', $field_value );

		$moved_from_id = $field_value_parts[ 2 ];

		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'get_pair',

		// 	'field_value' => $field_value,

		// 	'field_value_parts' => $field_value_parts,

		// 	'moved_from_id' => $moved_from_id,
		// ] );

		// $term_id = self::get_term_moved_id( $moved_from_id );
		
		if ( $term_id = self::get_term_id( $moved_from_id ) )
		{
			return str_replace( $moved_from_id, $term_id, $field_value );
		}

		return false;
	}

	public static function get_array( $field_value_parts )
	{
		foreach ( $field_value_parts as $key => $field_value_part )
		{
			if ( $field_value = self::get_term_id( $field_value_part ) )
			{
				$field_value_parts[ $key ] = $field_value;
			}
		}

		return $field_value_parts;
	}

	public static function get_term_id( $field_value )
	{
		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'get_term_id',

		// 	'field_value' => $field_value,

		// 	'get_term_moved_id' => self::get_term_moved_id( $field_value ),

		// 	'get_post_moved_id' => MultisitePost::get_post_moved_id( $field_value ),
		// ] );

		if ( $term_id = self::get_term_moved_id( $field_value ) )
		{
			return $term_id;
		}

		if ( $post_id = MultisitePost::get_post_moved_id( $field_value ) )
		{
			return $post_id;
		}

		return false;
	}
	
	public static function get_field_value_sync( $field_name, $field_value )
	{
		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'get_field_value_sync',

		// 	'field_name' => $field_name,

		// 	'field_value' => $field_value,
		// ] );

		if ( is_numeric( $field_value ) )
		{
			// LegalDebug::debug( [
			// 	'MultisiteTermSync' => 'get_field_value_sync',

			// 	'get_term_id' => self::get_term_id( $field_value ),
			// ] );

			return self::get_term_id( $field_value );
		}

		if ( is_array( $field_value ) )
		{
			return self::get_array( $field_value );
		}
		
		if ( is_string( $field_value ) )
		{
			return self::get_pair( $field_value );
		}

		return false;
	}

	public static function sync_row( $repeater_name, $repeater_row, $row_fields = [], $fields_repeater = [] )
	{
		if ( empty( $row_fields ) )
		{
			$row_fields = self::ROW_FIELDS;
		}

		// foreach ( self::ROW_FIELDS as $row_field )
		
		foreach ( $row_fields as $row_field )
		{
			if ( $field_name = self::get_field_name( $repeater_name, $row_field, $fields_repeater ) )
			{
				// $field_value = $repeater_row[ $field_name ];
				
				// LegalDebug::debug( [
				// 	'MultisiteTermSync' =>'sync_row',
	
				// 	'field_name' => $field_name,
				// ] );

				// if ( $field_value )
				
				if ( $field_value = $repeater_row[ $field_name ] )
				{
					// LegalDebug::debug( [
					// 	'MultisiteTermSync' =>'sync_row',
	
					// 	'field_value' => $field_value,
					// ] );

					// $field_value_sync = false;

					// if ( is_numeric( $field_value ) )
					// {
					// 	$field_value_sync = self::get_term_id( $field_value );
					// }
					// else
					// {
					// 	if ( is_array( $field_value ) )
					// 	{
					// 		$field_value_sync = self::get_array( $field_value );
					// 	}
					// 	else
					// 	{
					// 		if ( is_string( $field_value ) )
					// 		{
					// 			$field_value_sync = self::get_pair( $field_value );
					// 		}
					// 	}
					// }

					// if ( $field_value_sync )
					
					if ( $field_value_sync = self::get_field_value_sync( $field_name, $field_value ) )
					{
						// LegalDebug::debug( [
						// 	'MultisiteTermSync' =>'sync_row',
		
						// 	'field_value_sync' => $field_value_sync,
						// ] );

						$repeater_row[ $field_name ] = $field_value_sync;
					}

					// $term_id = self::get_term_moved_id( $field_value );
	
					// if ( $term_id )
					// {
					// 	$repeater_row[ $field_name ] = $term_id;
					// }

					// $repeater_row[ $field_name ] = $term_id;
				}
			}
		}

		return $repeater_row;

		// $feature_id_name = self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ 'feature-id' ][ 'name' ];

		// if ( ! empty( $repeater_row[ $feature_id_name ] ) )
		// {
		// 	$term_id = self::get_term_moved_id( $repeater_row[ $feature_id_name ] );

		// 	if ( $term_id )
		// 	{
		// 		$repeater_row[ $feature_id_name ] = $term_id;

		// 		// $repeater_value[ $row_number ] = $repeater_row;
		// 	}
		// }
	}

	// const ROW_FIELDS = [
	// 	'feature' => 'feature-id',

	// 	'achievement' => 'achievement-id',

	// 	'pair' => 'pair-id',
	// ];

	// public static function check_repeater_has_field( $repeater_name, $field_name )
	// {
	// 	if ( ! empty( self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ $field_name ] ) )
    //     {
    //         return true;
    //     }

	// 	return false;
	// }

	public static function sync_repeater( $repeater_name, $repeater_value, $row_fields = [], $fields_repeater = [] )
	{
		// if ( self::check_repeater_has_field( $repeater_name, self::ROW_FIELDS[ 'feature' ] ) )
		// {
		// 	foreach ( $repeater_value as $row_number => $repeater_row )
		// 	{
		// 		$repeater_value[ $row_number ] = self::sync_row_feature_id( $repeater_name, $repeater_row );
		// 	}
		// }

		// if ( self::check_repeater_has_field( $repeater_name, self::ROW_FIELDS[ 'achievement' ] ) )
		// {
		// 	foreach ( $repeater_value as $row_number => $repeater_row )
		// 	{
		// 		$repeater_value[ $row_number ] = self::sync_row_achievement_id( $repeater_name, $repeater_row );
		// 	}
		// }

		// if ( self::check_repeater_has_field( $repeater_name, self::ROW_FIELDS[ 'pair' ] ) )
		// {
		// 	foreach ( $repeater_value as $row_number => $repeater_row )
		// 	{
		// 		$repeater_value[ $row_number ] = self::sync_row_pair_id( $repeater_name, $repeater_row );
		// 	}
		// }

		foreach ( $repeater_value as $row_number => $repeater_row )
		{
			$repeater_value[ $row_number ] = self::sync_row( $repeater_name, $repeater_row, $row_fields, $fields_repeater );

			// $feature_id_name = self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ 'feature-id' ][ 'name' ];

			// if ( ! empty( $repeater_row[ $feature_id_name ] ) )
			// {
			// 	$term_id = self::get_term_moved_id( $repeater_row[ $feature_id_name ] );

			// 	if ( $term_id )
			// 	{
			// 		$repeater_row[ $feature_id_name ] = $term_id;

			// 		$repeater_value[ $row_number ] = $repeater_row;
			// 	}
			// }
		}

		return $repeater_value;
	}

	// public static function set_terms( $post_id, $post )
	
	public static function set_terms( $post_id )
    {
		$repeaters = self::get_repeaters( $post_id );

		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'set_terms',

		// 	'repeaters' => $repeaters,
		// ] );

		foreach ( $repeaters as $repeater_name => $repeater_value )
		{
			$repeater_value = self::sync_repeater( $repeater_name, $repeater_value );

			MultisiteACF::update_field( $repeater_name, $repeater_value, $post_id );

			// foreach ( $repeater_value as $row_number => $repeater_row )
			// {
			// 	$feature_id_name = self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ 'feature-id' ][ 'name' ];

			// 	if ( ! empty( $repeater_row[ $feature_id_name ] ) )
			// 	{
			// 		$term_id = self::get_term_moved_id( $repeater_row[ $feature_id_name ] );
	
			// 		if ( $term_id )
			// 		{
			// 			$repeater_row[ $feature_id_name ] = $term_id;
	
			// 			$repeater_value[ $row_number ] = $repeater_row;
			// 		}
			// 	}
			// }

			// LegalDebug::debug( [
			// 	'MultisiteTermSync' => 'set_terms',

			// 	'repeater_value' => $repeater_value,
			// ] );
		}

		$fields = self::get_fields( $post_id );

		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'set_terms',

		// 	'fields' => $fields,
		// ] );

		foreach ( $fields as $field_name => $field_value )
		{
			if ( $field_value_sync = self::get_field_value_sync( $field_name, $field_value ) )
			{
				// LegalDebug::debug( [
				// 	'MultisiteTermSync' => 'set_terms',

				// 	'field_name' => $field_name,

				// 	'field_value' => $field_value,

				// 	'field_value_sync' => $field_value_sync,
				// ] );

				MultisiteACF::update_field( $field_name, $field_value_sync, $post_id );

				// LegalDebug::debug( [
				// 	'MultisiteTermSync' => 'set_terms',

				// 	'get_field_raw' => MultisiteACF::get_field_raw( $field_name, $post_id ),
				// ] );
			}
		}
    }

	public static function get_term_moved_id_args( $origin_post_id )
	{
		return [
            'taxonomy' => MultisiteTerms::get_taxonomies(),

            'meta_query' => [

                'relation' => 'AND',

                'mc-moved-from' => [

                    'key' => MultisiteMeta::POST_META[ 'moved-from' ],

					'value' => $origin_post_id,

                    'compare' => '=',
                ],
			],
        ];
	}

	public static function get_term_moved_id( $origin_post_id )
	{
		$args = self::get_term_moved_id_args( $origin_post_id );

		$terms = get_terms( $args );

		LegalDebug::die( [
			'MultisiteMeta' => 'get_post_moved_id',

			'origin_post_id' => $origin_post_id,

			'args' => $args,

			'terms' => count( $terms ),
		] );

		if ( count( $terms ) == 1 )
		{
			$term = array_shift( $terms );

			return $term->term_id;
		}

		return false;
	}
}

?>
<?php

class MultisiteTermSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',
    ];

	const FIELDS = [
		'compilation-filter' => [
			'name' => 'compilation-filter',

			'key' => 'field_64943cb4bd61f',
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

	// const FIELD_FETURE_BONUS = [
	// 	'feature-id' => [
	// 		'name' => 'billet-feture-id',

	// 		'key' => 'field_651ab5083b28e',
	// 	],
	// ];

	// const FIELD_LISTS = [
	// 	'feature-id' => [
	// 		'name' => 'billet-list-part-feature',

	// 		'key' => 'field_6492f753cfa1c',
	// 	],
	// ];

	// const FIELD_ACHIEVEMENTS = [
	// 	'feature-id' => [
	// 		'name' => 'billet-feture-id',

	// 		'key' => 'field_651aa298e2e4a',
	// 	],
	// ];

	// const FIELD_PROFITS = [
	// 	'feature-id' => [
	// 		'name' => 'profit-item-feature',

	// 		'key' => 'field_643403cbd58e5',
	// 	],
	// ];

	// const FIELD_MAIN_DESCRIPTIONS = [
	// 	'feature-id' => [
	// 		'name' => 'billet-feture-id',

	// 		'key' => 'field_6523b09bdf712',
	// 	],
	// ];

	public static function register_functions_admin()
    {
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();
			
			add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_terms' ], 10, 2 );

			add_action( 'edit_form_after_title', [ $handler, 'mc_debug_edit_form_after_title_action' ] );
		}
	}

	function mc_debug_edit_form_after_title_action( $post )
	{
		$post = get_post();

		self::set_terms( $post->ID, $post );
	}

	public static function get_repeaters( $post_id )
	{
		foreach ( self::FIELDS_REPEATER as $repeater )
		{
			$repeater_name = $repeater[ 'name' ];

			$repeater_value = MultisiteACF::get_field( $repeater_name, $post_id );
			
			$repeaters[ $repeater_name ] = $repeater_value;
		}

		return $repeaters;
	}

	public static function get_filed_name( $repeater_name, $row_field )
	{
		if ( !empty( self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ $row_field ][ 'name' ] ) )
		{
			return self::FIELDS_REPEATER[ $repeater_name ][ 'fields' ][ $row_field ][ 'name' ];
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
		if ( $term_id = self::get_term_moved_id( $field_value ) )
		{
			return $term_id;
		}

		return false;
	}

	const ROW_FIELDS = [
		'feature' => 'feature-id',

		'achievement' => 'achievement-id',

		'pair' => 'pair-id',
	];

	public static function sync_field( $field_name, $field_value )
	{
		if ( is_numeric( $field_value ) )
		{
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

	public static function sync_row( $repeater_name, $repeater_row )
	{
		foreach ( self::ROW_FIELDS as $row_field )
		{
			if ( $field_name = self::get_filed_name( $repeater_name, $row_field ) )
			{
				// $field_value = $repeater_row[ $field_name ];
				
				// LegalDebug::debug( [
				// 	'MultisiteTermSync' =>'sync_row',
	
				// 	'field_name' => $field_name,

				// 	'field_value' => $field_value,
				// ] );

				// if ( $field_value )
				
				if ( $field_value = $repeater_row[ $field_name ] )
				{
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
					
					if ( $field_value_sync = self::sync_field( $field_name, $field_value ) )
					{
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

	public static function sync_repeater( $repeater_name, $repeater_value )
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
			$repeater_value[ $row_number ] = self::sync_row( $repeater_name, $repeater_row );

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

	public static function set_terms( $post_id, $post )
    {
		$repeaters = self::get_repeaters( $post_id );

		// LegalDebug::debug( [
		// 	'MultisiteTermSync' => 'set_terms',

		// 	'repeaters' => $repeaters,
		// ] );

		foreach ( $repeaters as $repeater_name => $repeater_value )
		{
			$repeater_value = self::sync_repeater( $repeater_name, $repeater_value );

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

			MultisiteACF::update_field( $repeater_name, $repeater_value, $post_id );

			// LegalDebug::debug( [
			// 	'MultisiteTermSync' => 'set_terms',

			// 	'repeater_value' => $repeater_value,
			// ] );
		}

		foreach ( self::FIELDS as $field_name => $field_value )
		{
			if ( $field_value_sync = self::sync_field( $field_name, $field_value ) )
			{
				MultisiteACF::update_field( $field_name, $field_value, $post_id );
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

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'get_post_moved_id',

		// 	'origin_post_id' => $origin_post_id,

		// 	'args' => $args,

		// 	'posts' => count( $posts ),
		// ] );

		if ( count( $terms ) == 1 )
		{
			$term = array_shift( $terms );

			return $term->term_id;
		}

		return false;
	}
}

?>
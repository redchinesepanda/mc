<?php

class MultisiteTermSync
{
	const POST_TYPE = [
        'billet' => 'legal_billet',
    ];

	const FIELDS = [
	];

	const FIELDS_REPEATER = [
		'feture-bonus' => [
			'name' => 'billet-feture-bonus',

			'key' => 'field_651ab4be3b28d',

			'fields' => [
				'feature-id' => [
					'name' => 'billet-feture-id',
		
					'key' => 'field_651ab5083b28e',
				],
			],
		],

		'lists' => [
			'name' => 'billet-list-parts',

			'key' => 'field_6412f442f2c53',

			'fields' => [
				'feature-id' => [
					'name' => 'billet-list-part-feature',
		
					'key' => 'field_6492f753cfa1c',
				],
			],
		],

		// 'achievements' => [
		// 	'name' => 'billet-feture-achievement',

		// 	'key' => 'field_651aa238a7b35',
		// ],

		// 'profits' => [
		// 	'name' => 'billet-profit-items',

		// 	'key' => 'field_64340371d58e4',
		// ],

		// 'main-descriptions' => [
		// 	'name' => 'billet-feture-main-description',

		// 	'key' => 'field_6523a4f9e9751',
		// ],
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

	const FIELD_ACHIEVEMENTS = [
		'feature-id' => [
			'name' => 'billet-feture-id',

			'key' => 'field_651aa298e2e4a',
		],
	];

	const FIELD_PROFITS = [
		'feature-id' => [
			'name' => 'profit-item-feature',

			'key' => 'field_643403cbd58e5',
		],
	];

	const FIELD_MAIN_DESCRIPTIONS = [
		'feature-id' => [
			'name' => 'billet-feture-id',

			'key' => 'field_6523b09bdf712',
		],
	];

	public static function register_functions_admin()
    {
		// if ( MultisiteBlog::check_not_main_blog() )
		// {
			$handler = new self();
			
			// add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_terms' ], 10, 2 );

			add_action( 'edit_form_after_title', [ $handler, 'mc_debug_edit_form_after_title_action' ] );
		// }
	}

	function mc_debug_edit_form_after_title_action( $post )
	{
		$post = get_post();

		self::set_terms( $post, $post->ID );

		// $all_terms = self::get_post_terms( $post->ID );

		// self::add_post_terms( $post->ID, $terms );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'mc_debug_edit_form_after_title_action',

		// 	'all_terms' => $all_terms,
		// ] );

		// foreach ( $all_terms as $taxonomy => $terms )
		// {
		// 	foreach ( $terms as $term )
		// 	{
		// 		LegalDebug::debug( [
		// 			'MultisiteTerms' => 'mc_debug_edit_form_after_title_action',

		// 			'term_id' => $term->term_id,

		// 			'slug' => $term->slug,
	
		// 			'movef-from' => MultisiteMeta::get_term_moved_from( $term->term_id ),
		// 		] );
		// 	}
		// }
	}

	// public static function get_features( $field_repeater, $repeater_value )
	// {
	// 	return array_column( $repeater_value, $field_name, $field_name );
	// }

	public static function get_repeaters( $post_id )
	{
		// $fields_repeater = array_column( self::FIELDS_REPEATER, 'name' );

		// $repeaters = [];

		// foreach ( $fields_repeater as $field_name )
		
		foreach ( self::FIELDS_REPEATER as $repeater )
		{
			$repeater_value = MultisiteACF::get_field( $repeater[ 'name' ], $post_id );

			$field_name = $repeater[ 'fields' ][ 'feature-id' ][ 'name' ];

			$feature_value = array_column( $repeater_value, $field_name, $field_name );

			// $repeaters[] = [
			// 	'name' => $field_repeater[ 'name' ],

			// 	$field_repeater[ 'fields' ][ 'feature-id' ][ 'name' ] => $feature_value,
			// ];

			$repeaters[ $repeater[ 'name' ] ] = $feature_value;
		}

		return $repeaters;
	}

	public static function set_terms( $post_id, $post )
    {
		$repeaters = self::get_repeaters( $post_id );

		LegalDebug::debug( [
			'MultisiteTermSync' => 'set_terms',

			'repeaters' => $repeaters,
		] );

		// foreach ( $repeaters as $field_name => $field_value )
		// {
		// 	$feature_ids = self::get_features( $field_value );

		// 	foreach ( $feature_ids as $row => $feature_id )
		// 	{
		// 		$term_id = self::get_term_moved_id( $feature_id );

		// 		LegalDebug::debug( [
		// 			'MultisiteTermSync' => 'set_terms',

		// 			'row' => $row,

		// 			'term_id' => $term_id,
		// 		] );

		// 		if ( $term_id )
		// 		{
		// 			$value = [
		// 				$repeaters[ $repeater_name ][ 'fields' ][ 'feature-id' ][ 'name' ] => $term_id
		// 			];

		// 			LegalDebug::debug( [
        //                 'MultisiteTermSync' => 'set_terms',

		// 				'repeater_name' =>$repeater_name,

		// 				'row' => $row,

		// 				'value' => $value,

		// 				'post_id' => $post_id,
		// 			] );

		// 			// update_row( $repeater_name, $row, $value, $post_id);
		// 		}
		// 	}
		// }

		// $origin_post_ids = self::get_origin_post_ids( $post_id, $post );

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'set_attachments',

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );

		// foreach ( $origin_post_ids as $field_name => $origin_post_id )
		// {
		// 	// LegalDebug::debug( [
		// 	// 	'MultisiteAttachmentSync' => 'set_attachments',

		// 	// 	'origin_post_id' => $origin_post_id,
		// 	// ] );

		// 	if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
		// 	{
		// 		MultisiteACF::update_field( $field_name, $post_moved_id, $post_id );

		// 		// LegalDebug::debug( [
		// 		// 	'MultisiteAttachmentSync' => 'set_attachments',
		
		// 		// 	'post_moved_id' => $post_moved_id,
		// 		// ] );
		// 	}
		// }

		// LegalDebug::debug( [
		// 	'MultisiteAttachmentSync' => 'set_attachments',
		// ] );
    }

	public static function get_term_moved_id_args( $origin_post_id )
	{
		return [
            // 'numberposts' => -1,

            'taxonomy' => MultisiteTerms::get_taxonomies(),

			// 'post_status' => self::POST_STATUSES,

            // 'suppress_filters' => 0,

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
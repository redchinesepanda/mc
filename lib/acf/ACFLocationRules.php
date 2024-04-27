<?php

class ACFLocationRules
{
	public static function register()
    {
        $handler = new self();

		add_filter( 'acf/location/rule_types', [ $handler, 'add_location_rules_types' ] );

		add_filter( 'acf/location/rule_values/post_type', [ $handler, 'add_location_rule_values_post_type' ] );

		add_filter( 'acf/location/rule_match/user', [ $handler, 'add_location_rule_match_post_type' ], 10, 4 );

		// add_filter( 'acf/location/rule_operators', [ $handler, 'add_location_rules_operators' ] );
	}

	function add_location_rules_types( $choices )
	{
		$choices[ 'MC' ][ 'post_type_slug' ] = 'Post Type Slug';

		return $choices;	
	}
	const TAXONOMIES_PAGE = [
		'page-type' => 'page_type',
	];

	public static function get_taxonomies()
	{
		return self::TAXONOMIES_PAGE;
	}

	public static function get_terms_args()
	{
		// return 'category';

		return [
            'taxonomy' => self::get_taxonomies(),

			'hide_empty' => false,
        ];
	}

	public static function get_terms()
	{
		$args = self::get_terms_args();

		$terms = get_terms( $args );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'get_post_moved_id',

		// 	'origin_post_id' => $origin_post_id,

		// 	'args' => $args,

		// 	'terms' => count( $terms ),
		// ] );

		return $terms;
	}

	function add_location_rule_values_post_type( $choices )
	{
		$terms = self::get_terms();

		foreach( $terms as $term )
		{	
			$choices[ $term->slug ] = $term->name;
			
		}

		return $choices;
	}
	
	function add_location_rule_match_post_type( $match, $rule, $options, $field_group )
	{
		// $current_user = wp_get_current_user();

		// $selected_user = (int) $rule[ 'value' ];
		
		$selected_slug = (int) $rule[ 'value' ];

		if( $rule[ 'operator' ] == "==" )
		{
			// $match = ( $current_user->ID == $selected_user );
			
			return has_term( $selected_slug );
		}
		
		if( $rule[ 'operator' ] == "!=" )
		{
			// $match = ( $current_user->ID != $selected_user );

			return ! has_term( $selected_slug );
		}

		// return $match;

		return false;
	}

	// By default, this list has '==' and '!=' operators

	// function add_location_rules_operators( $choices )
	// {	
	// 	$choices['<'] = 'is less than';

	// 	$choices['>'] = 'is greater than';

	// 	return $choices;	
	// }
}

?>
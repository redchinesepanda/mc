<?php

class ACFLocationRules
{
	public static function register()
    {
        $handler = new self();

		add_filter( 'acf/location/rule_types', [ $handler, 'add_location_rules_types' ] );

		add_filter( 'acf/location/rule_values/page_type_slug', [ $handler, 'add_location_rule_values_page_type_slug' ] );

		add_filter( 'acf/location/rule_match/page_type_slug', [ $handler, 'add_location_rule_match_page_type_slug' ], 10, 4 );

		// add_filter( 'acf/location/rule_operators', [ $handler, 'add_location_rules_operators' ] );
	}

	function add_location_rules_types( $choices )
	{
		$choices[ 'MC' ][ 'page_type_slug' ] = 'Page Type Slug';

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

	function add_location_rule_values_page_type_slug( $choices )
	{
		$terms = self::get_terms();

		foreach( $terms as $term )
		{	
			$choices[ $term->slug ] = $term->name;
			
		}

		return $choices;
	}
	
	function check_has_term( $selected_slug )
	{
		return has_term( $selected_slug, self::TAXONOMIES_PAGE[ 'page-type' ] );
	}

	function check_not_has_term( $selected_slug )
	{
		return ! self::check_has_term( $selected_slug );
	}

	function add_location_rule_match_page_type_slug( $match, $rule, $options, $field_group )
	{
		// $current_user = wp_get_current_user();

		// $selected_user = (int) $rule[ 'value' ];

		// LegalDebug::debug( [
		// 	'ACFLocationRules' => 'add_location_rule_match_page_type_slug',

		// 	'match' => $match,

		// 	'rule' => $rule,

		// 	'check_has_term' => self::check_has_term( $rule[ 'value' ] ),

		// 	'check_not_has_term' => self::check_not_has_term( $rule[ 'value' ] ),
		// ] );

		if ( $rule[ 'operator' ] == "==" )
		{
			// $match = ( $current_user->ID == $selected_user );
			
			return self::check_has_term( $rule[ 'value' ] );
		}
		
		if ( $rule[ 'operator' ] == "!=" )
		{
			// $match = ( $current_user->ID != $selected_user );

			return self::check_not_has_term( $rule[ 'value' ] );
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
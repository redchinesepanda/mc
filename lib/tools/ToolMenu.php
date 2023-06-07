<?php

class ToolMenu
{
	public static function get_parents( $menu_items )
	{
		return array_map( function( $menu_item ) {
			return $menu_item->menu_item_parent;
		}, $menu_items );
	}

	public static function array_search_values( $m_needle, $a_haystack, $b_strict = false){
		return array_intersect_key( $a_haystack, array_flip( array_keys( $a_haystack, $m_needle, $b_strict ) ) );
	}
}

?>
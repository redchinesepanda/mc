<?php

class ToolMenu
{
	public static function array_search_values( $m_needle, $a_haystack, $b_strict = false){
		return array_intersect_key( $a_haystack, array_flip( array_keys( $a_haystack, $m_needle, $b_strict)));
	}
}

?>
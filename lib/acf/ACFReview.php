<?php

class ACFReview
{
    // const FIELD = [
	// 	'about' => 'review-about',

	// 	'anchors' => 'review-anchors',
	// ];

    // const ANCHORS = [
	// 	'id' => 'anchor-id',

	// 	'label' => 'anchor-label',
	// ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . ReviewAnchors::FIELD[ 'anchors' ], [ $handler, 'supply_field' ] );
    }

    public static function supply_field( $field )
    {
		$field[ 'instructions' ] = implode( '<br />', self::get() );

        return $field;
    }

	public static function get()
	{
		$anchors = ReviewAnchors::get_labels();

		$args = [];
		
		foreach( $anchors as $id => $label ) {
			$args[] = $id . ' ( ' . $label . ' )';
		}

		return $args;
	}
}

?>
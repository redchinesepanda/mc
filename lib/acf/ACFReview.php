<?php

class ACFReview
{
    const FIELD = [
		'about' => 'review-about',

		'anchors' => 'review-anchors',
	];

    const ANCHORS = [
		'id' => 'anchor-id',

		'label' => 'anchor-label',
	];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'anchors' ], [ $handler, 'supply_field' ] );
    }

    public static function supply_field( $field )
    {
		$anchors = ReviewAnchors::get_labels();

		$field[ 'instructions' ] = implode( '<br />', $anchors );;

        return $field;
    }
}

?>
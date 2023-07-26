<?php

class ACFReview
{
	const FIELD = [
        'link' => 'author-link-items',
	];

	const LINK = [
        'image' => 'link-item-image',
	];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . ReviewAnchors::FIELD[ 'anchors' ], [ $handler, 'supply_field' ] );

		add_filter( 'acf/load_field/name=' . self::LINK[ 'image' ], [ $handler, 'choices_image' ] );
    }

	function choices_image( $field )
    {
        $choices[ 'link-linkedin' ] = 'Linkedin';

        $choices[ 'link-twitter' ] = 'Twitter';

        $field[ 'choices' ] = $choices;

        return $field;
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
<?php

class ACFReview
{
	const FIELD = [
        'link' => 'author-link-items',

        'about' => 'review-about',
	];

	const LINK = [
        'image' => 'link-item-image',
	];

	const ABOUT = [
        'afillate' => 'about-afillate',
	];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . ReviewAnchors::FIELD[ 'anchors' ], [ $handler, 'supply_field' ] );

		add_filter( 'acf/load_field/name=' . ReviewAuthor::LINK_ITEM[ 'image' ], [ $handler, 'choices_image' ] );

        add_filter('acf/format_value/name=' . self::ABOUT[ 'afillate' ], [ $handler, 'format_afillate' ], 10, 3 );
    }

    public static function format_afillate( $value, $post_id, $field )
    {
        LegalDebug::debug( [
            'value'=> $value,

            'post_id'=> $post_id,

            'field'=> $field,
        ] );
        
        return $value;
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
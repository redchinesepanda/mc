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

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'anchors' ], [ $handler, 'choices' ] );
    }

    public static function choices( $field )
    {
		$field[ 'instructions' ] = 'test';

		// LegalDebug::debug( [
		// 	'field' => $field,
		// ] );

        // $items = WPMLTrid::get();

        // if ( !empty( $items ) ) {
        //     foreach( $items as $item ) {
        //         $title = get_post_meta( $item->legal_element_id, self::FIELD_LABEL, true );

        //         if ( $title ) {
        //             $item->legal_title .= ' ( ' . $title . ' )';
        //         }

        //         $field['choices'][$item->legal_trid] = $item->legal_title . ' [' . $item->legal_language_codes . ']'; 
        //     }
        // }

        // $field['default_value'] = WPMLTrid::get_trid();

        return $field;
    }
}

?>
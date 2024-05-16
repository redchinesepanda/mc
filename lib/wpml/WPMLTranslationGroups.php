<?php

class WPMLTranslationGroups
{
    const POST_TYPE = [
		'page' => 'page',
	];

    const TAXONOMY = [
		'translation_group' => 'translation_group',
	];

    const FIELDS = [
        'trid' => 'page-translation-group',

        // 'label' => 'page-translation-group-label',
    ];

    const PATTERN = [
        'trid-slug' => 'trid-%1$s',
    ];

    // const FIELD_TRID = 'page-translation-group';

    // const FIELD_LABEL = 'page-translation-group-label';

    // const JS = LegalMain::LEGAL_URL . '/assets/js/acf/acf-page.js';

    // public static function register_script()
    // {
    //     wp_register_script( 'acf-page', self::JS, [], false, true);

    //     wp_enqueue_script( 'acf-page' );
    // }

    public static function register()
    {
        $handler = new self();

        add_filter( 'edit_post_' . self::POST_TYPE[ 'page' ], [ $handler, 'set_translation_group' ], 10, 2 );

        // add_filter( 'acf/load_field/name=' . self::FIELD_TRID, [ $handler, 'choices' ] );

        // add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    public static function set_translation_group( $post_id, $post )
    {
        $trid = get_field( self::FIELDS[ 'trid' ], $post_id );

        LegalDebug::die( [
            'WPMLTranslationGroups' =>'set_translation_group',

            'post_id' => $post_id,

            'post' => $post,

            'trid' => $trid,
        ] );

        if ( $trid )
        {
            $slugs = [
                sprintf( self::PATTERN[ 'trid-slug' ], $trid ),
            ];

			$term_ids = wp_set_object_terms( $post_id, $slugs, self::TAXONOMY[ 'translation_group' ], false );
        }
    }

    // public static function choices( $field )
    // {
    //     $items = WPMLTrid::get();
        
    //     // $items = [];

    //     $choices = [];

    //     if ( !empty( $items ) ) {
    //         foreach( $items as $item ) {
    //             $title = get_post_meta( $item->legal_element_id, self::FIELD_LABEL, true );

    //             if ( $title ) {
    //                 $item->legal_title .= ' ( ' . $title . ' )';
    //             }

    //             $choices[$item->legal_trid] = $item->legal_title . ' [' . $item->legal_language_codes . ']'; 
    //         }
    //     }

    //     $field['choices'] = $choices;

    //     // $field['default_value'] = WPMLTrid::get_trid();

    //     $field['value'] = WPMLTrid::get_trid();

    //     // LegalDebug::debug( [
    //     // 	'function' => 'ACFPage::choices',

    //     // 	'field' => $field,
    //     // ] );

    //     return $field;
    // }
}

?>
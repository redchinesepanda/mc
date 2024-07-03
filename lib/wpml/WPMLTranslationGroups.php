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
    
    // public static function register_functions_debug()
	// {
	// 	$handler = new self();

	// 	add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );

	// 	// add_action( 'category_pre_edit_form', [ $handler, 'mc_category_pre_edit_form_debug' ], 10, 2 );
	// }

    // function mc_edit_form_after_title_debug( $post )
	// {
    //     $trid = WPMLTrid::get_trid( $post->ID );

	// 	LegalDebug::debug( [
	// 		'WPMLTranslationGroups' => 'mc_edit_form_after_title_debug',

	// 		'trid' => $trid,
	// 	] );
    // }

    public static function register_functions_admin()
    {
        $handler = new self();

        add_filter( 'edit_post_' . self::POST_TYPE[ 'page' ], [ $handler, 'set_translation_group' ], 10, 2 );

        // add_filter( 'acf/load_field/name=' . self::FIELD_TRID, [ $handler, 'choices' ] );

        // add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    public static function set_translation_group( $post_id, $post )
    {
        // $trid = get_field( self::FIELDS[ 'trid' ], $post_id );
        
        $trid = WPMLTrid::get_trid( $post_id );

        // LegalDebug::die( [
        //     'WPMLTranslationGroups' =>'set_translation_group',

        //     'trid' => $trid,

        //     'post_id' => $post_id,

        //     'post' => $post,
        // ] );

        if ( $trid )
        {
            if ( ! has_term( '', self::TAXONOMY[ 'translation_group' ] ) )
            {
                $slugs = [
                    sprintf( self::PATTERN[ 'trid-slug' ], $trid ),
                ];
    
                $term_ids = wp_set_object_terms( $post_id, $slugs, self::TAXONOMY[ 'translation_group' ], false );

                // LegalDebug::debug( [
                //     'WPMLTranslationGroups' =>'set_translation_group',

                //     'trid' => $trid,

                //     'term_ids' => $term_ids,
                // ] );

                if ( ! is_wp_error( $term_ids ) )
                {
                    foreach ( $term_ids as $term_id )
                    {
                        $term = term_exists( $term_id, self::TAXONOMY[ 'translation_group' ] );
        
                        if ( ! empty( $term ) )
                        {
                            if ( empty( $term->name ) )
                            {
                                $args = [
                                    'name' => $post->post_title . ' [' . $trid . ']',
                                ];
                
                                wp_update_term( $term_id, self::TAXONOMY[ 'translation_group' ], $args );
                            }
                        }
                    }

                    update_field( self::FIELDS[ 'trid' ], $post_id, $trid );
                }
            }
        }
    }

    public static function get_translation_group( $post_id )
    {
        $terms_args = [
            'fields' => 'slugs',
        ];

        $terms = wp_get_object_terms( $post_id, self::TAXONOMY[ 'translation_group' ], $terms_args );

        // LegalDebug::debug( [
        //     'WPMLTranslationGroups' => 'get_translation_group',

        //     'terms' => $terms,
        // ] );

        if ( is_wp_error( $terms ) )
        {
            return [];
        }

        return $terms;
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
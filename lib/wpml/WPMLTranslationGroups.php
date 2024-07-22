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

    public static function check_add_bulk_actions()
	{
		return MultisiteMain::check_multisite()
		
			&& MultisiteBlog::check_main_blog();
	}

    public static function register_functions_admin()
    {
        // $handler = new self();

        // add_filter( 'edit_post_' . self::POST_TYPE[ 'page' ], [ $handler, 'set_translation_group' ], 10, 2 );

        // add_filter( 'acf/load_field/name=' . self::FIELD_TRID, [ $handler, 'choices' ] );

        // add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );

        if ( self::check_add_bulk_actions() )
        {
            $handler = new self();

            add_filter( 'bulk_actions-edit-page', [ $handler, 'add_translation_group_item' ] );

            add_filter( 'handle_bulk_actions-edit-page', [ $handler, 'handle_translation_group_item' ], 10, 3);

            add_action('admin_notices', [ $handler, 'notify_translation_group_item' ] );
        }
    }

    const ACTION = [
        'set-translation-group'=> 'set-translation-group',

        'done-translation-group'=> 'done-translation-group',
    ];

    public static function notify_translation_group_item()
    {
    	if ( ! empty( $_REQUEST[ self::ACTION[ 'set-translation-group' ] ] ) )
        {
    		$num_changed = (int) $_REQUEST[ self::ACTION[ 'set-translation-group' ] ];

    		// printf( '<div id="message" class="updated notice is-dismissable"><p>' . __('Published %d posts.', 'txtdomain') . '</p></div>', $num_changed );

    		$message = sprintf( ToolLoco::translate( 'Translation group set for %d posts' ), $num_changed );

            $args = [
                'message' => $message,
			];

            self::print_notices( $args );
    	}
    }

    public static function redirect_clean( $redirect )
	{
		return remove_query_arg( self::ACTION, $redirect );
	}

    public static function handle_translation_group_item( $redirect_url, $action, $post_ids )
    {
        if ( $action == self::ACTION[ 'set-translation-group' ] )
        {
            $redirect = self::redirect_clean( $redirect );
    	
    		foreach ( $post_ids as $post_id )
            {
    			// wp_update_post( [
    			// 	'ID' => $post_id,
    			// 	'post_status' => 'publish'
    			// ] );

                $post = get_post( $post_id );

                if ( $post )
                {
                    self::set_translation_group( $post_id, $post );
                }
    		}

    		$redirect_url = add_query_arg( self::ACTION[ 'done-translation-group' ], count( $post_ids ), $redirect_url );
    	}

    	return $redirect_url;
    }

    public static function add_translation_group_item( $bulk_actions )
    {
    	$bulk_actions[ self::ACTION[ 'set-translation-group' ] ] = ToolLoco::translate( 'Set Translation Group' );

    	return $bulk_actions;
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

    public static function get_translation_group_trid( $translation_groups )
    {
        if ( ! empty( $translation_groups ) )
        {
            $trid = array_shift( $translation_groups );

            return str_replace( 'trid-', '', $trid );
        }

        return null;
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

    const TEMPLATE = [
        'translation-groups-notices' => LegalMain::LEGAL_PATH . '/template-parts/wpml/wpml-translation-groups-notices.php',
    ];

    public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'translation-groups-notices' ], $args );
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
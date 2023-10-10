<?php

class AdminTaxonomy
{
    const TAXONOMY = [
        'page' => [
            'page_type',

            'page_group',

            'offer_group',
        ],

        // 'legal_bk_review' => [
        //     'page_type',

        //     'page_group',
        // ],

        'legal_billet' => [
            'billet_type',

            'billet_feature',
        ],
    ];

    public static function register()
    {
        $handler = new self();

        add_action( 'restrict_manage_posts', [ $handler, 'filter_dropdown'] );

        add_filter( 'parse_query', [ $handler, 'query_term'] );
    }

    public static function filter_dropdown()
    {
        global $typenow;

        foreach ( self::TAXONOMY as $post_type => $taxonomies )
        {
            foreach ( $taxonomies as $taxonomy )
            {
                // LegalDebug::debug( [
                //     'post_type' => $post_type,
                // ] );

                if ( $typenow == $post_type ) {
                    $selected = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
        
                    $info_taxonomy = get_taxonomy( $taxonomy );

                    wp_dropdown_categories( [
                        'show_option_all' => sprintf( __( 'Show all %s', ToolLoco::TEXTDOMAIN ), $info_taxonomy->label ),
                        
                        'taxonomy'        => $taxonomy,
                        
                        'name'            => $taxonomy,
                        
                        'orderby'         => 'name',
                        
                        'selected'        => $selected,
                        
                        'show_count'      => true,
                        
                        'hide_empty'      => true,
                    ] );
                };
            }

            // LegalDebug::debug( [
            //     'typenow' => $typenow,

            //     'taxonomies' => $taxonomies,
            // ] );
        }
    }

    function query_term( $query )
    {
        global $pagenow;

        foreach ( self::TAXONOMY as $post_type => $taxonomies )
        {
            foreach ( $taxonomies as $taxonomy )
            {
                $q_vars = &$query->query_vars;

                if ( $pagenow == 'edit.php'

                    && isset( $q_vars['post_type'] )

                    && $q_vars['post_type'] == $post_type

                    && isset( $q_vars[$taxonomy] )

                    && is_numeric( $q_vars[$taxonomy] )

                    && $q_vars[$taxonomy] != 0
                )
                {
                    $term = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );

                    $q_vars[ $taxonomy ] = $term->slug;
                }
            }
        }
    }
}

?>
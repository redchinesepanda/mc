<?php

class AdminTaxonomy
{
    // const TAXONOMY = [
    //     'page' => 'page_type',

    //     'legal_billet' => 'billet_type',

    //     'legal_billet' => 'billet_feature',
    // ];

    const TAXONOMY = [
        'page' => [
            'page_type',
        ],

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

    public static function filter_dropdown() {
        global $typenow;

        // $message['fucntion'] = 'filter_dropdown';

        // $message['get_locale'] = get_locale();

        foreach ( self::TAXONOMY as $post_type => $taxonomies ) {
            foreach ( $taxonomies as $taxonomy ) {
                if ($typenow == $post_type) {
                    $selected = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';
        
                    $info_taxonomy = get_taxonomy( $taxonomy );
        
                    // $message['ToolLoco::TEXTDOMAIN'] = ToolLoco::TEXTDOMAIN;

                    // $message['Show all %s'] = __( 'Show all %s', ToolLoco::TEXTDOMAIN );

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
        }

        // self::debug( $message );
    }

    function query_term( $query )
    {
        global $pagenow;

        foreach ( self::TAXONOMY as $post_type => $taxonomies ) {
            foreach ( $taxonomies as $taxonomy ) {
                $q_vars = &$query->query_vars;

                if ( $pagenow == 'edit.php'
                    && isset( $q_vars['post_type'] )
                    && $q_vars['post_type'] == $post_type
                    && isset( $q_vars[$taxonomy] )
                    && is_numeric( $q_vars[$taxonomy] )
                    && $q_vars[$taxonomy] != 0
                ) {
                    $term = get_term_by( 'id', $q_vars[$taxonomy], $taxonomy );

                    $q_vars[$taxonomy] = $term->slug;
                }
            }
        }
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
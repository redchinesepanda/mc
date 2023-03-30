<?php

class AdminPage
{
    public static function register()
    {
        $handler = new self();

        add_action( 'restrict_manage_posts', [ $handler, 'tsm_filter_post_type_by_taxonomy'] );

        add_filter( 'parse_query', [ $handler, 'tsm_convert_id_to_term_in_query'] );
    }

    public static function tsm_filter_post_type_by_taxonomy() {
        global $typenow;

        $post_type = 'page';
        
        $taxonomy  = 'page_type';
        
        if ($typenow == $post_type) {
            $selected = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';

            $info_taxonomy = get_taxonomy( $taxonomy );

            wp_dropdown_categories( [
                'show_option_all' => sprintf( __( 'Show all %s', 'textdomain' ), $info_taxonomy->label ),
                
                'taxonomy'        => $taxonomy,
                
                'name'            => $taxonomy,
                
                'orderby'         => 'name',
                
                'selected'        => $selected,
                
                'show_count'      => true,
                
                'hide_empty'      => true,
            ] );
        };
    }

    function tsm_convert_id_to_term_in_query($query)
    {
        global $pagenow;

        $post_type = 'page';
        
        $taxonomy = 'page_type';
        
        $q_vars = &$query->query_vars;

        if ( $pagenow == 'edit.php'
            && isset($q_vars['post_type'])
            && $q_vars['post_type'] == $post_type
            && isset($q_vars[$taxonomy])
            && is_numeric($q_vars[$taxonomy])
            && $q_vars[$taxonomy] != 0
        ) {
            $term = get_term_by( 'id', $q_vars[$taxonomy], $taxonomy );

            $q_vars[$taxonomy] = $term->slug;
        }
    }
}

?>
<?php

class ReviewGroup
{
    const CSS = [
        'review-group' => LegalMain::LEGAL_URL . '/assets/css/review/review-group.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-group]

        add_shortcode( 'legal-group', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    const TAXONOMY = 'page_group';

    public static function get()
    {
        $post = get_post();

        if ( empty( $post ) )
            return [];

        $terms = wp_get_post_terms( $post->ID, self::TAXONOMY, [ 'fields' => 'ids' ] );

        $posts = get_posts( [
            'numberposts' => -1,

            'post_type' => [ 'page', 'legal_bk_review' ],

            'suppress_filters' => 0,

            'exclude' => $post->ID,

            'tax_query' => [
                'relation' => 'OR',
                
                [
                    'taxonomy' => self::TAXONOMY,

                    'field' => 'term_id',

                    'terms' => $terms,

                    'operator' => 'IN',
                ]
            ],

            'orderby' => 'menu_order',

            'order' => 'ASC',
        ] );

        LegalDebug::debug( [
            '$terms' => $terms,

            '$posts' => count( $posts ),
        ] );

        $items[ 'current' ] = [
            'label' => $post->post_title,
        ];

        $items[ 'other' ] = [];

        if ( !empty( $posts ) ) {
            foreach ( $posts as $post ) {
                $items[ 'other' ][] = [
                    'label' => $post->post_title,
    
                    'href' => get_post_permalink( $post->ID ),
                ];
            }
        }

        return $items;
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-group.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
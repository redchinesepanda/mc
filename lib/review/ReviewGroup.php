<?php

class ReviewGroup
{
    const CSS = [
        'review-group' => LegalMain::LEGAL_URL . '/assets/css/review/review-group.css',
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

    public static function register()
    {
        $handler = new self();

        // [legal-group]

        add_shortcode( 'legal-group', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    const TAXONOMY = 'page_group';

    public static function get_group_args( $post, $terms = [] ) {
        return [
            'numberposts' => -1,

            'post_type' => [ 'legal_bk_review', 'page' ],

            'suppress_filters' => 0,

            'exclude' => $post->ID,

            'tax_query' => [
                [
                    'taxonomy' => self::TAXONOMY,

                    'field' => 'term_id',

                    'terms' => $terms,

                    'operator' => 'IN',
                ]
            ],

            'orderby' => 'menu_order',

            'order' => 'ASC',
        ];
    }

    public static function get_item_label( $post )
    {
        $label = $post->post_title;

        $group = get_field( ReviewAbout::FIELD );

        if ( $group ) {
            $label = $group[ 'about-title' ];
        }

        if ( in_array( $post->post_type, [ 'legal_bk_review' ] ) ) {
            $label .= ' ' . __( 'Review', ToolLoco::TEXTDOMAIN );
        }

        return $label;
    }

    public static function get()
    {
        $post = get_post();

        if ( empty( $post ) ) {
            return [];
        }

        $items[ 'current' ] = [
            'label' => self::get_item_label( $post ),
        ];

        $terms = wp_get_post_terms( $post->ID, self::TAXONOMY, [ 'fields' => 'ids' ] );

        $posts = get_posts( self::get_group_args( $post, $terms ) );

        $items[ 'other' ] = [];

        if ( !empty( $posts ) ) {
            foreach ( $posts as $post ) {

                $items[ 'other' ][] = [
                    'label' => self::get_item_label( $post ),
    
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
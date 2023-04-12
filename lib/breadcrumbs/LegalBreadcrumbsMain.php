<?php

class LegalBreadcrumbsMain extends LegalDebug
{
    const CSS = [
        'legal-breadcrumbs-main' => LegalMain::LEGAL_URL . '/assets/css/breadcrumbs/legal-breadcrumbs-main.css',
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

        // [legal-breadcrumbs]

        add_shortcode( 'legal-breadcrumbs', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    const FIELD_ANCESTOR = 'breadcrumbs-ancestor';

    public static function get_ancestors( $id )
    {
        $post = get_post( $id );

        $ancestor_id = get_field( self::FIELD_ANCESTOR, $id );

        // self::debug( [
        //     'ancestor_id' => $ancestor_id,
        // ] );

        if ( ! $post || empty( $ancestor_id ) || $ancestor_id == $id ) {
            return [];
        }

        $ancestors[] = $ancestor_id;

        while ( $ancestor = get_post( $ancestor_id ) ) {
            // Loop detection: If the ancestor has been seen before, break.

            $parent_id = get_field( self::FIELD_ANCESTOR, $ancestor->ID );

            if ( empty( $parent_id ) || ( $parent_id == $id ) || in_array( $parent_id, $ancestors, true ) ) {
                break;
            }

            $ancestor_id = $parent_id;

            $ancestors[] = $parent_id;
        }

        return $ancestors;
    }

    public static function get_home_url()
    {
        if ( get_option( 'show_on_front' ) === 'page' ) {
			$homepage_id = get_option( 'page_on_front' );

			if ( empty( $homepage_id ) ) {
				$homepage_url = get_option( 'home' );
			} else {
				$homepage_url = get_page_link( $homepage_id );
			}
		} else {
			$homepage_url = get_option( 'home' );
		}

        // self::debug( [
        //     'homepage_url' => $homepage_url,
        // ] );

        return $homepage_url;
    }

    public static function get_item( $text, $href, &$index )
    {
        $link = [];

        if ( !empty( $href ) ) {
            $link = [
                'href' => $href,

                'itemprop' => 'item',
            ];
        }

        return [
            'title' => [
                'text' => $text,

                'itemprop' => 'name',
            ],

            'link' => $link,

            'meta' => [
                'content' => $index ++,

                'itemprop' => 'position',
            ],
        ];
    }

    const FIELD_HIDE = 'breadcrumbs-hide-parent';

    public static function get()
    {
        $post = get_post();

        $index = 1;

        $items[] = self::get_item( __( 'Match.Center', ToolLoco::TEXTDOMAIN ), self::get_home_url(), $index );

        if ( !empty( $post ) ) {
            if ( empty( get_field( self::FIELD_HIDE, $post->ID ) ) ) {
                if ( $post->post_parent ) {
                    $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
    
                    foreach ( $ancestors as $id ) {
                        $items[] = self::get_item( get_the_title( $id ), get_page_link( $id ), $index );
                    }
                }
                $items = array_merge( $items, self::get_ancestors( $post->ID ) );
            }

            $items[] = self::get_item( $post->post_title, '', $index );
        }

        self::debug( [
            'items' => $items,
        ] );

        return $items;
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/breadcrumbs/part-breadcrumbs-main.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

}

?>
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

        self::debug( [
            'homepage_url' => $homepage_url,
        ] );

        return $homepage_url;
    }

    public static function get_item( $text, $href, &$index )
    {
        $link = [];

        if ( !empty( $href ) ) {
            $link = [
                'href' => $link,

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

    const FIELD = 'breadcrumbs-hide-parent';

    public static function get()
    {
        $post = get_post();

        $index = 1;

        $items[] = self::get_item( __( 'Match.Center', ToolLoco::TEXTDOMAIN ), self::get_home_url(), $index );

        if ( !empty( $post ) ) {
            if ( $post->post_parent && empty( get_field( self::FIELD, $post->ID ) ) ) {
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );

				foreach ( $ancestors as $id ) {
                    $items[] = self::get_item( get_the_title( $id ), get_page_link( $id ), $index );
				}
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
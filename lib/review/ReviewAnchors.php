<?php

class ReviewAnchors
{
    const CSS = [
        'review-anchors' => LegalMain::LEGAL_URL . '/assets/css/review/review-anchors.css',
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

        // [legal-anchors]

        add_shortcode( 'legal-anchors', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'the_content', [ $handler, 'content' ], 1 );
    }

    const TERM = 'bookmaker-review';

    public static function content( $content )
    {
        if ( has_term( self::TERM, 'page_type' ) ) {
            return self::target( $content );
        }
    
        return $content;
    }

    public static function get_dom( $content )
	{
		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		return $dom;
	}

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/a/@id' );

		return $nodes;
	}

    public static function target()
    {
        // $dom = new DomDocument();

        // $dom->loadHTML( get_the_content() );

        $dom = self::get_dom( get_the_content() );

        $nodes = self::get_nodes( $dom );

        LegalDebug::debug( [
            '$nodes' => $nodes,
        ] );

        // foreach ( $dom->getElementsByTagName( 'h2' ) as $key => $item ) {
        //     $link = $dom->createElement( 'a' );

        //     $link->setAttribute( 'class', 'legal-target' );

        //     $link->setAttribute( 'name', 'target-' . $key );

        //     $item->appendChild( $link );
        // }

        return $dom->saveHTML();
    }

    // const FIELD = 'review-anchors';

    const FIELD = 'review-about';

    public static function title()
    {
        $group = get_field( self::FIELD );
        
        if( $group ) {
            return $group[ 'about-title' ];
        }

        return get_the_title();
    }

    public static function get()
    {
        $dom = new DomDocument();

        $dom->loadHTML( get_the_content() );

        $items = [];

        $title = self::title() . ' ';

        foreach ( $dom->getElementsByTagName( 'h2' ) as $key => $item ) {
            $items[] = [
                'href' => '#target-' . $key,

                'label' => str_replace ( $title, '', $item->nodeValue),
            ];
        }

        return [
            'label' => __( 'Page contents', ToolLoco::TEXTDOMAIN ) . ':',

            'items' => $items,
        ];
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-anchors.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
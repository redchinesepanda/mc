<?php

class ToolEnqueue
{
    public static function register_style( $styles = [] )
    {
        foreach ( $styles as $name => $item ) {
            $path = $item;

            $ver = false;

            $deps = [];

            if ( is_array( $item ) ) {
                $path = $item[ 'path' ];

                $ver = $item[ 'ver' ];
            }

            wp_enqueue_style( $name, $path, $deps, $ver );
        }
    }

    public static function register_script( $scripts = [] )
    {
        foreach ( $scripts as $name => $item ) {
            $path = $item;

            $ver = false;

            $deps = [];

            // $args = [
            //     'in_footer' => false,

            //     'strategy' => 'async',
            // ];

            $args = true;

            if ( is_array( $item ) ) {
                $path = $item[ 'path' ];

                $ver = $item[ 'ver' ];

                if ( !empty( $item[ 'deps' ] ) )
                {
                    $deps = $item[ 'deps' ];
                }
            }

            wp_register_script( $name, $path, $deps, $ver, $args );

            wp_enqueue_script( $name );
        }
    }

	public static function register_inline_style( $name, $data )
    {
		wp_register_style( $name, false, [], true, true );
		
		wp_add_inline_style( $name, $data );
		
		wp_enqueue_style( $name );
    }

	public static function register_inline_script( $name, $data )
    {
        wp_register_script( $name, false, [], true, true );
        
        wp_localize_script( $name, str_replace( '-', '_', $name ), $data );
        
        wp_enqueue_script( $name );
    }

    public static function register()
    {
        $handler = new self();

		add_filter( 'style_loader_tag', [ $handler, 'link_type' ], 10, 2 );

        add_filter( 'wpml_hreflangs', [ $handler, 'change_page_hreflang' ] );
    }

    public static function link_type( $html, $handle )
	{
		$html = str_replace(
			"type='text/css'",

			"",

			$html
		);

		$html = str_replace(
			" />",

			">",

			$html
		);

		return $html;
	}
  
    public static function change_page_hreflang( $hreflang_items )
    {
        // Remove x-default  and set to some other langauge , SQ is the language code which to which the x-default will be set instead of the site default

        // $hreflang_items[ 'x-default' ] = $hreflang_items['sq'];
        
        // Exclude the language from hreflang Replace EN with the language code to be removed

        // unset( $hreflang_items[ 'en' ] );

        $hreflang = [];
        
        foreach ( $hreflang_items as $hreflang_code => $hreflang_url )
        {
            $hreflang[] = '<link rel="alternate" hreflang="' . esc_attr( $hreflang_code ) . '" href="' . esc_url( $hreflang_url ) . '">' . PHP_EOL;
        }

        echo apply_filters( 'wpml_hreflangs_html', implode( '', $hreflang ) );
            
        return false;
    }
}

?>
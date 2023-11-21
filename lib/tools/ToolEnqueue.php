<?php

class ToolEnqueue
{
    public static function dequeue_style( $styles = [] )
    {
        foreach ( $styles as $name )
        {
            wp_dequeue_style( $name );
        }
    }

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

	public static function register_inline_base( $name )
    {
		wp_register_style( $name, false, [], true, true );
    }

	public static function enqueue_inline_style( $name, $data )
    {
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

        add_filter( 'script_loader_tag', [ $handler, 'script_type' ], 10, 2 );

        add_action( 'wp_print_scripts', [ $handler, 'inspect_scripts' ], 999);
    }

    public static function inspect_scripts()
    {
        global $wp_scripts;

        LegalDebug::debug( [
            'function' => 'ToolEnqueue::inspect_scripts',

            'queue' => $wp_scripts->queue,
        ] );
        
    }

    // public static function crunchify_print_scripts_styles()
    // {
    //     $result = [];

    //     $result['scripts'] = [];

    //     $result['styles'] = [];
    
    //     // Print all loaded Scripts
    //     global $wp_scripts;

    //     foreach( $wp_scripts->queue as $script ) :
    //        $result['scripts'][ $script ] =  $wp_scripts->registered[$script]->src . ";";
    //     endforeach;
    
    //     // Print all loaded Styles (CSS)

    //     global $wp_styles;

    //     foreach( $wp_styles->queue as $style ) :
    //        $result['styles'][ $style ] =  $wp_styles->registered[$style]->src . ";";
    //     endforeach;
    
    //     return $result;
    // }

    public static function link_type( $html, $handle )
	{
        $html = str_replace(
			" type='text/css'",

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

    function script_type( $tag, $handle, $src = 'unset' )
    {
        $tag = str_replace(
			" type='text/javascript'",

			"",

			$tag
		);
                
        return $tag;
    }
}

?>
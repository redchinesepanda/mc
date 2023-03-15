<?php

class Head
{
	public static function register()
    {
        // $handler = new self();
		
        // add_action('wp_print_scripts', [ $handler, 'legal_remove_all_scripts' ], 100);

        // add_action('wp_print_styles', [ $handler, 'legal_remove_all_styles' ], 100);

        // Billet::register();
        
        Billet::print();
	}

    public static function print()
    {
        // do_action( 'wp_print_scripts' );

        // do_action( 'wp_print_styles' );

        // wp_head();
    }

    // public function legal_remove_all_scripts()
    // {
    //     global $wp_scripts;

    //     $message['function'] = 'legal_remove_all_scripts';

    //     foreach( $wp_scripts->queue as $handle ) {
    //         $message[] = '$handle: ' . $handle;

    //         wp_dequeue_script( $handle );

    //         wp_deregister_script( $handle );
    //     }

    //     echo '<pre>' . print_r( $message, true ) . '</pre>';

    //     // $wp_scripts->queue = [];
    // }
    
    // public function legal_remove_all_styles()
    // {
    //     global $wp_styles;

    //     $message['function'] = 'legal_remove_all_styles';

    //     foreach( $wp_styles->queue as $handle ) {
    //         $message[] = '$handle: ' . $handle;

    //         wp_dequeue_style( $handle );

    //         wp_deregister_style( $handle );
    //     }

    //     echo '<pre>' . print_r( $message, true ) . '</pre>';

    //     // $wp_styles->queue = [];
    // }
}

?>
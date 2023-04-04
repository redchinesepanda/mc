<?php

class YoastMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-main.php';

    private static function get()
    {
        // $message['function'] = 'get';

        $post = get_post();

        return [
            'title' => YoastSEO()->meta->for_post( $post->ID )->title,

            'description' => YoastSEO()->meta->for_post( $post->ID )->description,
            
            'keywords' => 'keywords',
            
            'author' => 'author',
        ];

        // $message['args'] = $args;

        // self::debug( $message );
    }

    public static function render2()
    {
        // $message['function'] = 'render';

        // $args = self::get();

        // $message['args'] = $args;

        // self::debug( $message );

        load_template( self::TEMPLATE, false, self::get() );
    }

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        echo $output;
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
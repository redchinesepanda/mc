<?php

class YoastMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-main.php';

    public static function get()
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

    public static function render()
    {
        $message['function'] = 'render';

        $args = self::get();

        $message['args'] = $args;

        load_template( self::TEMPLATE, false, $args );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
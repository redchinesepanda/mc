<?php

class YoastMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-main.php';

    public static function print()
    {
        $args = self::get();

        echo '<title>' . $args['title'] . '</title>';

        foreach ( $args['meta'] as $key => $value ) {
            echo '<meta name="' . $key . '" content="' . $value . '" />';
        }
    }

    private static function get()
    {
        // $message['function'] = 'get';

        $post = get_post();

        return [
            'title' => YoastSEO()->meta->for_post( $post->ID )->title,

            'meta' =>
            [
                'description' => YoastSEO()->meta->for_post( $post->ID )->description,
            
                'keywords' => 'keywords',
                
                'author' => 'author',

                'viewport' => 'width=device-width, initial-scale=1.0',
            ]
        ];

        // $message['args'] = $args;

        // self::debug( $message );
    }

    public static function render()
    {
        load_template( self::TEMPLATE, false, self::get() );
    }

    public static function render_ob()
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
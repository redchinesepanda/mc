<?php

class ToolBootsrap
{
	const CSS = [
        // <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

        'bootstrap-main' => [
            'path' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css',

            'ver' => '1.0.0',
        ],

		// <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

		'bootstrap-swiper' => [
            'path' => 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css',

            'ver' => '1.0.0',
        ],
    ];

	public static function style_attributes( $html, $handle )
    {
        if ( 'bootstrap-main' === $handle )
        {
            return str_replace( ">", "media='all' integrity='sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx' crossorigin='anonymous'>", $html );
        }

        return $html;
    }

	public static function check()
    {
		return !TemplateMain::check();
	}

	public static function register_style()
    {
        if ( self::check() )
		{

            ToolEnqueue::register_style( self::CSS );
        }
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'style_loader_tag', [ $handler, 'style_attributes' ], 10, 2 );
    }
}

?>
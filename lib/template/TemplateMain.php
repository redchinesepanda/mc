<?php

// require_once( 'TemplateBonus.php' );

// require_once( 'TemplateWiki.php' );

require_once( 'TemplateNotFound.php' );

require_once( 'TemplatePage.php' );

require_once( 'TemplateSingle.php' );

class TemplateMain
{
    public static function register_style_thrive()
    {
        $parent_style = 'parent-style';
    
        // wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [ $parent_style ], wp_get_theme()->get( 'Version' ) );
    }

    const DEQUEUE = [
        'thrive-theme-styles',

        'thrive-theme',
    ];

    public static function register()
    {
        // $handler = new self();

		// add_action( 'wp_enqueue_scripts', [ $handler, 'register_style_thrive' ] );

        // TemplateBonus::register();

        // TemplateWiki::register();

        TemplatePage::register();

        TemplateSingle::register();
    }

    public static function render()
    {
        return TemplateSingle::render();
    }
    
    public static function render_page()
    {
        return TemplatePage::render();
    }

    public static function render_notfound()
    {
		return TemplateNotFound::render();
    }

    public static function wp_head()
    {
		ob_start();
		
		wp_head();

        $output = ob_get_clean();

        $output = str_replace(
			" />",

			">",

			$output
		);

        $output = str_replace(
			" type='text/css'",

			"",

			$output
		);

        $output = str_replace(
			" type='text/javascript'",

			"",

			$output
		);

        return $output;
    }
}

?>
<?php

require_once( 'TemplateBonus.php' );

require_once( 'TemplateWiki.php' );

require_once( 'TemplateNotFound.php' );

require_once( 'TemplatePage.php' );

require_once( 'TemplateSingle.php' );

class TemplateMain
{
    public static function register()
    {
        TemplateBonus::register();

        TemplateWiki::register();

        TemplatePage::register();

        TemplateSingle::register();
    }

    public static function render()
    {
        // $result = TemplateBonus::render();

        // if ( empty( $result ) )
        // {
        //     $result = TemplateWiki::render_wiki_thrive();
        // }

        // if ( empty( $result ) )
        // {
        //     $result = TemplateWiki::render_wiki();
        // }

		// return $result;

        return TemplateSingle::render()
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
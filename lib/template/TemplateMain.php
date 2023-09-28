<?php

require_once( 'TemplateBonus.php' );

require_once( 'TemplateWiki.php' );

class TemplateMain
{
	public static function register()
    {
        TemplateBonus::register();
    }

    public static function render()
    {
		$output[] = TemplateBonus::render();

        $output[] = TemplateWiki::render();

        return implode( '', $output );
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

        return $output;
    }
}

?>
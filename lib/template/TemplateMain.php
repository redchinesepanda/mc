<?php

require_once( 'TemplateBonus.php' );

require_once( 'TemplateWiki.php' );

require_once( 'TemplateNotFound.php' );

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

    public static function render_notfound()
    {
		LegalDebug::debug( [
			'function' => 'TemplateMain::render_notfound',
		] );
		
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
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
}

?>
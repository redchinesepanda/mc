<?php

require_once( 'ToolLoco.php' );

require_once( 'ToolDisable.php' );

require_once( 'ToolPosts.php' );

require_once( 'ToolTinyMCE.php' );

class ToolsMain
{
    public static function register()
    {
        ToolLoco::register();

        ToolDisable::register();

        ToolPosts::register();

        ToolTinyMCE::register();
    }
}

?>
<?php

require_once( 'ToolDisable.php' );

require_once( 'ToolPosts.php' );

require_once( 'ToolLoco.php' );

class ToolsMain
{
    public static function register()
    {
        ToolDisable::register();

        ToolPosts::register();

        ToolLoco::register();
    }
}

?>
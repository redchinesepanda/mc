<?php

require_once( 'ToolLoco.php' );

require_once( 'ToolDisable.php' );

require_once( 'ToolPosts.php' );

require_once( 'ToolTinyMCE.php' );

require_once( 'ToolEncode.php' );

// require_once( 'ToolRewrite.php' );

require_once( 'ToolEnqueue.php' );

require_once( 'ToolMenu.php' );

require_once( 'ToolSitemap.php' );

require_once( 'ToolPrint.php' );

require_once( 'ToolTransiterate.php' );

// require_once( 'ToolNotFound.php' );

class ToolsMain
{
    public static function register()
    {
        ToolLoco::register();

        ToolDisable::register();

        ToolPosts::register();

        ToolTinyMCE::register();

        // ToolRewrite::register();
        
        ToolSitemap::register();

        // ToolNotFound::register();
    }
}

?>
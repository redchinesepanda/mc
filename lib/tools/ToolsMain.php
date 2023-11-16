<?php

// require_once( 'ToolDate.php' );

require_once( 'ToolDisable.php' );

require_once( 'ToolEncode.php' );

require_once( 'ToolEnqueue.php' );

require_once( 'ToolLoco.php' );

require_once( 'ToolMenu.php' );

require_once( 'ToolNotFound.php' );

require_once( 'ToolPDO.php' );

require_once( 'ToolPosts.php' );

require_once( 'ToolPrint.php' );

require_once( 'ToolSitemap.php' );

require_once( 'ToolStats.php' );

require_once( 'ToolTinyMCE.php' );

require_once( 'ToolTransiterate.php' );

require_once( 'ToolShortcode.php' );

require_once( 'ToolTimezone.php' );

class ToolsMain
{
    public static function register()
    {
        ToolDisable::register();

        ToolEnqueue::register();

        ToolLoco::register();

        ToolNotFound::register();

        ToolPosts::register();
        
        ToolSitemap::register();

        ToolStats::register();

        ToolTinyMCE::register();
    }
}

?>
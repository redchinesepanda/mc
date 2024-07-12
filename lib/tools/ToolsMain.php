<?php

// require_once( 'ToolDate.php' );

require_once( 'ToolDisable.php' );

require_once( 'ToolEncode.php' );

require_once( 'ToolEnqueue.php' );

require_once( 'ToolLoco.php' );

require_once( 'ToolMenu.php' );

// require_once( 'ToolNotFound.php' );

// require_once( 'ToolPDO.php' );

// require_once( 'ToolPosts.php' );

// require_once( 'ToolPrint.php' );

require_once( 'ToolSitemap.php' );

// require_once( 'ToolStats.php' );

require_once( 'ToolTinyMCE.php' );

require_once( 'ToolTransiterate.php' );

require_once( 'ToolShortcode.php' );

require_once( 'ToolTimezone.php' );

require_once( 'ToolCSP.php' );

require_once( 'ToolBootsrap.php' );

require_once( 'ToolContent.php' );

require_once( 'ToolSitemapXML.php' );

require_once( 'ToolCategoryRedirect.php' );

require_once( 'ToolRobots.php' );

require_once( 'ToolRewrite.php' );

require_once( 'ToolPermalink.php' );

// require_once( 'ToolTaxonomy.php' );

require_once( 'ToolForbidden.php' );

class ToolsMain
{
    const TEXT = [
        'none' => 'None',

        'redirect' => 'Redirect Category to a Page',

        'if-set-you-can' => 'If set you can replace the WordPress category page with your own highly optimised landing page',
    ]; 

    public static function register()
    {
        ToolSitemapXML::register();

        // ToolRobots::register();

        // ToolTaxonomy::register();
    }

    public static function register_functions()
    {
        ToolDisable::register();

        ToolEnqueue::register();

        ToolLoco::register();

        // ToolNotFound::register();

        // ToolPosts::register();
        
        ToolSitemap::register();

        // ToolStats::register();

        ToolTinyMCE::register();

        ToolCSP::register();

        ToolBootsrap::register();

        ToolContent::register();

        ToolCategoryRedirect::register();

        ToolRobots::register();

        ToolSitemapXML::register_functions();
        
        ToolRewrite::register_functions();

        ToolForbidden::register();
    }

    public static function register_functions_admin()
    {
        ToolPermalink::register_functions_admin();
    }
}

?>
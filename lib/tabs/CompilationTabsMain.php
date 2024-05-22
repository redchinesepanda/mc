<?php

require_once ( 'CompilationTabs.php' );

require_once ( 'CompilationTabsMini.php' );

require_once ( 'CompilationTabsLink.php' );

require_once ( 'LegalTabsInfo.php' );

class CompilationTabsMain
{
	public static function register_functions()
    {
		CompilationTabsMini::register_functions();

        CompilationTabsLink::register_functions();
	}

	public static function register()
    {
        CompilationTabs::register();

        CompilationTabsMini::register();

        LegalTabsInfo::register();
    }
} 

?>
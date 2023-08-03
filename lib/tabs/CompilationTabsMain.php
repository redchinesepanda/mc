<?php

require_once ( 'CompilationTabs.php' );

require_once ( 'CompilationTabsMini.php' );

class CompilationTabsMain
{
	public static function register()
    {
        CompilationTabs::register();

        CompilationTabsMini::register();
    }
} 

?>
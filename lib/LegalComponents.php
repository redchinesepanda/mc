<?php

require_once( 'billet/BilletMain.php' );

require_once( 'compilation/CompilationMain.php' );

// require_once( 'tabs/CompilationTabs.php' );

require_once( 'tabs/CompilationTabsMain.php' );

require_once( 'bonus/BonusMain.php' );

class LegalComponents
{
	public static function register()
	{
		BilletMain::register();

		CompilationMain::register();

		// CompilationTabs::register();
		
		CompilationTabsMain::register();

		BonusMain::register();
	} 
	
	public static function check()
    {
        $single = is_singular( 'page' );

        $term = has_term( 'compilation', 'page_type' );
        
        return $single && $term;
    }
}

?>
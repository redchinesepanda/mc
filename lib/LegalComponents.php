<?php

require_once( 'billet/BilletMain.php' );

require_once( 'compilation/CompilationMain.php' );

require_once( 'tabs/CompilationTabs.php' );

class LegalComponents
{
	public static function register()
	{
		BilletMain::register();

		CompilationMain::register();

		CompilationTabs::register();
	}
	
	public static function check()
    {
        $single = is_singular( 'page' );

        $term = has_term( 'compilation', 'page_type' );
        
        return ( $single && $term );
    }
}

?>
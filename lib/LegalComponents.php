<?php

require_once( 'billet/BilletMain.php' );

require_once( 'compilation/CompilationMain.php' );

require_once( 'tabs/CompilationTabsMain.php' );

require_once( 'bonus/BonusMain.php' );

require_once( 'template/TemplateMain.php' );

class LegalComponents
{
	public static function register()
	{
		if ( self::check() )
		{
			BilletMain::register();
	
			CompilationMain::register();
			
			CompilationTabsMain::register();
	
			BonusMain::register();
	
			TemplateMain::register();
		}
	} 
	
	public static function check()
    {
        $permission_single = is_singular( 'page' );

        $permission_term = has_term( 'compilation', 'page_type' );

		$permission_main = LegalMain::check();
        
        return $permission_single && $permission_term && $permission_main;
    }
}

?>
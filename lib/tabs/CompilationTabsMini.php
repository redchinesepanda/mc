<?php

class CompilationTabsMini
{
	public static function register()
    {
        $handler = new self();
        
		// [legal-bonus id='bonusy-kz']

        add_shortcode( 'legal-bonus', [ $handler, 'prepare' ] );
    }
}

?>
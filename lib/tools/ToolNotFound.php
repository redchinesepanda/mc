<?php

class ToolNotFound
{
	public static function check()
    {
		$not_logged_in = !is_user_logged_in();

		$singilar_custom = is_singular( [ 'legal_billet', 'legal_compilation' ] );

        return ( $not_logged_in && $singilar_custom );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'template_redirect', [ $handler, 'set_not_found' ] );
    }

	function set_not_found()
	{
		if ( self::check() )
		{
			global $wp_query;

			$wp_query->set_404();
		}
	}
}

?>
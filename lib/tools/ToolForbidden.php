<?php

class ToolForbidden
{
	const TEMPLATE = [
        'forbidden' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-forbidden.php',
    ];

	public static function render_forbidden()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'forbidden' ], self::get_forbidden_page() );
    }

	public static function register()
    {
        $handler = new self();
 
		add_action( 'wp', [ $handler, 'custom_forbidden_page' ] );
    }
	
	public static function get_forbidden_page()
	{
		return [
			'title' => '403 Forbidden',

			'description' => 'Access to this area is forbidden. Please go to the home page.',
		];
	}

	public static function custom_forbidden_page()
	{
		global $wp_query;
	
		if( isset( $_REQUEST[ 'status' ] ) && $_REQUEST[ 'status' ] == 403)
		{
			$wp_query->is_404 = FALSE;

			$wp_query->is_page = TRUE;

			$wp_query->is_singular = TRUE;

			$wp_query->is_single = FALSE;

			$wp_query->is_home = FALSE;

			$wp_query->is_archive = FALSE;

			$wp_query->is_category = FALSE;

			// add_filter( 'wp_title', 'custom_error_title', 65000, 2 );

			// add_filter( 'body_class', 'custom_error_class' );

			status_header( 403 );

			// get_template_part( '403' );

			echo self::render_forbidden();

			exit;
		}
	
		// if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401)
		// {
		// 	$wp_query->is_404 = FALSE;
		// 	$wp_query->is_page = TRUE;
		// 	$wp_query->is_singular = TRUE;
		// 	$wp_query->is_single = FALSE;
		// 	$wp_query->is_home = FALSE;
		// 	$wp_query->is_archive = FALSE;
		// 	$wp_query->is_category = FALSE;
		// 	add_filter('wp_title','custom_error_title',65000,2);
		// 	add_filter('body_class','custom_error_class');
		// 	status_header(401);
		// 	get_template_part('401');
		// 	exit;
		// }
	}
	
	// public static function custom_error_title($title='',$sep='')
	// {
	// 	if(isset($_REQUEST['status']) && $_REQUEST['status'] == 403)
	// 		return "Forbidden ".$sep." ".get_bloginfo('name');
	
	// 	if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401)
	// 		return "Unauthorized ".$sep." ".get_bloginfo('name');
	// }
	
	// public static function custom_error_class($classes)
	// {
	// 	if(isset($_REQUEST['status']) && $_REQUEST['status'] == 403)
	// 	{
	// 		$classes[]="error403";
	// 		return $classes;
	// 	}
	
	// 	if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401)
	// 	{
	// 		$classes[]="error401";
	// 		return $classes;
	// 	}
	// }
}

?>
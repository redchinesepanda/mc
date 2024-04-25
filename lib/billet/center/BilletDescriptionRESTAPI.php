<?php

class BilletDescriptionRESTAPI
{
	public static function register_functions()
	{
		// if ( self::check() )
		// {
			$handler = new self();
	
			add_action( 'rest_api_init', [ $handler, 'mc_restapi_get_description' ] );
		// }
	}

	public static function mc_restapi_get_description()
	{
		// пространство имен

		$namespace = 'myplugin/v1';
	
		// маршрут
		
		$route = '/author-posts/(?P<id>\d+)';

		$handler = new self();
	
		// параметры конечной точки (маршрута)
		
		$route_params = [
			'methods'  => 'GET',

			// 'callback' => 'my_awesome_func',
			
			'callback' => [ $handler, 'restapi_get_description_callback' ],

			'args'     => [
				'arg_str' => [
					'type'     => 'string', // значение параметра должно быть строкой

					'required' => true,     // параметр обязательный
				],

				'arg_int' => [
					'type'    => 'integer', // значение параметра должно быть числом

					'default' => 10,        // значение по умолчанию = 10
				],
			],

			'permission_callback' => function( $request )
			{
				// только авторизованный юзер имеет доступ к эндпоинту

				// return is_user_logged_in();

				return true
			},
		];
	
		register_rest_route( $namespace, $route, $route_params );
	
	}

	public static function restapi_get_description_callback( WP_REST_Request $request )
	{
		$posts = get_posts( [
			'author' => (int) $request['id'],
		] );
	
		if ( empty( $posts ) ) {
			return new WP_Error( 'no_author_posts', 'Записей не найдено', [ 'status' => 404 ] );
		}
	
		return $posts;
	}
}

?>
<?php

class BilletDescriptionAjax
{
	const NONCE = 'mc-ajax-billet';

	const ACTIONS = [
		'get-description' => 'mc_ajax_get_description',
	];

	const JS = [
        'mc-ajax-get-description' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-ajax-get-description.js',

			'ver' => '1.0.0',
		],
    ];

	private function get_ajax_general()
	{
		return [
			'mc-ajax-get-description' => [
				'object_name' => 'MCAjax',
	
				'data' => [
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				],
			],
		];
	}

	private function get_ajax_billet()
	{
		return [
			'mc-ajax-get-description' => [
				'object_name' => 'MCAjaxBillet',
	
				'data' => [
					'actionGetDescription' => self::ACTIONS[ 'get-description' ],

					'nonce' => wp_create_nonce( self::NONCE ),
				],
			],
		];
	}

	public static function register_script()
    {
		ToolEnqueue::register_script( self::JS );

		ToolEnqueue::localize_script( self::get_ajax_general() );

		ToolEnqueue::localize_script( self::get_ajax_billet() );
    }

	public static function register()
	{
		$handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

		add_action( 'wp_ajax_' . self::ACTIONS[ 'get-description' ], [ $handler, 'mc_ajax_get_description' ] );
	}

	public function mc_ajax_get_description()
	{
		check_ajax_referer( self::NONCE );

		$code = 0;

		$status = 'success';

		$message = [];
		
		// $post_id = 0;
		// if (array_key_exists('post_id', $_POST)) {
		// 	$post_id = $_POST['post_id'];
		// }
		// array_push($message, '$post_id: ' . $post_id);
		// $comment = '';
		// if (array_key_exists('comment', $_POST)) {
		// 	$comment = $_POST['comment'];
		// }
		// array_push($message, '$comment: ' . ($comment !='' ? 'set' : 'uset'));
		// $post_type = '';
		// if (array_key_exists('post_type', $_POST)) {
		// 	$post_type = $_POST['post_type'];
		// }
		// array_push($message, '$post_type: ' . $post_type);
		// $user_id = 0;
		// if (array_key_exists('user_id', $_POST)) {
		// 	$user_id = $_POST['user_id'];
		// }
		// array_push($message, '$user_id: ' . $user_id);
		// if ($post_id != 0 && $comment != '' && $user_id != 0) {
		// 	$manager = get_userdata($user_id);
		// 	$post_title = 'comment-for-post-' . $post_id . '-from-user-' . $user_id;
		// 	$new_comment = array(
		// 		'post_title'  => $post_title,
		// 		'post_content'  => sanitize_text_field($comment),
		// 		'post_type'   => 'idcrm_comments',
		// 		'post_author' => get_current_user_id(),
		// 		'post_status' => 'publish',
		// 	);
		// 	$new_event_id = wp_insert_post( $new_comment );
		// 	$idcrm_comments_iserted = true;
		// 	if( is_wp_error($new_event_id) ){
		// 		array_push($message, $post_id->get_error_message());
		// 		$idcrm_comments_iserted = false;
		// 	}
		// 	if ($new_event_id == 0) {
		// 		$code = 1;
		// 		$status = 'error';
		// 		array_push($message, 'Не удалось вставить запись');
		// 		$idcrm_comments_iserted = false;
		// 	}
		// 	if ($idcrm_comments_iserted) {
		// 		array_push($message, '$new_event_id: ' . $new_event_id);
		// 		/* $idcrm_company_id = get_post_meta( $post_id, 'idcrm_company_id', true );
		// 		$idcrm_contact_user_id = get_post_meta( $post_id, 'idcrm_contact_user_id', true );
		// 		$key = $idcrm_company_id ? 'idcrm_company_id' : 'idcrm_contact_user_id'; */
		// 		add_post_meta( $new_event_id, 'idcrm_contact_user_id', $post_id);
		// 		add_post_meta( $new_event_id, 'idcrm_event_timestring', current_time('timestamp')*1000 );
		// 	}
		// }
		// if (empty($message)) {
		// 	array_push($message, 'success');
		// }

		echo json_encode( [
			'code' => $code,
			
			'status' => $status,
			
			'message' => $message
		] );
		
		die();
	}
}

?>
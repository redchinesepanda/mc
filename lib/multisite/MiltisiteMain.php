<?php

require_once( 'MultisiteAdmin.php' );

require_once( 'MultisiteBlog.php' );

require_once( 'MultisiteMeta.php' );

require_once( 'MultisitePost.php' );

require_once( 'MultisiteTerms.php' );

require_once( 'MultisiteACF.php' );

require_once( 'MultisiteAttachment.php' );

require_once( 'MultisiteSync.php' );

class MiltisiteMain
{
	const TEXT = [
		'move-to' => 'Move to [%s]',
	];

	const TEXT_PLURAL = [
		'post-has-been-copied-to' => [
			'single' => '%d post has been copied to "%s".',

			'plural' => '%d posts have been copied to "%s".',
		],

		'image-has-been-copied-to' => [
			'single' => '%d image has been copied to &laquo;%s&raquo;.',

			'plural' => '%d images have been copied to &laquo;%s&raquo;.',
		],
	];

	public static function register_admin() {}

	public static function register_functions_admin()
	{
		MultisiteAdmin::register_functions_admin();

		MultisitePost::register_functions_admin();

		MultisiteMeta::register_functions_admin();

		MultisiteAttachment::register_functions_admin();

		MultisiteSync::register_functions_admin();
	}
}

?>
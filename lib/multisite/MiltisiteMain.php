<?php

require_once( 'MultisiteAdmin.php' );

require_once( 'MultisiteBlog.php' );

require_once( 'MultisiteMeta.php' );

require_once( 'MultisitePost.php' );

require_once( 'MultisiteTerms.php' );

require_once( 'MultisiteACF.php' );

require_once( 'MultisiteAttachment.php' );

require_once( 'MultisiteAttachmentSync.php' );

require_once( 'MultisiteTermSync.php' );

require_once( 'MultisiteGallerySync.php' );

require_once( 'MultisitePostSync.php' );

require_once( 'MultisiteShortcodeSync.php' );

require_once( 'MultisiteSiteSwitcher.php' );

require_once( 'MultisiteSiteOptions.php' );

require_once( 'MultisiteFront.php' );

class MiltisiteMain
{
	const TEXT = [
		'copy-to' => 'Copy to [%s]',

		'sync-galleries' => 'Sync Galleries',

		'sync-shortcodes' => 'Sync Shortcodes',

		'sync-terms' => 'Sync Terms',

		'sync-attachments' => 'Sync Attachments',

		'sync-posts' => 'Sync Posts',
	];

	const TEXT_PLURAL = [
		'post-has-been-copied-to' => [
			'single' => '%d post has been copied to "%s".',

			'plural' => '%d posts have been copied to "%s".',
		],

		'post-has-been-updated' => [
			'single' => '%d post has been updated in "%s".',

			'plural' => '%d posts have been updated in "%s".',
		],

		'image-has-been-copied-to' => [
			'single' => '%d image has been copied to &laquo;%s&raquo;.',

			'plural' => '%d images have been copied to &laquo;%s&raquo;.',
		],
	];

	public static function check_multisite()
	{
		return is_multisite();
	}

	public static function check()
	{
		return self::check_multisite();
	}

	public static function register_functions_admin()
	{
		MultisiteGallerySync::register_functions_debug();

		MultisiteMeta::register_functions_debug();

		MultisiteShortcodeSync::register_functions_debug();

		MultisiteSiteSwitcher::register_functions_debug();

		if ( MultisiteBlog::check_main_blog() )
		{
			MultisiteAdmin::register_functions_mainsite();

			MultisitePost::register_functions_mainsite();

			MultisiteAttachment::register_functions_mainsite();

			MultisiteSiteOptions::register_functions_mainsite();
		}
		else
		{
			MultisiteAdmin::register_functions_subsite();

			MultisiteAttachmentSync::register_functions_subsite();

			MultisiteGallerySync::register_functions_subsite();

			MultisiteTermSync::register_functions_subsite();

			MultisitePostSync::register_functions_subsite();

			MultisiteShortcodeSync::register_functions_subsite();

			MultisiteFront::register_functions_subsite();
		}
	}
}

?>
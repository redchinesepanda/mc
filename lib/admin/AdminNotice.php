<?php

class AdminNotice
{
	public static function register()
    {
        $handler = new self();

		add_action( 'admin_notices', [ $handler, 'wpb_admin_notice_warn' ] );
    }

	public static function wpb_admin_notice_warn() {
		echo self::render(); 
	}

	public static function get()
    {
        return  [
            'message' => __( 'This is test tite: ', ToolLoco::TEXTDOMAIN ) . get_site_url(),

            'name' => DB_NAME,

            'user' => DB_USER,
        ];
    }
	
	const TEMPLATE = [
        'notice' => LegalMain::LEGAL_PATH . '/template-parts/admin/part-notice.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'notice' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}
?>
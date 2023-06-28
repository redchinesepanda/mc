<?php

class AdminNotice
{
	public static function register()
    {
        $handler = new self();

		add_action( 'admin_notices', [ $handler, 'wpb_admin_notice_warn' ] );

        add_action( 'edit_form_after_title', [ $handler, 'legal_affilate_edit' ], 5 );
    }
    

    function check_affilate( $post )
    {
        return ( $post->post_type =='affiliate-links' );
    }

    function legal_affilate_edit( $post )
    {
        if ( self::check_affilate( $post ) )
        {
            echo self::render_rectangle( '<b>Внимание!</b> Не используйте слог <b>go</b> в Slug или Permalink партнерской ссылки. Это баг плагина!' );
        }
    }

	public static function wpb_admin_notice_warn() {
		echo self::render();
	}

	public static function get()
    {
        return  [
            'message' => __( 'This is test tite', ToolLoco::TEXTDOMAIN ) . ': ' . get_site_url(),

            'name' => __( 'DB_NAME', ToolLoco::TEXTDOMAIN ) . ': ' . DB_NAME,

            'user' => __( 'DB_USER', ToolLoco::TEXTDOMAIN ) . ': ' . DB_USER,
        ];
    }
	
	const TEMPLATE = [
        'notice' => LegalMain::LEGAL_PATH . '/template-parts/admin/part-notice.php',

        'rectangle' => LegalMain::LEGAL_PATH . '/template-parts/admin/part-rectangle.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'notice' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_rectangle( $args = '' )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'rectangle' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}
?>
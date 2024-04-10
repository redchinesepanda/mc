<?php

// require_once( 'ACFBilletCards.php' );

require_once( 'ACFPage.php' );

require_once( 'ACFCompilation.php' );

require_once( 'ACFMenu.php' );

require_once( 'ACFReview.php' );

require_once( 'ACFBillet.php' );

class ACFMain
{
    public static function check_plugin()
    {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		return is_plugin_active( 'advanced-custom-fields-pro/acf.php' );
    }

    public static function check_not_functions()
    {
        return !self::check_functions();
    }

    public static function check_functions()
    {
        return function_exists( 'get_field' );
    }

    public static function check_redeclare()
    {
        return LegalMain::check_not_admin()
        
            && self::check_not_functions();
    }

    const JS = LegalMain::LEGAL_URL . '/assets/js/acf/acf-main.js';

    public static function register_script()
    {
        wp_register_script( 'acf-main', self::JS, [], false, true);

        wp_enqueue_script( 'acf-main' );
    }

    public static function register_functions()
    {
        ACFReview::register_functions();
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );

        // ACFBilletCards::register();

        ACFPage::register();

        ACFCompilation::register();

        ACFMenu::register();

        ACFReview::register();

        ACFBillet::register();
    }
}

LegalDebug::debug( [
    'check_not_admin' => LegalMain::check_not_admin(),
    
    'check_redeclare' => ACFMain::check_redeclare(),
] );

if ( ACFMain::check_redeclare() )
{
    function get_field( $field_name, $post_id = null )
    {
        return false;
    }
}

?>
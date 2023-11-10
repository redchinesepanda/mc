<?php

require_once( 'AdminBillet.php' );

require_once( 'AdminTaxonomy.php' );

require_once( 'AdminNotice.php' );

class AdminMain
{
    const CSS = [
        'admin-wpml' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/admin/admin-wpml.css',

            'ver'=> '1.0.0',
        ],
    ];
    
    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );

        AdminBillet::register();

        AdminTaxonomy::register();

        AdminNotice::register();
    }
}

?>
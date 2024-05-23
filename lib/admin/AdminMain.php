<?php

require_once( 'AdminBillet.php' );

require_once( 'AdminTaxonomy.php' );

require_once( 'AdminNotice.php' );

// require_once( 'AdminWPML.php' );

require_once( 'AdminDequeue.php' );

// require_once( 'AdminBrand.php' );

class AdminMain
{
    const TEXT = [
        'test-site' => 'This is a test site',

        'production-site' => 'This is the production site',

        'db-name' => 'DB_NAME',

        'db-user' => 'DB_USER',
    ];

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

    // public static function register_menus()
    // {
    //     register_nav_menus(
    //         [
    //             'primary-menu' => __( 'Primary Menu' ),
                
    //             'secondary-menu' => __( 'Secondary Menu' )
    //         ]
    //     );
    // }

    public static function register()
    {
        $handler = new self();

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );

        add_theme_support( 'post-thumbnails' );

        AdminBillet::register();

        AdminTaxonomy::register();

        AdminNotice::register();

        // AdminWPML::register();

        AdminDequeue::register();

        // AdminBrand::register();
    }
}

?>
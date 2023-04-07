<?php

require_once( LegalMain::LEGAL_PATH . '/lib/compilation/CompilationMain.php' );

class CompilationTabs
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs.php';

    const CSS = LegalMain::LEGAL_URL . '/assets/css/tabs/tabs-main.css';

    const JS = LegalMain::LEGAL_URL . '/assets/js/tabs/tabs-main.js';

    public static function print()
    {
        echo '<link id="tabs-main-css" href="' . self::CSS . '" rel="stylesheet" />';

        echo '<script id="tabs-main-js" src="' . self::JS . '"></script>';

        CompilationMain::print();
    }

    const TABS_TEXT = 'tabs-title-text';

    const TABS_ITEMS = 'tabs-items';

    const TABS_LINK_TEXT = 'tabs-link-text';

    const TABS_LINK_URL = 'tabs-link-url';

    const TAB_TEXT = 'tab-title-text';

    const TAB_IMAGE = 'tab-title-image';

    const TAB_COMPILATIONS = 'tab-compilations';

    public static function get()
    {
        $post = get_post();

        $args = [
            'text' => get_field( self::TABS_TEXT, $post->ID ),
            
            'link' => [
                'text' => get_field( self::TABS_LINK_TEXT, $id ),

                'url' => get_field( self::TABS_LINK_URL, $id ),
            ],
        ];

        $tabs = get_field( self::TABS_ITEMS, $post->ID );

        if( $tabs ) {
            foreach( $tabs as $key => $tab ) {
                $args['tabs'][] = [
                    'text' => $tab[ self::TAB_TEXT ],

                    'image' => $tab[ self::TAB_IMAGE ],

                    'compilations' => $tab[ self::TAB_COMPILATIONS ],

                    'active' => ( $key == 0 ? 'legal-active' : '' ),

                    'class' => 'tab-' . $key,
                ];
            }
        } else {
            $args['empty'] = __( 'There are no tabs added yet', ToolLoco::TEXTDOMAIN );
        }

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>
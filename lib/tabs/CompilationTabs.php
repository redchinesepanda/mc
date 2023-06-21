<?php

require_once( LegalMain::LEGAL_PATH . '/lib/compilation/CompilationMain.php' );

class CompilationTabs
{
    const CSS = [
        'tabs-main' => LegalMain::LEGAL_URL . '/assets/css/tabs/tabs-main.css',
    ];

    const JS = [
        'tabs-main' => LegalMain::LEGAL_URL . '/assets/js/tabs/tabs-main.js',
    ];

    public static function print()
    {
        // echo '<link id="tabs-main-css" href="' . self::CSS . '" rel="stylesheet" />';

        // echo '<script id="tabs-main-js" src="' . self::JS . '"></script>';

        ToolPrint::print_style( self::CSS );

        ToolPrint::print_script( self::JS );

        CompilationMain::print();
    }

    const TABS_TEXT = 'tabs-title-text';

    const TABS_ITEMS = 'tabs-items';

    const TABS_DESCRIPTION = 'tabs-description-text';

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

            'description' => get_field( self::TABS_DESCRIPTION, $post->ID ),
            
            'link' => [
                'text' => get_field( self::TABS_LINK_TEXT, $post->ID ),

                'url' => get_field( self::TABS_LINK_URL, $post->ID ),
            ],
        ];

        $args['tabs'] = [];

        $tabs = get_field( self::TABS_ITEMS, $post->ID );

        if( $tabs ) {
            foreach( $tabs as $key => $tab ) {
                $args['tabs'][] = [
                    'text' => $tab[ self::TAB_TEXT ],

                    'image' => $tab[ self::TAB_IMAGE ],

                    'compilations' => ( !empty( $tab[ self::TAB_COMPILATIONS ] ) ? $tab[ self::TAB_COMPILATIONS ] : [] ),

                    'active' => ( $key == 0 ? 'legal-active' : '' ),

                    'class' => ( !empty( $tab[ self::TAB_IMAGE ] ) ? 'tab-image-' . $key : '' ),
                ];
            }
        } else {
            $args['empty'] = __( 'There are no tabs added yet', ToolLoco::TEXTDOMAIN );
        }

        return $args;
    }

    const TEMPLATE = [
        'tabs' => LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs.php',
    ];

    public static function render()
    {
        $args = self::get();

        $output = [];

        if ( count( $args['tabs'] ) == 1 ) {
            $tab = array_shift( $args['tabs'] );

            foreach ( $tab['compilations'] as $compilation) {
                $output[] = CompilationMain::render( $compilation );
            }
        } else {
            $output[] = self::render_tabs( $args );
        }

        return implode( '', $output );
    }

    public static function render_tabs( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'tabs' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>
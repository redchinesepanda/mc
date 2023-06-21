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
        ToolPrint::print_style( self::CSS );

        ToolPrint::print_script( self::JS );

        CompilationMain::print();
    }

    const TABS = [
        'text' => 'tabs-title-text',

        'items' => 'tabs-items',
        
        'description' => 'tabs-description-text',

        'link-text' => 'tabs-link-text',

        'link-url' => 'tabs-link-url',
    ];

    const TAB = [
        'text' => 'tab-title-text',

        'image' => 'tab-title-image',

        'compilations' => 'tab-compilations',
    ];

    public static function get()
    {
        $post = get_post();

        $args = [
            'text' => get_field( self::TABS[ 'text' ], $post->ID ),

            'description' => get_field( self::TABS[ 'description' ], $post->ID ),
            
            'link' => [
                'text' => get_field( self::TABS[ 'link-text' ], $post->ID ),

                'url' => get_field( self::TABS[ 'link-url' ], $post->ID ),
            ],
        ];

        $args['tabs'] = [];

        $tabs = get_field( self::TABS[ 'items' ], $post->ID );

        if( $tabs ) {
            foreach( $tabs as $key => $tab ) {
                $args['tabs'][] = [
                    'text' => $tab[ self::TAB[ 'text' ] ],

                    'image' => $tab[ self::TAB[ 'image' ] ],

                    'compilations' => ( !empty( $tab[ self::TAB[ 'compilations' ] ] ) ? $tab[ self::TAB[ 'compilations' ] ] : [] ),

                    'active' => ( $key == 0 ? 'legal-active' : '' ),

                    'class' => ( !empty( $tab[ self::TAB[ 'image' ] ] ) ? 'tab-image-' . $key : '' ),
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
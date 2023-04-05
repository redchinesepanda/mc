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

        echo '<script id="tabs-main-js" src="' . self:JS . '"></script>';

        CompilationMain::print();
    }

    const ACF_TABS = 'compilation-tabs';

    const TAB_LABEL = 'tab-label';

    const TAB_COMPILATION = 'compilation-id';

    public static function get()
    {
        $post = get_post();

        $tabs = get_field( self::ACF_TABS, $post->ID );

        if( $tabs ) {
            foreach( $tabs as $key => $tab ) {
                $args['tabs'][] = [
                    'label' => $tab[ self::TAB_LABEL ],

                    'compilation' => $tab[ self::TAB_COMPILATION ],

                    'class' => ( $key == 0 ? 'legal-active' : '' )
                ];
            }

            // self::debug( [
            //     'args' => $args,
            // ] );

            return $args;
        } else {
            return [
                'empty' => __( 'There are no tabs added yet', ToolLoco::TEXTDOMAIN ),
            ];
        }

        return [];
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
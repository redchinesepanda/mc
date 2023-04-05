<?php

require_once( LegalMain::LEGAL_PATH . '/lib/compilation/CompilationMain.php' );

class CompilationTabs
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs.php';

    const ACF_TABS = 'compilation-tabs';

    const TAB_LABEL = 'tab-label';

    const TAB_COMPILATION = 'compilation-id';

    public static function print()
    {
        CompilationMain::print();
    }

    public static function get()
    {
        $post = get_post();

        $tabs = get_field( self::ACF_TABS, $post->ID );

        if( $tabs ) {
            foreach( $tabs as $tab ) {
                $args[] = [
                    'label' => $part[ self::TAB_LABEL ],

                    'compilation' => $part[ self::TAB_COMPILATION ],
                ];
            }

            return $args;
        }

        return [];
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
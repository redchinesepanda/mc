<?php

require_once( LegalMain::LEGAL_PATH . '/lib/compilation/CompilationMain.php' );

class CompilationTabs
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs.php';

    const ACF_TABS = 'compilation-tabs';

    public static function get( $page )
    {
        $tabs = get_field( self::ACF_TABS, $page['id'] );

        if( $tabs ) {
            foreach( $tabs as $tab ) {
                $args[] = [
                    'order' => $part['billet-order-type'],

                    'rating' => $part['billet-rating-enabled'],

                    'achievement' => $part['billet-achievement-type'],

                    'list' => $part['billet-list-type'],

                    'bonus' => $part['billet-bonus-enabled'],

                    'mobile' => $part['billet-mobile-enabled'],

                    'profit' => $part['billet-profit-enabled'],

                    'spoiler' => $part['billet-spoiler-enabled'],

                    'filter' => $part['compilation-filter'],

                    'review' => [
                        'label' => $part['compilation-review-label'],

                        'type' => $part['compilation-review-type'],
                    ],

                    'play' => [
                        'label' => $part['compilation-play-label'],
                    ],
                ]
            }

            return $args;
        }

        return [];
    }

    public static function render( $page )
    { 
        load_template( self::TEMPLATE, false, self::get( $page ) );
    }
}

?>
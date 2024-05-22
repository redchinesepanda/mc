<?php

class LegalTabsInfo
{
    const CSS = [
        'legal-tabs-info' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/tabs/legal-tabs-info.css',

			'ver' => '1.0.1',
		],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

	const SHORTCODE = [
		'info' => 'legal-tabs-info',
	];

	public static function register()
    {
        $handler = new self();

		// [legal-tabs-info]

        add_shortcode( self::SHORTCODE[ 'info' ], [ $handler, 'render' ] );

        if ( self::check_contains_tabs_info() )
        {
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        }
    }

    public static function get_tabs_info()
    {
		return [
            'title' => ToolLoco::translate( BaseMain::TEXT[ 'what-is' ] ),

            'tab-title-0' => ToolLoco::translate( BaseMain::TEXT[ 'expertise' ] ),

            'tab-title-1' => ToolLoco::translate( BaseMain::TEXT[ 'transparency' ] ),

            'tab-title-2' => ToolLoco::translate( BaseMain::TEXT[ 'fairness' ] ),

            'tab-title-3' => ToolLoco::translate( BaseMain::TEXT[ 'relevance' ] ),

            'tab-content-0' => ToolLoco::translate( BaseMain::TEXT[ 'we-are-professionals' ] ),

            'tab-content-1' => ToolLoco::translate( BaseMain::TEXT[ 'we-provide-only' ] ),

            'tab-content-2' => ToolLoco::translate( BaseMain::TEXT[ 'our-reviews' ] ),

            'tab-content-3' => ToolLoco::translate( BaseMain::TEXT[ 'we-focus-on' ] ),
        ];
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/tabs/legal-tabs-info.php',
    ];

	public static function render()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get_tabs_info() );
    }

    public static function check_contains_tabs_info()
    {
        return LegalComponents::check_shortcode( self::SHORTCODE[ 'info' ] );
    } 
}

?>
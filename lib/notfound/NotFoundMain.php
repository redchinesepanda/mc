<?php

class NotFoundMain
{
	const CSS = [
        'legal-notfound' => LegalMain::LEGAL_URL . '/assets/css/notfound/notfound.css',
    ];

    public static function register_style()
    {
		if ( self::check() ) {
			ToolEnqueue::register_style( self::CSS );
		}
    }

	public static function register_inline_style()
    {
		if ( self::check() ) {
			ToolEnqueue::register_inline_style( 'base-notfound', self::inline_style() );
		}
    }

	public static function check()
    {
        return is_404();
    }

	public static function register()
    {
        $handler = new self();

		// [legal-notfound]

        add_shortcode( 'legal-notfound', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
    }

	public static function inline_style() {
		$style = [];

		$args = WPMLLangSwitcher::get();

		if ( empty( $args[ 'languages' ] ) || empty( $args[ 'active' ] ) ) {
			return '';
		}

		$style_items = array_merge( $args[ 'languages' ], $args[ 'active' ] );

		LegalDebug::debug( [
			'$style_items' => $style_items,
		] );

		// .locale-1 {
		// 	background-image: url(https://match.center/wp-content/uploads/flags/default.svg);
		// }

		// foreach ( $style_items as $style_item ) {
		// 	$style[] = '.legal-menu .' . $style_item[ 'class' ] . ' > a { background-image: url(\'' . LegalMain::LEGAL_ROOT . '/wp-content/uploads/flags/' . $style_item[ 'url-part' ] .'.svg\'); }';
		// }

		return implode( ' ', $style );
	}

	public static function get()
	{
		return  array_merge( [
			'title' => __( "Oops! Page Not Found", ToolLoco::TEXTDOMAIN ),
			
			'description' => __( "You must have picked the wrong door because I haven't been able to lay my eye on the page you've been searching for.", ToolLoco::TEXTDOMAIN ),
		], WPMLLangSwitcher::get() );
	}

	const TEMPLATE = [
        'notfound' => LegalMain::LEGAL_PATH . '/template-parts/notfound/part-notfound-main.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'notfound' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
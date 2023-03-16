<?php

class BilletList
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-list.php';

    const STYLE = Template::LEGAL_URL . '/assets/css/billet-list.css';

    // public static function register()
    // {
    //     $handler = new self();

    //     add_action( 'wp_enqueue_scripts', [ $handler, 'register_script'] );
    // }

    // public function register_script()
    // {
	// 	wp_enqueue_style( 'billet', BilletList::STYLE );
    // }

    public static function print()
    {
		echo '<link id="billet" href="' . BilletList::STYLE . '" rel="stylesheet" />';
    }
    

    public static function get()
    {
        $args = [];

        $parts = get_field( 'billet-list-parts' );

        if( $parts ) {
            foreach( $parts as $key => $part ) {
                $args[$key]['part-icon'] = $part['billet-list-part-icon'];

                $args[$key]['part-direction'] = $part['billet-list-part-direction'];

                $items = $part['billet-list-part-items'];

                if( $items ) {
                    foreach( $items as $item ) {
                        $args[$key]['part-items'][] = $item['billet-list-part-item-title'];
                    }
                }
            }
        }

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>
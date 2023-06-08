<?php

class ACFReview
{
    const FIELD = [
		'about' => 'review-about',

		'anchors' => 'review-anchors',
	];

    const ANCHORS = [
		'id' => 'anchor-id',

		'label' => 'anchor-label',
	];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'anchors' ], [ $handler, 'supply_field' ] );
    }

    public static function supply_field( $field )
    {
		$anchors = ReviewAnchors::get_labels();

		$args[ 
			'title' => __( 'Existing anchors', ToolLoco::TEXTDOMAIN ),

			'id' => __( 'ID', ToolLoco::TEXTDOMAIN ),

			'label' => __( 'Label', ToolLoco::TEXTDOMAIN ),
		];

		foreach( $anchors as $id => $label ) {
			$args[ 'items' ][] = [
				'id' => $id,
				'label' => $label,
			];
		}

		$field[ 'instructions' ] = self::render( $args );

        return $field;
    }

	const TEMPLATE = [
        'anchors' => LegalMain::LEGAL_PATH . '/template-parts/acf/part-anchors.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'anchors' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>
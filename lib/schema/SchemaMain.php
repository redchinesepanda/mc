<?php

class SchemaMain
{
	public static function register()
    {
        $handler = new self();

        add_filter( 'hunch_schema_markup', [ $handler, 'markup' ] );
    }

	public static function markup( $markup )
	{
		$data = [];

		if ( LegalComponents::check() )
		{
			return json_encode( $data, JSON_UNESCAPED_UNICODE );
		}

		if ( !empty( $markup ) )
		{
			$data = json_decode( $markup );
		}
		
		if ( !empty( $data ) )
		{
			if ( property_exists( $data, '@context' ) )
			{
				if ( property_exists( $data, '@graph' ) )
				{
					if ( !empty( $data->{"@graph"} ) )
					{
						foreach( $data->{"@graph"} as $node )
						{
							if ( property_exists( $node, 'author' ) )
							{
								unset( $node->author );
							}
						}
					}
				}
			}
		}
		
		return json_encode( $data, JSON_UNESCAPED_UNICODE );
	}
}

?>
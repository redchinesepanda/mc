<?php

class ToolPDO
{
	const SETTINGS = [
		// 'host' => '46.101.248.55',
		
		'host' => '10.135.239.72',

		'port' => '5432',

		'dbname' => 'mc_analytics',

		'user' => 'match_center',

		'password' => 'qak7qda6ZPG_hmr!veh',
	];

	public static $pdo;

	public static function connect()
    {
        $connection_string = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",

            self::SETTINGS['host'],

            self::SETTINGS['port'],

            self::SETTINGS['dbname'],

            self::SETTINGS['user'],

            self::SETTINGS['password']
        );

        $pdo = new \PDO( $connection_string );

        $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		
		self::$pdo = $pdo;
    }

	public static function get()
    {
        if ( static::$pdo === null )
		{
            self::connect();
        }

        return static::$pdo;
    }

	const TABLES = [
		'stats' => 'ref_clicks',
	];

	const STATS =  [
		// SERIAL PRIMARY KEY
		'id' => 0,

		// text
		'url_path' => '/',

		// text
		'url_ref_click' => '/',

		// timestamp
		'date' => 0,

		// inet
		'user_ip' => '0.0.0.0',

		// text
		'user_agent' => '-',
	];

	public static function select()
    {
		$values = array_keys( self::STATS );

		$values[] = self::TABLES[ 'stats' ];

		$query = vsprintf(
			"SELECT %s, %s, %s, %s, %s, %s FROM %s",

			$values
		);

        $statement = self::get()->prepare( $query );

        $statement->execute();

		return $statement->fetchAll();
    }

	public static function insert( $data )
    {
		$data = shortcode_atts( self::STATS, $data );

		$replacements[] = self::TABLES[ 'stats' ];

		$fields = array_keys( self::STATS );

		$removed = array_shift( $fields );

		$replacements = array_merge( $replacements, $fields, $fields );

		$query = vsprintf(
			'INSERT INTO %s ( %s, %s, %s, %s, %s ) VALUES ( :%s, :%s, :%s, :%s, :%s )',

			$replacements
		);

		$statement = self::get()->prepare( $query );

        $statement->execute( $data );

		return $statement->fetchAll();
    }
}

?>
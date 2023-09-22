<?php

class ToolPDO
{
	const SETTINGS = [
		'host' => '46.101.248.55',

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
}

?>
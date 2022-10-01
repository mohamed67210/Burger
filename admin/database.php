<?php

class Database
	{
		private static $dbHost = "localhost";
		private static $dbName ="burger_code";
		private static $dbUser ="root";
		private static $connectionPassword ="";
		
		private static $connection = null;
		
		//connexion a la base de donnée 
		public static function connect()
		{
				self::$connection =  new PDO("mysql:host=" . self::$dbHost . ";dbname=".self::$dbName , self::$dbUser, self::$connectionPassword);
				return self::$connection;
		}
		//deconnexion de la base de donnée 
		public static function disconnect()
		{
			self::$connection=null;
		}
	}
Database::connect();
?>
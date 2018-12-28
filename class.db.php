<?php

class DB {
	// == PRIVATE ==
	
	private static $pdo;
	
	private static function _Method($method, $args){
		return call_user_func_array([ self::$pdo, $method ], $args);
	}
	
	// == PUBLIC ==
	
	// Initialize
	public static function Init($host, $dbname, $user, $pass){
		try {
			self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		}
		catch(Exception $e){
			// TODO: Fatal Error function
			die('fatal error');
		}
		
		$sqlTablesDir = './sql/tables';
		
		foreach(scandir($sqlTablesDir) as $file){
			$file = $sqlTablesDir . '/' . $file;
			
			if(is_dir($file)){
				continue;
			}
			
			$sql = file_get_contents($file);
			
			$query = DB::Query($sql);
		}
	}
	
	// PDO wrapper functions
	public static function Query(){
		return self::_Method('query', func_get_args());
	}
	
	public static function Prepare(){
		return self::_Method('prepare', func_get_args());
	}
	
	public static function Execute(){
		return self::_Method('execute', func_get_args());
	}
}

?>
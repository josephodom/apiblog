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
		// Create PDO object
		
		try {
			self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		}
		catch(Exception $e){
			FatalError($e);
		}
		
		
		
		// Set PDO attributes
		
		// We want it to throw an exception whenever there's an SQL syntax error
		self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		
		
		// Run SQL table creation files
		
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
	
	public static function Fetch(){
		try {
			$args = func_get_args();
			
			if(count($args) == 1){
				$args[] = PDO::FETCH_OBJ;
			}
			
			return call_user_func_array([ array_shift($args), 'fetch' ], $args);
		}
		catch(Exception $e){
			FatalError($e);
		}
	}
	
	public static function FetchAll(){
		try {
			$args = func_get_args();
			
			if(count($args) == 1){
				$args[] = PDO::FETCH_OBJ;
			}
			
			return call_user_func_array([ array_shift($args), 'fetchAll' ], $args);
		}
		catch(Exception $e){
			FatalError($e);
		}
	}
	
	public static function Execute($q, $values = []){
		try {
			$q->execute($values);
		}
		catch(Exception $e){
			FatalError($e);
		}
	}
	
	public static function Prepare(){
		try {
			return self::_Method('prepare', func_get_args());
		}
		catch(Exception $e){
			FatalError($e);
		}
	}
	
	public static function Query(){
		try {
			return self::_Method('query', func_get_args());
		}
		catch(Exception $e){
			FatalError($e);
		}
	}
}

?>
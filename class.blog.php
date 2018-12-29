<?php

class Blog {
	// == STATIC VARIABLES ==
	
	public static
		$pageCount = 0,
		$totalResults = 0
	;
	
	
	
	// == STATIC FUNCTIONS ==
	
	public static function Create($values){
		$q = DB::Prepare("INSERT INTO posts (uid, title, message, date_created) VALUES (:uid, :title, :message, :date_created);");
		
		return DB::Execute($q, $values);
	}
	
	public static function Delete($id){
		$q = DB::Prepare("DELETE FROM posts WHERE pid = :id");
		
		return DB::Execute($q, [ 'id' => $id ]);
	}
	
	public static function Read($values = []){
		if(empty($values['limit'])){
			$values['limit'] = 3;
		}
		
		if(empty($values['order'])){
			$values['order'] = 'DESC';
		}
		
		if(empty($values['orderby'])){
			$values['orderby'] = 'pid';
		}
		
		if(empty($values['page'])){
			$values['page'] = 1;
		}
		
		if(empty($values['keys'])){
			$values['keys'] = '*';
		}
		
		$sql = "SELECT {{KEYS}} FROM posts ORDER BY " . $values['orderby'] . " " . $values['order'];
		
		$qCount = DB::Prepare(str_replace('{{KEYS}}', 'COUNT(*) AS count', $sql));
		DB::Execute($qCount, $values);
		$qCount = DB::Fetch($qCount);
		self::$totalResults = $qCount->count;
		self::$pageCount = ceil($qCount->count / $values['limit']);
		
		$q = DB::Prepare(str_replace('{{KEYS}}', $values['keys'], $sql) . " LIMIT " . ($values['limit'] * ($values['page'] - 1)) . ", " . $values['limit']);
		
		unset($values['keys']);
		unset($values['limit']);
		unset($values['order']);
		unset($values['orderby']);
		unset($values['page']);
		
		DB::Execute($q, $values);
		
		return DB::FetchAll($q);
	}
	
	public static function Update($id, $values){
		$statements = [];
		
		$values['pid'] = $id;
		
		if(empty($values['date_last_edited'])){
			$values['date_last_edited'] = time();
		}
		
		foreach(array_keys($values) as $key){
			if($key == 'pid'){
				continue;
			}
			
			$statements[] = $key . ' = :' . $key;
		}
		
		$q = DB::Prepare($sql = "UPDATE posts SET " . implode(", ", $statements) . " WHERE pid = :pid");
		
		return DB::Execute($q, $values);
	}
}

?>
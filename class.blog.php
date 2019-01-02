<?php

class Blog {
	// == STATIC VARIABLES ==
	
	public static
		$pageCount = 0,
		$totalResults = 0
	;
	
	
	
	// == STATIC FUNCTIONS ==
	
	public static function Create($values){
		$q = DB::Prepare("INSERT INTO posts (title, message, date_created) VALUES (:title, :message, :date_created);");
		
		return DB::Execute($q, $values);
	}
	
	public static function Delete($id){
		$q = DB::Prepare("DELETE FROM posts WHERE pid = :id");
		
		return DB::Execute($q, [ 'id' => $id ]);
	}
	
	public static function Read($values = []){
		// We'll keep all $where conditions in this array
		// WHERE support is currently primitive; it can only do a single list of x AND y
		$where = [];
		
		
		
		// Set some default values if none are given
		
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
		
		
		
		// If there's WHERE conditions given, set them up
		
		if(!empty($values['where'])){
			foreach($values['where'] as $condition){
				// Add a WHERE condition to the array
				// Notice that we're creating a variable for DB::Execute to recognize and fill in
				// And it has the prefix `where__`
				// That prefix is so there isn't any collision with other values under any forseeable circumstances, just in case
				$where[] = $condition['key'] . ' = :where__' . $condition['key'];
				
				// Then we add the `where__`-prefixed variable to the $values array, which will eventually be handed to DB::Execute
				$values['where__' . $condition['key']] = $condition['value'];
			}
		}
		
		// Drop the `where` index here so DB::Execute doesn't complain about it later
		unset($values['where']);
		
		// We set a general SQL string here
		// This can be used for getting both the total result count, and the actual results on the current page
		// We'll just replace {{KEYS}} with either the requested keys, or COUNT(*)
		$sql = "SELECT {{KEYS}} FROM posts " . (count($where) ? 'WHERE ' . implode(' AND ', $where) : '') . " ORDER BY " . $values['orderby'] . " " . $values['order'];
		
		// The block inside this if() handles pagination values
		// If we're looking for a specific post, there's no need to paginate
		if(empty($values['where__pid'])){
			// Create and execute the query for getting the result count
			// We want to pull COUNT(*) as count, since that's an object child-friendly name
			$qCount = DB::Prepare(str_replace('{{KEYS}}', 'COUNT(*) AS count', $sql));
			DB::Execute($qCount, $values);
			
			// We're fetching just one, rather than doing DB::FetchAll
			$qCount = DB::Fetch($qCount);
			
			// We want to set both the total result count, as well as the page count
			// Always round up for page count. You don't want the total page number to be 3.125!
			self::$totalResults = $qCount->count;
			self::$pageCount = ceil($qCount->count / $values['limit']);
		}
		
		// This is the query for getting the results
		// We're adding in LIMIT and etc
		// Notice that LIMIT, as well as ORDER BY earlier, are put in directly rather than being values for DB::Execute to fill in
		// This is because DB::Execute is only for filling in values, not keys
		$q = DB::Prepare(str_replace('{{KEYS}}', $values['keys'], $sql) . " LIMIT " . ($values['limit'] * ($values['page'] - 1)) . ", " . $values['limit']);
		
		// Unset any values that we put into the query manually
		// If the values given to DB::Execute do not perfectly match the number of values in the query, it will complain
		unset($values['keys']);
		unset($values['limit']);
		unset($values['order']);
		unset($values['orderby']);
		unset($values['page']);
		
		// Execute the query
		DB::Execute($q, $values);
		
		
		
		// If you're getting a post with a certain pid, there can only possibly be one result, or zero
		// Skip the step that requires you to pull a value out of a single-var array
		// If you're not trying to do that though, you should reasonably expect an array of posts even if there's just one result
		if(empty($values['where__pid'])){
			return DB::FetchAll($q);
		}else{
			return DB::Fetch($q);
		}
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
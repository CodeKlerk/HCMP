<?php
class Access_level extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',15);
		$this -> hasColumn('level', 'varchar',255);	
		$this -> hasColumn('type', 'int',255);		
	}

	public function setUp() {
		$this -> setTableName('access_level');
	//	$this -> hasMany('user as u_type1', array('local' => 'id', 'foreign' => 'usertype_id'));
		
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("access_level")-> where("id=1 or id=3 or id=4 or id=6");
		$level = $query -> execute();
		return $level;
	}
	public static function get_all_users() {
		$query = Doctrine_Query::create() -> select("*") -> from("access_level");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll1() {
		$query = Doctrine_Query::create() -> select("*") -> from("access_level")-> where("id=2 or id=5");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll2() {
		$query = Doctrine_Query::create() -> select("*") -> from("access_level")-> where("type=5");
		$level = $query -> execute();
		return $level;
	}
	public static function get_access_level_name($access_level_id) {
		$query = Doctrine_Query::create() -> select("*") -> from("access_level")-> where("id=$access_level_id");
		$level = $query -> execute();
		$level=$level->toArray();
		return $level[0];
	}
	

}
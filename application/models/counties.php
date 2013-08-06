<?php
class Counties extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('county', 'varchar',30);
		$this -> hasColumn('kenya_map_id', 'int',11);	
	}

	public function setUp() {
		$this -> setTableName('counties');
		//$this -> hasOne('Drug_Category as Category', array('local' => 'Drug_Category', 'foreign' => 'id'));
		$this -> hasMany('districts as county_district', array('local' => 'id', 'foreign' => 'county'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("counties")-> OrderBy("county asc");
		$drugs = $query -> execute();
		return $drugs;
	}
		public static function getAllcounties() {
//		$query = Doctrine_Query::create() -> select("*") -> from("counties")-> OrderBy("county asc");
//		$drugs = $query -> execute();
//		return $drugs;
		$query = $q=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
		SELECT id, county	FROM counties
		");
		return $query;
	}
	
	public static function get_county_map_data() {
		$query = Doctrine_Query::create() -> select("*") -> from("counties")-> OrderBy("kenya_map_id asc, county asc");
		$drugs = $query -> execute();
		return $drugs;
	}
	
	
	public static function get_county_name($county_id){
$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT county
FROM counties
WHERE counties.id='$county_id' ");
return $q;
	}

}

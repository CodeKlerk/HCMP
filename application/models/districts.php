<?php
class Districts extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('district', 'varchar',30);
		$this -> hasColumn('county', 'varchar',30);	
	}

	public function setUp() {
		$this -> setTableName('districts');
		$this -> hasOne('counties as district_county', array('local' => 'county', 'foreign' => 'id'));
		$this -> hasMany('facilities as facility_district', array('local' => 'id', 'foreign' => 'district'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("districts");
		$drugs = $query -> execute();
		return $drugs;
	}
	public static function getDistrict($county){
		$query = Doctrine_Query::create() -> select("*") -> from("districts")->where("county='$county'");
		$drugs = $query -> execute();
		
		return $drugs;
	}
	public static function get_county_id($district){
		$query = Doctrine_Query::create() -> select("county") -> from("districts")->where("id='$district'");
		$drugs = $query -> execute();
		$drugs=$drugs->toArray();
		
		return $drugs;
	}
	
	public static function get_district_name($district){
	$query = Doctrine_Query::create() -> select("district") -> from("districts")->where("id='$district'");
		$drugs = $query -> execute();
		return $drugs;	
	}
public static function get_district_name_($district){
	$query = Doctrine_Query::create() -> select("district") -> from("districts")->where("id='$district'");
		$drugs = $query -> execute();
		$drugs=$drugs->toArray();
		return $drugs[0];
	}

	public static function get_district_expiries($date,$district){
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT stock.facility_code,stock.kemsa_code,stock.batch_no,stock.manufacture,stock.expiry_date,stock.balance,stock.quantity,stock.status,stock.stock_date,stock.sheet_no, f.facility_name, d.district
			FROM Facility_Stock stock, facilities f, districts d, counties c
			WHERE stock.expiry_date<='$date'
			AND stock.facility_code=f.facility_code
			AND f.district=d.id
			AND d.id='$district'
			GROUP BY d.district");	
		return $query;
	}
}

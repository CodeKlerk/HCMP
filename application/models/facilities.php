<?php
class Facilities extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('facility_code', 'varchar',30);
		$this -> hasColumn('facility_name', 'varchar',30);
		$this -> hasColumn('district', 'varchar',30);
		$this->hasColumn('drawing_rights','text');
	}

	public function setUp() {
		$this -> setTableName('facilities');
		$this -> hasOne('facility_code as Code', array('local' => 'facility_code', 'foreign' => 'facilityCode'));
		$this -> hasOne('facility_code as Coder', array('local' => 'facility_code', 'foreign' => 'facility_code'));
		$this -> hasOne('facility_code as Codes', array('local' => 'facility_code', 'foreign' => 'facility'));
		$this -> hasOne('district as facility_district', array('local' => 'district', 'foreign' => 'id'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("districts");
		$drugs = $query -> execute();
		return $drugs;
	}
	public static function getFacilities($district){
		$query = Doctrine_Query::create() -> select("*") -> from("facilities")->where("district='$district'")->OrderBy("facility_name asc");
		$drugs = $query -> execute();
		return $drugs;
	}
	public static function get_facility_name_($facility_code){
			$query = Doctrine_Query::create() -> select("facility_name") -> from("facilities")->where("facility_code='$facility_code'");
		$drugs = $query -> execute();
		$drugs=$drugs->toArray();
		
		return $drugs[0];	
	}
	
	public static function get_d_facility($district){
		'SELECT unique facilities.facility_name, user.fname, user.lname, user.telephone
FROM facilities, user
WHERE facilities.district ='.$district.'
AND user.district ='.$district.'
AND user.facility = facilities.facility_code
AND user.usertype_id =2';
		
		$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$result = $q->execute(" SELECT user.email, facilities.facility_code, facilities.facility_name, user.fname, user.lname, user.telephone
FROM facilities, user
WHERE facilities.district =  '$district'
AND user.district =  '$district'
AND user.facility = facilities.facility_code
AND user.status =  '1'
AND (
user.usertype_id =5
OR user.usertype_id =2
)
GROUP BY user.facility");

		return $result;
		
	}
	
	/*************************getting the facility name *******************/
	public static function get_facility_name($facility_code){
	$query=Doctrine_Query::create()->select('facility_name')->from('facilities')->where("facility_code='$facility_code'");
	$result=$query->execute();
	return $result[0];
	}
	
	/********************getting the facility owners  count*************/
	public static function get_owner_count() {
		$query = Doctrine_Query::create() -> select("COUNT(facility_code) as count , owner ") -> from("facilities")->where("owner !=''")->groupby("owner")->ORDERBY ('count ASC' );
		$drugs = $query -> execute();
		return $drugs;
	}
	
public static function get_no_of_facilities($category){
		$district = $category;
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT COUNT(f.facility_code) as total_facilities
FROM facilities f, counties c, districts d
WHERE f.`district` = d.id
AND d.county = c.id
AND c.id =  $district ");
return $q;

}

public static function get_total_facilities_rtk($county_id){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT (
SELECT COUNT( f.facility_code ) 
FROM facilities f, counties c, districts d
WHERE f.`district` = d.id
AND d.county = c.id
AND c.id =  '$county_id'
) AS total_facilities , COUNT( f.facility_code ) AS total_rtk
FROM facilities f, counties c, districts d
WHERE rtk_enabled =1
AND f.`district` = d.id
AND d.county = c.id
AND c.id =  '$county_id'
");
return $q;
}

public static function get_total_facilities_in_district($county_id){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT COUNT( f.facility_code ) as total_facilities
FROM facilities f, districts d
WHERE f.`district` = d.id
AND d.id =  '$county_id'
");
return $q;
}

public static function get_total_facilities_rtk_ownership($county_id,$owner_type){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT COUNT( f.facility_code ) AS ownership_count
FROM facilities f, counties c, districts d
WHERE rtk_enabled =1
AND f.`district` = d.id
AND d.county = c.id
AND c.id =  '$county_id'
AND f.owner like '%$owner_type%'
");
return $q;
}

public static function get_total_facilities_district_ownership($county_id,$owner_type){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT COUNT( f.facility_code ) AS ownership_count
FROM facilities f, counties c, districts d
WHERE rtk_enabled =1
AND f.`district` = d.id
AND d.county = c.id
AND d.id =  '$county_id'
AND f.owner like '%$owner_type%'
");
return $q;
}
public static function get_total_facilities_rtk_ownership_in_the_country(){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT COUNT( f.facility_code ) AS ownership_count,f.owner
FROM facilities f
WHERE f.rtk_enabled =1
group by f.owner 
order by f.owner asc");
return $q;
}
public static function get_total_facilities_rtk_in_district($district_id){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
		SELECT  f.facility_code , f.owner as facility_owner,f.facility_name
		FROM facilities f, districts d
		WHERE rtk_enabled =1
		AND d.id='$district_id'
		AND f.`district` = '$district_id'");
return $q;
}
public static function get_total_facilities_rtk_ownership_in_a_district($district_id){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT COUNT( f.facility_code ) AS ownership_count, f.owner
FROM facilities f, districts d
WHERE rtk_enabled =1
AND d.id='$district_id'
AND f.`district` = '$district_id'
group by f.owner 
order by f.owner asc
");
return $q;
}
public static function get_total_facilities_rtk_ownership_in_a_county($county_id){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT COUNT( f.facility_code ) AS ownership_count, f.owner
FROM facilities f, counties c, districts d
WHERE rtk_enabled =1
AND f.`district` = d.id
AND d.county = c.id
AND c.id =  '$county_id'
group by f.owner 
order by f.owner asc
");
return $q;
}

public static function get_total_facilities_rtk_in_county($county_id){
	
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT  f.facility_code , f.owner as facility_owner,f.facility_name
FROM facilities f, counties c, districts d
WHERE rtk_enabled =1
AND f.`district` = d.id
AND d.county = c.id
AND c.id =  '$county_id'");
return $q;
}

///////////////////////////////////////////////
	
public static function get_facility_details($category){
		$district = $category;
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT DISTINCT f.id, f.facility_code, f.facility_name, f.district, f.owner, c.county, d.district as district_name
FROM facilities f, districts d, counties c
WHERE f.district = d.id
AND d.county=c.id
AND d.id= $district");
return $q;
}
////////////////////////////////////////////////
public static function get_one_facility_details($facility_c){
	$facility_code = $facility_c;
		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT DISTINCT f.id, f.facility_code, f.facility_name, f.district, f.owner, c.county, d.district as district_name
FROM facilities f, districts d, counties c
WHERE f.facility_code='$facility_code'
AND f.district=d.id
AND d.county=c.id");
return $q;

}



}

<?php
class Facility_Issues extends Doctrine_Record {
		
	public function setTableDefinition()
	{
		$this -> hasColumn('facility_code', 'int'); 
		$this -> hasColumn('s11_No', 'int'); 
		$this -> hasColumn('kemsa_code', 'varchar',20); 
	    $this -> hasColumn('batch_no', 'varchar',20); 
		$this -> hasColumn('expiry_date', 'date'); 
		$this -> hasColumn('qty_issued', 'int');
		$this -> hasColumn('balanceAsof', 'int',5); 
		$this -> hasColumn('date_issued', 'date'); 
		$this -> hasColumn('issued_to', 'varchar', 12);
		$this -> hasColumn('issued_by', 'int', 12);
		
			
	}

	public function setUp() {
		$this -> setTableName('Facility_Issues');
		$this->actAs('Timestampable');			
		$this -> hasMany('drug as stock_Drugs', array('local' => 'kemsa_code', 'foreign' => 'id'));
		$this -> hasMany('User as Code', array('local' => 'issued_by', 'foreign' => 'id'));
		
		
	}
	public static function getAll() {
		$desc=$_POST['desc'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		$facility_Code=$_POST['facilitycode'];		
		$convertfrom=date('y-m-d',strtotime($from ));
		$convertto=date('y-m-d',strtotime($to ));
		
		$query = Doctrine_Query::create() -> select("s11_No,kemsa_code,batch_no,qty_issued,balanceAsof,date_issued ,(`balanceAsof` +  `qty_issued`) AS SumColumn") 
		-> from("Facility_Issues")-> where(" date_issued between '$convertfrom' AND '$convertto'")->andwhere("kemsa_code='$desc'")->andwhere("facility_code='$facility_Code'");
		$stocktake = $query ->execute();
		return $stocktake;
	}
	public static function getcissues() {
		
		$from=$_POST['fromcommodity'];
		$to=$_POST['tocommodity'];
		$facility_Code=$_POST['facilitycode'];
		$convertfrom=date('y-m-d',strtotime($from ));
		$convertto=date('y-m-d',strtotime($to ));
		
		$query = Doctrine_Query::create() -> select("s11_No,kemsa_code,batch_no,qty_issued,balanceAsof,date_issued ,(`balanceAsof` +  `qty_issued`) AS SumColumn") 
		-> from("Facility_Issues")-> where(" date_issued between '$convertfrom' AND '$convertto'")->andwhere("facility_code='$facility_Code'");
		$stocktake = $query ->execute();
		return $stocktake;
	}
	public static function getyears() {
		
		$query = Doctrine_Query::create() -> select(" DISTINCT YEAR(date_issued) AS theyear") 
		-> from("Facility_Issues") ;
		$years= $query ->execute();
		return $years;
	}
	
	public static function get_consumption_per_drug($drug_id,$year) {
               
               $query = Doctrine_Query::create() -> select(" SUM(`qty_issued`) as total")-> from("Facility_Issues") -> where("kemsa_code=$drug_id")->andwhere("YEAR(date_issued)=$year")->groupby("MONTH(date_issued) ASC")
                ;
               $consumptionA= $query ->execute();
               return $consumptionA->toArray();
       }
	
	public static function get_active_facilities_in_district($district){
	 	$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection()
		->fetchAll("SELECT f.`facility_name` , count( fi.`facility_code` ) AS issue_count
FROM facilities f, facility_issues fi
WHERE fi.`facility_code` = f.`facility_code`
AND fi.`availability` =1
AND f.`district` = '$district'
GROUP BY fi.`facility_code`
ORDER BY issue_count DESC , f.`facility_name` ASC
LIMIT 0 , 5 ");
        return $inserttransaction ;
	}
		public static function get_inactive_facilities_in_district($district){
	$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection()
		->fetchAll("SELECT f.`facility_name`
FROM facilities f, user u
WHERE u.`facility` != f.`facility_code`
AND f.`district` = '$district'
GROUP BY f.`facility_code`
ORDER BY f.`facility_name` ASC");
        return $inserttransaction ;
	}

	////dumbing data into the issues table
	public static function update_issues_table($data_array){
		$o = new Facility_Issues();
	    $o->fromArray($data_array);
		$o->save();
		return TRUE;
	}
	
}
<?php
class Facility_Transaction_Table extends Doctrine_Record {
		
	public function setTableDefinition()
	{
		$this -> hasColumn('Facility_Code', 'int',5); 
		$this -> hasColumn('Kemsa_Code', 'varchar',20);
		$this -> hasColumn('Opening_Balance', 'int',11); 
		$this -> hasColumn('Total_Receipts', 'int',11);
		$this -> hasColumn('Total_Issues', 'int',11);
		$this -> hasColumn('Adj', 'int',11);
		$this -> hasColumn('Losses', 'int',11);
		$this -> hasColumn('Closing_Stock', 'int',11);
		$this -> hasColumn('Days_Out_Of_Stock', 'int',11);
		$this -> hasColumn('Cycle_Date', 'date');
		$this->hasColumn('Status', 'int');
		$this->hasColumn('Comment', 'varchar', 20);
		$this->hasColumn('qty', 'int');
		$this->hasColumn('date_t', 'date');
		$this->hasColumn('availability','tinyint',4);
			
	}

	public function setUp() {
		$this -> setTableName('Facility_Transaction_Table');	
		$this -> hasMany('Drug as Code', array('local' => 'kemsa_code', 'foreign' => 'id'));	
		
	}
	public static function update_facility_table($data_array){
		$o = new Facility_Transaction_Table();
	    $o->fromArray($data_array);
		$o->save();		
		return TRUE;
	}
	 public static function get_all($facility_code){
        $query = Doctrine_Query::create() -> select("*") -> from("Facility_Transaction_Table")->where("Facility_Code=$facility_code and availability=1");
        $drugs = $query -> execute();
        return $drugs;
    }
	 public static function get_commodities_for_ordering($facility_code){
	 	$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection()
->fetchAll("SELECT * from `facility_order_details` where facility_code= '$facility_code'");
        return $inserttransaction ;
		
	 }
	public static function create_facility_order($facility_code){
		$query1 = Doctrine_Query::create() -> select("max(stock_date) as date") -> from("Facility_Stock")->where("Facility_Code=$facility_code");
		$date = $query1 -> execute();
		$test=$date[0]->toArray();
		$actual=$test['date'];
		
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Transaction_Table")->where("Facility_Code=$facility_code and Cycle_Date=$actual");
		$drugs = $query -> execute();
		return $drugs;
	}
	
	public static function get_undated_records($facility_code){
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Transaction_Table")->where("Facility_Code=$facility_code and Cycle_Date='0000-00-11'")
		->andWhere('status=1');
		$drugs = $query -> count();
		return $drugs;
	}
	public static function get_previous($facility){
		$query = Doctrine_Query::create() -> select("*") -> from("Facility_Transaction_Table")->where("Facility_Code=$facility and availability='0'");
		$previous = $query -> execute();
		return $previous;
	}
	
	public static function disable_facility_transaction_table($facility){
		$q = Doctrine_Manager::getInstance()->getCurrentConnection();
		$q->execute("UPDATE Facility_Transaction_Table SET availability='0' where Facility_Code=$facility");
		
	}
	
	public static function get_if_drug_is_in_table($facility_code,$drug_id){
	$query = Doctrine_Query::create() -> select("*") -> from("Facility_Transaction_Table")->where("Facility_Code='$facility_code' and kemsa_code=$drug_id ")->andwhere("availability='1'");
		$previous = $query -> execute();
		
		$drugs = $previous -> count();
		return $drugs;	
	}
	
}
?>
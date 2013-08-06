<?php
class Lab_Commodity_Details extends Doctrine_Record {
	public function setTableDefinition() {
		 $this -> hasColumn('id','int');
		 $this -> hasColumn('order_id','int');
		 $this -> hasColumn('facility_code', 'varchar', 10);
		 $this -> hasColumn('district_id','int');
		 $this -> hasColumn('commodity_id',	'int');
		 $this -> hasColumn('unit_of_issue','int');
		 $this -> hasColumn('beginning_bal','int');
		 $this -> hasColumn('q_received','int');
		 $this -> hasColumn('q_used','int');
		 $this -> hasColumn('no_of_tests_done',	'int');
		 $this -> hasColumn('losses','int');
		 $this -> hasColumn('positive_adj',	'int');
		 $this -> hasColumn('negative_adj',	'int');
		 $this -> hasColumn('closing_stock','int');
		 $this -> hasColumn('q_expiring','int');
		 $this -> hasColumn('days_out_of_stock','int');
		 $this -> hasColumn('q_requested','int');
	 }
	 public function setUp() {
		$this -> setTableName('lab_commodity_details');
		$this -> hasMany('facility_code as Code', array('local' => 'facility_code', 'foreign' => 'facilityCode'));
		$this->hasMany('lab_commodities as lab_commodities', array(
            'local' => 'commodity_id',
            'foreign' => 'id'
        ));
		 $this->hasOne('lab_commodity_orders as orders', array(
            'local' => 'order_id',
            'foreign' => 'id'
        ));
		// $this -> hasOne('facility_code as Coder', array('local' => 'facility_code', 'foreign' => 'facility_code'));
		// $this -> hasOne('facility_code as Codes', array('local' => 'facility_code', 'foreign' => 'facility'));
		// $this -> hasOne('district as facility_district', array('local' => 'district', 'foreign' => 'id'));
	}
	public static function save_lab_commodities($data_array){
		$o = new Lab_Commodity_Details ();
	    $o->fromArray($data_array);
		$o->save();		
		return TRUE;
	}
		//get the latest order id for a given facility
	public static function get_new_order($facilityCode){
		$query = Doctrine_Query::create() -> 
		select("Max(id) as maxId")-> 
		from("lab_commodity_orders") ->
		where("facility_code='$facilityCode'");
		$orderNumber = $query -> execute();	
		return $orderNumber[0];
	}
	//get the order details associated with a given order number
  public static function get_order($delivery){
  		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT cat.category_name, com.commodity_name, l.`order_id`, l.`facility_code`, l.`unit_of_issue`, l.`beginning_bal`, l.`q_received`, l.`q_used`, l.`no_of_tests_done`, l.`losses`, l.`positive_adj`, l.`negative_adj`, l.`closing_stock`, l.`q_expiring`, l.`days_out_of_stock`, l.`q_requested`
		FROM lab_commodity_details l, lab_commodity_categories cat, lab_commodities com
		WHERE order_id=$delivery
		AND com.id=l.`commodity_id`
		AND cat.id=com.category
		ORDER BY commodity_id ASC");
		  return $query;
  	}
  		//get the order details associated with a given order number
  public static function update_lab_commodity_details($data_array){
  	// UPDATE `lab_commodity_details` SET `commodity_id`=[value-5],`unit_of_issue`=[value-6],`beginning_bal`=[value-7],`q_received`=[value-8],`q_used`=[value-9],`no_of_tests_done`=[value-10],`losses`=[value-11],`positive_adj`=[value-12],`negative_adj`=[value-13],`closing_stock`=[value-14],`q_expiring`=[value-15],`days_out_of_stock`=[value-16],`q_requested`=[value-17],`created_at`=[value-18] WHERE 1
$q = Doctrine_Query::create()
     ->update('lab_commodity_details l')
     ->set('l.unit_of_issue', 'Another value')
     ->set('l.beginning_bal', 'Another value')
     ->set('l.q_received', 'Another value')
     ->set('l.q_used', 'Another value')
     ->set('l.no_of_tests_done', 'Another value')
     ->set('l.losses', 'Another value')
     ->set('l.positive_adj', 'Another value')
     ->set('l.negative_adj', 'Another value')
     ->set('l.closing_stock', 'Another value')
     ->set('l.q_expiring', 'Another value')
     ->set('l.days_out_of_stock', 'Another value')
     ->set('l.q_requested', 'Another value')
     ->where('l.order_id=?',1)
     ->andWhere('l.facility_code=?',1)
     ->andWhere('l.commodity_id=?',1)
     ->execute();

  	// UPDATE `lab_commodity_orders` SET `vct`=[value-5],`pitc`=[value-6],`pmtct`=[value-7],`b_screening`=[value-8],`other`=[value-9],`specification`=[value-10],`rdt_under_tests`=[value-11],`rdt_under_pos`=[value-12],`rdt_btwn_tests`=[value-13],`rdt_btwn_pos`=[value-14],`rdt_over_tests`=[value-15],`rdt_over_pos`=[value-16],`micro_under_tests`=[value-17],`micro_under_pos`=[value-18],`micro_btwn_tests`=[value-19],`micro_btwn_pos`=[value-20],`micro_over_tests`=[value-21],`micro_over_pos`=[value-22],`beg_date`=[value-23],`end_date`=[value-24],`explanation`=[value-25],`moh_642`=[value-26],`moh_643`=[value-27],`compiled_by`=[value-28],`created_at`=[value-29] WHERE 1

}
}
	?>
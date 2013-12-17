<?php
class Log extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',50);	
		$this -> hasColumn('user_id', 'int',50);	
		$this -> hasColumn('action', 'varchar',50);
		$this -> hasColumn('action_id', 'int',50);
		$this -> hasColumn('start_time_of_event', 'date');
		$this -> hasColumn('end_time_of_event', 'date');
	
		
		
	}

	public function setUp() {
		$this -> setTableName('log');
		
	}
	
	
	public static function get_active_login($option,$option_id){
		
		switch ($option) {
			case 'county':
		
		$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$result = $q->execute("SELECT DISTINCT  `user_id` , f.facility_name
FROM log l, user u, facilities f, districts d, counties c
WHERE l.user_id = u.id
AND u.facility = f.facility_code
AND f.district = d.id
AND d.county = c.id
AND c.id =$option_id");		
				
				break;
			
			default:
				
				break;
		}
		
	}
//	
	public static function update_log_out_action($user_id){
$q = Doctrine_Manager::getInstance()->getCurrentConnection()->execute("
update log set `end_time_of_event`=NOW(),action='Logged Out' where `user_id`='$user_id' and UNIX_TIMESTAMP( `end_time_of_event`) =0
");	
}
	
}
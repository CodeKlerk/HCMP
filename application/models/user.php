<?php
class User extends Doctrine_Record {

	public function setTableDefinition() {
		$this->hasColumn('fname', 'varchar', 255);
		$this->hasColumn('lname', 'varchar', 255);
		$this->hasColumn('email', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('username', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('password', 'string', 255);
		$this->hasColumn('usertype_id', 'integer', 11);
		$this->hasColumn('telephone', 'varchar', 255);
		$this->hasColumn('district', 'varchar', 255);
		$this->hasColumn('facility', 'varchar', 255);
		$this->hasColumn('status', 'int', 11);
		
	}
	
	public function setUp() {
		$this->setTableName('user');
		$this->actAs('Timestampable');
		$this->hasMutator('password', '_encrypt_password');
		$this -> hasMany('Facilities as Codes', array('local' => 'facility', 'foreign' => 'facility_code'));
		$this -> hasMany('access_level as u_type', array('local' => 'usertype_id', 'foreign' => 'id'));
		$this -> hasMany('facilities as hosi', array('local' => 'facility', 'foreign' => 'facility_code'));
	    $this -> hasOne('Facility_Issues as idid', array('local' => 'id', 'foreign' => 'issued_by'));
		
		
	}

	protected function _encrypt_password($value) {
		$salt = '#*seCrEt!@-*%';
		$this->_set('password', md5($salt . $value));
		
	}
	
	public static function login($username, $password) {
		
		$salt = '#*seCrEt!@-*%';
		$value=( md5($salt . $password));
		$query = Doctrine_Query::create() -> select("*") -> from("User") -> where("username = '" . $username . "' and password='". $value ."'");

		$x = $query -> execute();
		return $x[0];
		
		
	}
	public static function getsome($id) {
		$query = Doctrine_Query::create() -> select("fname") -> from("user")->where("id='$id' ");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll2($facility,$id) {
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id=2 or usertype_id=5 ")->andWhere("id <> $id and facility='$facility'");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll3($use_id) {
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id=2 and id=$use_id");
		$level = $query -> execute();
		return $level;
		
	}
	public static function getAll4($use_id) {
		$myobj = Doctrine::getTable('user')->findOneById($use_id);
        $id=$myobj->id ;
		$my_array =array('0'=>$id);
		return $my_array;
	}
	public static function getAll(){
		$query = Doctrine_Query::create() -> select("*") -> from("user");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll5($district, $id){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("district=$district") ->andWhere("id <> $id");
		$level = $query -> execute();
		return $level;
	}
	public static function getUsers($facility_c){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("facility=$facility_c");
		$level = $query -> execute();
		return $level;
	}
	public static function get_user_info($facility_code) {
		$query = Doctrine_Query::create() -> select("DISTINCT usertype_id, telephone,district, facility") -> from("user")->where("status='1' and  facility='$facility_code'");
		$info = $query -> execute();
		
		return $info;
	}
	public static function getAllUser($use_id){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("id=$use_id");
		$level = $query -> execute();
		return $level;
	}
	public static function getemails($facility){
		$query = Doctrine_Query::create() -> select("email") -> from("user")->where("facility=$facility");
		$level = $query -> execute();
		return $level;
	}
	///////
public static function check_user_email($email){
	$query = Doctrine_Query::create() -> select("*") -> from("user")->where("`email` like '%$email%'");
		$level = $query -> execute();
		return count($level);
}
///// reset password/
public static function reset_password($id){
	    $myobj = Doctrine::getTable('user')->findOneById($id);
        $myobj->password='123456' ;
		$myobj->save();
		return true;
}
///// reset password/
public static function activate_deactivate_user($id,$option){
	    $myobj = Doctrine::getTable('user')->findOneById($id);
        $myobj->status=$option ;
		$myobj->save();
		return true;
}
//////get the dpp details 
public static function get_dpp_details($distirct){
	$query = Doctrine_Query::create() -> select("*") -> from("user")->where("district=$distirct and usertype_id='3' ");
		$level = $query -> execute();
		return $level->toArray();
}


}

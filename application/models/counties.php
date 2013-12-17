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
	
	
	public static function get_county_map_data() {
		$query = Doctrine_Query::create() -> select("*") -> from("counties")-> OrderBy("kenya_map_id asc, county asc");
		$drugs = $query -> execute();
		return $drugs;
	}
	
	
	public static function get_county_name($county_id){
$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT county, id
FROM counties
WHERE counties.id='$county_id' ");
return $q;
	}
	public static function get_district_expiry_summary($date,$county){
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT COUNT(DISTINCT stock.facility_code) as facility_count, stock.facility_code, stock.balance,stock.quantity,stock.status,stock.stock_date,stock.sheet_no, f.facility_name, d.id as district_id, d.district
			FROM Facility_Stock stock, facilities f, districts d, counties c
			WHERE stock.expiry_date<='$date'
			AND stock.status=1
			AND stock.facility_code=f.facility_code
			AND f.district=d.id
			AND d.county=c.id
			AND c.id='$county'
			GROUP BY d.district");	
		return $query;
	}


	public static function get_district_received($district){
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT o.id,o.orderDate,o.facilityCode, COUNT(o.facilityCode) as facility_count,o.deliverDate,o.remarks,o.orderStatus,o.dispatchDate,o.approvalDate,o.kemsaOrderid,o.orderTotal,o.status,o.orderby,o.order_no, f.facility_code, f.facility_name, d.id as district_id, d.district
			FROM ordertbl o, facilities f, districts d, counties c
			WHERE o.orderStatus='delivered'
			AND o.facilityCode=f.facility_code
			AND f.district=d.id
			AND d.id='$district' GROUP BY d.district");
		return $query;
	}
	public static function get_county_order_details($county){
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT 
		(SELECT COUNT(o.facilityCode) FROM ordertbl o WHERE o.orderStatus='Pending') as pending_orders,
		 (SELECT COUNT(o.facilityCode) FROM ordertbl o WHERE o.orderStatus='delivered') as delivered_orders, 
		 (SELECT COUNT(o.facilityCode) FROM ordertbl o WHERE o.orderStatus='approved') as approved_orders
		FROM ordertbl o, facilities f, districts d, counties c
			WHERE o.orderStatus='delivered'
			AND o.facilityCode=f.facility_code
			AND f.district=d.id
			AND d.county=c.id
			AND c.id='$county'");
		return $query;
	}

	public static function get_county_p_stockouts($date,$county,$date1){
		//echo $date.'<br>',$facility.'<br>',$date1.'<br>';
		$query = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT stock.facility_code,stock.kemsa_code,stock.batch_no,stock.manufacture,stock.expiry_date,stock.balance,stock.quantity,stock.status,stock.stock_date,stock.sheet_no, f.facility_code, f.facility_name, d.id as district_id, d.district
			FROM Facility_Stock stock, facilities f, districts d, counties c 
			WHERE stock.facilityCode=f.facility_code
			AND stock.expiry_date between '$date1' AND '$date'
			AND f.district=d.id
			AND d.county=c.id
			AND c.id='$county'");
		$stockouts = $query -> execute();
		return $stockouts;
	}
	public static function get_district_p_stockouts($date,$district,$date1){
		//echo $date.'<br>',$facility.'<br>',$date1.'<br>';
		$query = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT stock.facility_code,stock.kemsa_code,stock.batch_no,stock.manufacture,stock.expiry_date,stock.balance,stock.quantity, (stock.balance*stock.quantity) as total, stock.status,stock.stock_date,stock.sheet_no,f.facility_code, f.facility_name, d.id as district_id, d.district
			FROM Facility_Stock stock, facilities f, districts d, counties c 
			WHERE stock.facilityCode=f.facility_code
			AND stock.expiry_date between '$date1' AND '$date'
			AND f.district=d.id
			AND d.id='$district'");
		$stockouts = $query -> execute();
		return $stockouts;
	}
	public static function get_potential_expiry_summary($county){
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("select  d1.id as district_id, d1.district, f.facility_code, f.facility_name, sum(temp.total) as total
from districts d1, facilities f left join
     (
select  ROUND( (
SUM( f_s.balance ) / d.total_units ) * d.unit_cost, 1
) AS total, f_s.facility_code from facility_stock f_s, drug d
where d.id=f_s.kemsa_code
AND f_s.expiry_date between DATE_ADD(CURDATE(), INTERVAL 1 day) and  DATE_ADD(CURDATE(), INTERVAL 6 MONTH)
AND f_s.status =(1 or 2)
GROUP BY f_s.kemsa_code,f_s.facility_code having total >1
     ) temp
     on temp.facility_code = f.facility_code
where  f.district = d1.id
AND d1.county =$county
and temp.total>0
group by f.facility_code");	
/////
		return $query;
	}	
	public static function get_county_expiries($date,$county){
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
		select  d1.id as district_id, d1.district, f.facility_code, f.facility_name, sum(temp.total) as total
from districts d1, facilities f left join
     (
select  ROUND( (
SUM( f_s.balance ) / d.total_units ) * d.unit_cost, 1
) AS total, f_s.facility_code from facility_stock f_s, drug d
where f_s.expiry_date < NOW( ) 
and d.id=f_s.kemsa_code
AND f_s.expiry_date < NOW( ) 
AND f_s.status =(1 or 2)
GROUP BY f_s.kemsa_code,f_s.facility_code having total >1

     ) temp
     on temp.facility_code = f.facility_code
where  f.district = d1.id
AND d1.county =$county
and temp.total>0
group by f.facility_code");	
		return $query;
	}
	public static function get_county_received($county){
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
select  temp.id, d.district, f.facility_name, f.facility_code,temp.orderDate,year(temp.orderDate) as mwaka,
temp.orderTotal, temp.total_delivered, temp.fill_rate from  districts d,facilities f
left join
     (
SELECT o.id, orderDate, o.facilityCode, o.orderTotal, o.total_delivered, IFNULL( ROUND( (
SUM( o_d.quantityRecieved ) / ROUND( SUM( o_d.quantityOrdered ) * d.total_units ) ) *100 ) , 0
) AS fill_rate
FROM ordertbl o, orderdetails o_d, drug d
WHERE o.orderStatus =  'delivered'
AND o_d.orderNumber = o.id
AND o_d.kemsa_code = d.id
GROUP BY d.id, o.id
     ) temp
     on temp.facilityCode = f.facility_code
     where  f.district = d.id
AND d.county =$county
group by f.facility_code having temp.id>0");		
		   return $query;


		   
	}
}

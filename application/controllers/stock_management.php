<?php 
include_once 'auto_sms.php';
class Stock_Management extends auto_sms {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url'));
	}
	//the facility is meant to update their stock level when they first run the system
	function facility_first_run(){
		$facility_code=$this -> session -> userdata('news');
		
		$data['title'] = "Update Stock Level on First Run";
     	$data['content_view'] = "update_stock_first_run";
		$data['banner_text'] = "Update Stock Level";
		$data['quick_link'] ="load_stock";
		$data['link'] = "home";
		$data['drugs'] = Drug::getAll();
		$data['drug_name']=Drug::get_drug_name();
		$data['first_run_temp']=Update_stock_first_temp::get_facility_temp($facility_code);
		$data['quick_link'] = "update_stock_level";
		$this -> load -> view("template", $data);
	}
	public function test2()
	{
		
		$facility_c=$this -> session -> userdata('news');
		
		$kemsa_code=$_POST['kemsa_code'];
		$expiry_date=$_POST['expiry_date'];
		$batch_no=$_POST['batch_no'];
		$manuf=$_POST['manuf'];
		$a_stock=$_POST['qreceived'];
		$count=count($kemsa_code);
		$orderDate=date('y-m-d H:i:s');
		
		
		//Facility_Transaction_Table::disable_facility_transaction_table($facility_c);
		//Facility_Stock::disable_facility_stock($facility_c);
		
		for($i=0;$i<=$count;$i++){
			
			if(isset($kemsa_code[$i])&&$kemsa_code[$i]!=''){
				
			$mydata=array('facility_code'=>$facility_c,
			'kemsa_code'=>$kemsa_code[$i],
			'batch_no'=>$batch_no[$i],
			'manufacture'=>$manuf[$i],
			'expiry_date'=> date('y-m-d ,', strtotime($expiry_date[$i])),
			'balance'=>$a_stock[$i],
			'quantity'=>$a_stock[$i],
			'stock_date'=>$orderDate);
			
			//Facility_Stock::update_facility_stock($mydata);
			
			
			}
		}
		//updating the facility transaction table
		$data=Facility_Stock::count_facility_stock($facility_c,$orderDate);
      
		foreach ($data as $infor) {
			$mydata2=array('Facility_Code'=>$facility_c,
			'Kemsa_Code'=>$infor->kemsa_code,
			'Opening_Balance'=>$infor->quantity1,
			'Total_Issues'=>0,
			'Total_Receipts'=>0,
			'Closing_Stock'=>$infor->quantity1,
			'availability'=>1,
			'Cycle_Date'=>$infor->stock_date);

			$mydata3 = array('facility_code'=>$facility_c,
			's11_No' => 'Physical Stock Count',
			'kemsa_code'=>$infor->kemsa_code,
			'batch_no' => 'N/A',
			'expiry_date' => 'N/A',
			'qty_issued' => 0,
			'balanceAsof'=>$infor->quantity1,
			'date_issued' => date('y-m-d'),
			'issued_to' => 'N/A',
			'issued_by' => $this -> session -> userdata('identity')
			);
			//Facility_Issues::update_issues_table($mydata3);
			//Facility_Transaction_Table::update_facility_table($mydata2);
		
		
			}
		
		//Update_stock_first_temp::delete_facility_temp(NULL,$facility_c);
		
//////////////////////////////////////////////////////////////////////////////////////////
		
  $this->send_stock_update_sms();
////////////////////////////////////////////////////////////////////////////////////////
}
     function send_stock_update_sms(){
     		$facility_name = $this -> session -> userdata('full_name');
		    $facility_c=$this -> session -> userdata('news');
			
	
		$data=User::get_user_info($facility_c);
		  $phone="";    
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone ="254726534272"; //$info->telephone;
			$district = $info->district;
			$facility = $info->facility;
			
		
		$phone .=$telephone.'+';	

		
		}
	    $message= "Stock level for facility ".$facility_name." has been updated.";
		$this->stock_level();

	}
	
	
		
     	
	
public function autosave_update(){
	$facility_c=$this -> session -> userdata('news');
	
	    $kemsa_code=$_POST['kemsa_code'];
		$expiry_date=$_POST['expiry_date'];
		$batch_no=$_POST['batch_no'];
		$manuf=$_POST['manu'];
		$stock_level=$_POST['stock_level'];
		$unit_count=$_POST['unit_count'];
		$category=$_POST['category'];
		$unit_size=$_POST['unit_size'];
		$facility_code=$facility_c;
		$drug_id=$_POST['drug_id'];
        $description=$_POST['description'];
	
			$mydata=array('facility_code'=>$facility_code,
			'kemsa_code'=>$kemsa_code,
			'batch_no'=>$batch_no,
			'manu'=>$manuf,
			'expiry_date'=> $expiry_date,
			'stock_level'=>$stock_level,
			'unit_count'=>$unit_count,
			'unit_size'=>$unit_size,
			'category'=>$category,
			'drug_id'=>$drug_id,
			'description'=>$description);
			
			Update_stock_first_temp::update_temp($mydata);
			
	echo "SUCCESS ".$description." ".$manuf;
}
public static function delete_temp_autosave(){
		if (isset($_POST['drugid'])) {
			$facilitycode=$_POST['facilitycode'];
			$drugid=$_POST['drugid'];
			
			//$this->send_sms();
			
			
			$detail = Update_stock_first_temp::delete_facility_temp($drugid, $facilitycode);
			
			
	}
else{
	echo $_POST['drugid'];
}
}

public function donation()
	{
		
		$facility_c=$this -> session -> userdata('news');
		
		$kemsa_code=$_POST['kemsa_code'];
		$expiry_date=$_POST['expiry_date'];
		$batch_no=$_POST['batch_no'];
		$manuf=$_POST['manuf'];
		$a_stock=$_POST['qreceived'];
		$count=count($kemsa_code);
		$source=$_POST['source'];
		$orderDate=date('y-m-d H:i:s');
				;
		
		for($i=0;$i<=$count;$i++){
			
			if(isset($kemsa_code[$i])&&$kemsa_code[$i]!=''){
				
			$mydata=array('facility_code'=>$facility_c,
			'kemsa_code'=>$kemsa_code[$i],
			'batch_no'=>$batch_no[$i],
			'manufacture'=>$manuf[$i],
			'expiry_date'=> date('y-m-d ,', strtotime($expiry_date[$i])),
			'balance'=>$a_stock[$i],
			'quantity'=>$a_stock[$i],
			'stock_date'=>$orderDate,
			'sheet_no'=>$source[$i]
			);
			
			Facility_Stock::update_facility_stock($mydata);

			}
		}

//updating the facility transaction table
		$data=Facility_Stock::count_facility_stock($facility_c,$orderDate);
      
	
	  
	  
		foreach ($data as $infor) {
			$qty=$infor->quantity1;
			$kemsa_code_=$infor->kemsa_code;
			
			$mydata3 = array('facility_code'=>$facility_c,
			's11_No' => 'Physical Stock Count',
			'kemsa_code'=>$kemsa_code_,
			'batch_no' => 'N/A',
			'expiry_date' => 'N/A',
			'qty_issued' => 0,
			'balanceAsof'=>$qty,
			'date_issued' => date('y-m-d'),
			'issued_to' => 'N/A',
			'issued_by' => $this -> session -> userdata('identity')
			);
			Facility_Issues::update_issues_table($mydata3);
		   $facility_has_commodity=Facility_Transaction_Table::get_if_drug_is_in_table($facility_c,$kemsa_code_);
		   
		   if($facility_has_commodity>0){
		   	$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection();
			$inserttransaction->execute("UPDATE `facility_transaction_table` SET adj =$qty
                                          WHERE `kemsa_code`= '$kemsa_code_' and availability='1' and facility_code=$facility_c; ");
		   }
		   else{
		   	$mydata2=array('Facility_Code'=>$facility_c,
			'Kemsa_Code'=>$kemsa_code_,
			'Opening_Balance'=>0,
			'Total_Issues'=>0,
			'Total_Receipts'=>0,
			'Adj'=>$qty,
			'Closing_Stock'=>$qty,
			'availability'=>1);
			
			Facility_Transaction_Table::update_facility_table($mydata2);
		   }
		   
		
			}

 $this->send_stock_update_sms();
      	
	}



	// moh offical is able to see the stock level balance
		function stock_level_moh(){
     	$data['title'] = "Stock level";
     	$data['content_view'] = "moh/stock";
		$data['banner_text'] = "Stock Level";
		$data['quick_link'] ="load_stock";
		$data['link'] = "home";
		$data['stock_count']=Facility_Stock::count_all_facility_stock();
		$data['counties'] = Counties::getAll();
		$data['quick_link'] = "load_stock";
		$this -> load -> view("template", $data);
	}
	function county_stock(){
		$data['title'] = "Stock level";
     	$data['content_view'] = "stock";
		$data['banner_text'] = "Stock Level";
		$data['quick_link'] ="load_stock";
		$data['link'] = "home";
		$data['stock_count']=Facility_Stock::count_all_county_stock($this->uri->segment(3));
		$data['countytest']=$this->uri->segment(4);
		$data['counties'] = Counties::getAll();
		$data['quick_link'] = "load_stock";
		$this -> load -> view("template", $data);
	}
	function get_facility_stock(){
		$data['title'] = "Stock level";
     	$data['content_view'] = "moh/stock";
		$data['banner_text'] = "Stock Level";
		$data['quick_link'] ="load_stock";
		$data['link'] = "home";
		$data['stock_count']=Facility_Stock::count_facility_stock($this->uri->segment(3));
		$data['facility']=$this->uri->segment(4);
		$data['counties'] = Counties::getAll();
		$data['quick_link'] = "load_stock";
		$this -> load -> view("template", $data);
	}
	// after the user confirms the order, the stock table should be updated static facility code!!
	function update_stock_level(){
		$order_dispatched=$_POST['order_dispatched'];
		$kemsa_order_no=$_POST['kemsa_order_no'];
		$r_name=$_POST['r_name'];
		$r_pin=$_POST['r_pin'];
		$r_phone=$_POST['r_phone'];
		$order_deliver=$_POST['deliver_date'];
		
		$drugs_stock=Kemsa_Order_Details::get_stock_to_update($kemsa_order_no);
		$count= $drugs_stock->Count();
		$data_array=$drugs_stock->toArray();
		for($i=0;$i<$count;$i++){
			$mydata=array_merge($data_array[$i],array('facility_code'=>17948));
			Facility_Stock::update_facility_stock($mydata);
		
		}
	    /*$count=1;
		$data_array=NULL;
		foreach($drugs_stock as $drug){
			if($count==1){ 
			 $data=array('facility_code'=>17948,
			 'kemsa_code'=>$drug->kemsa_code,
			 'batch_no'=>$drug->batch_no,
			 'manufacture'=>$drug->manufacture,
			 'expiry_date'=>$drug->expiry_date,
			 'quantity'=>$drug->quantity);
			
			 $data_array=array(); 
			 
			 $data_array=array_merge($data,$data_array);
			  
			 $count++;
			}
			else{
				
			$data=array('facility_code'=>17948,
			 'kemsa_code'=>$drug->kemsa_code,
			 'batch_no'=>$drug->batch_no,
			 'manufacture'=>$drug->manufacture,
			 'expiry_date'=>$drug->expiry_date,
			 'quantity'=>$drug->quantity);
			 $data_array=array_merge($data,$data_array);
            }
        
		}
		print_r($data_array);
		exit;
		    $status=*/
			
		     if($status==TRUE){     	
				$this->stock_level();
		     }
	}
public function stock_level(){
	 $facility_c=$this -> session -> userdata('news');
		//$checker=$this->uri->segment(3);
		$data['title'] = "Stock";
		$data['content_view'] = "facility/stock_level_v";
		$data['banner_text'] = "Update Physical Stock";
		$data['link'] = "order_management";
		$data['msg']=NULL;
		$data['facility_order'] = Facility_Transaction_Table::get_all($facility_c);
		$data['quick_link'] = "stock_level";
		$this -> load -> view("template", $data);
	}
public function allProducts(){
	
		$data['title'] = "Stock";
		$data['content_view'] = "all_products";
		$data['banner_text'] = "View Products";	
		$data['quick_link'] = "all_products";
		$data['drug_categories'] = Drug_Category::getAll();
		$this -> load -> view("template", $data);
}
public function new_update(){
		$id=$this->uri->segment(3);
		$data['title'] = "Update Deliveries";
		$data['content_view'] = "new_update";
		$data['banner_text'] = "Update Order Delivery";	
		$data['quick_link'] = "new_update";	
		$data['ord']=Ordertbl::get_details($id);
		$data['order_details']=Orderdetails::get_order_details($id);			
		$data['drugs'] = Drug::getAll();
		$this -> load -> view("template", $data);
}
//getting the socks of a facility
public function get_facility_stock_details($confirmation_message=NULL){
	    $facility_code=$this -> session -> userdata('news');
	    $data['title'] = "Edit Stock Details";
		$data['content_view'] = "facility/facility_reports/facility_stock_detail_v";
		$data['banner_text'] = "Edit Stock Details";	
		$data['quick_link'] = "new_update";	
		$data['confirmation_message']=$confirmation_message;
		$data['facility_stock_details']=facility_stock::get_facility_stock_detail($facility_code);			
		$this -> load -> view("template", $data);
}
public function update_facility_stock_details(){
	 $id=$_POST['id'];
	 $batch_no=$_POST['batch_no'];
	 $manufacturer=$_POST['manufacturer'];
	 $expiry_date=$_POST['expiry_date'];
	 
	 foreach ( $id as $key => $value) {
		 $myobj = Doctrine::getTable('Facility_Stock')->find($id[$key]);
         $myobj->batch_no=$batch_no[$key] ;
		 $myobj->manufacture=$manufacturer[$key];
		 $myobj->expiry_date=date('y-m-d',strtotime($expiry_date[$key]));
         $myobj->save(); 
	 }
	 
	$this->get_facility_stock_details($confirmation_message="Stock Details Have Been Updated");
	
}

}
?>
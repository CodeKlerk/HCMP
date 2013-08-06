<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Issues_main extends MY_Controller {
		function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url'));
		
		
	}
	
	
	public function index(){
	    $checker=$this->uri->segment(3);
		$facility=$this -> session -> userdata('news');
		$facility=$this->uri->segment(4);
		
	 		
		
			switch ($checker)
			{
				case 'Internal':
					$data['content_view'] = "IssueInternal_v";
					$data['title'] = "Stock";
					$data['banner_text'] = "Issue";
					$data['link'] = "IssuesnReceipts";
					$data['quick_link'] = "IssueInternal_v";
					break;
					case 'External':
						$data['content_view'] = "IssueExternal_v";
						$data['content_view'] = "IssueExternal_v";						
						$county=districts::get_county_id($this -> session -> userdata('district1'));
						$data['district']=districts::getDistrict($county[0]['county']);
						$data['banner_text'] = "Donate";
						$data['title'] = "Stock";
						$data['quick_link'] = "IssueExternal_v";
					break;
					
					case 'Donation':				   
		$data['title'] = "Update Stock Level: Donation";
     	$data['content_view'] = "facility/update_stock_donation_v";
		$data['banner_text'] = "Update Stock Level: Donation";
		$data['drug_categories'] = Drug_Category::getAll();
		$data['quick_link'] = "update_stock_level";
		
	   
						break;
					
					default;
						
						$data['content_view'] = "issuesnRecpt";
						$data['banner_text'] = "Issues Home";
						$data['title'] = "Stock";
						$data['quick_link'] = "issuenRecpt";
									
			}

		
		$data['service']=Service::getall($facility);		
		$data['drugs'] = Facility_Stock::getAllStock($facility);
		$data['link'] = "IssuesnReceipts";
     	$this -> load -> view("template", $data);

	}
	
	public function Insert()
	{
		
		$ids=$_POST['kemsaCode'];		
	    $Available=$_POST['AvStck'];
		$batchN=$_POST['batchNo'];
		$Expiry=$_POST['Exp'];
		$sNo=$_POST['s11N'];
        $qty=$_POST['qty'];
		$thedate=$_POST['datepicker'];
		$serviceP=$_POST['Servicepoint'];
        $j=sizeof ($ids);
       $count=0;
	   
	   
	   
        $facilityCode=$facility_c=$this -> session -> userdata('news');	
		$usernow=$this -> session -> userdata('identity');

		for($me=0;$me<$j;$me++){
        	        	
			if ($qty[$me]>0) {
				$count++;
				
				
				
				$mydata = array('facility_code' => $facilityCode,	'kemsa_code' => $ids[$me], 's11_No'=>$sNo[$me], 'batch_no' => $batchN[$me] ,
				'expiry_date' => $Expiry[$me] ,'qty_issued'=> $qty[$me] ,
				'issued_to'=>$serviceP,'balanceAsof'=>$Available[$me], 'date_issued'=>date('y-m-d',strtotime($thedate[$me])),'issued_by'=>$usernow);
				
				$u = new Facility_Issues();

    			$u->fromArray($mydata);

    			$u->save();
				//echo "$xraws records inserted";
				
			$q = Doctrine_Query::create()
			->update('Facility_Stock')
				->set('balance', '?', $Available[$me])
					->where("kemsa_code='$ids[$me]' AND batch_no='$batchN[$me]' and facility_code ='$facilityCode'");

			$q->execute();
			
			$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction->execute("UPDATE `facility_transaction_table` SET total_issues = (SELECT SUM(qty_issued) 
			FROM facility_issues WHERE kemsa_code = '$ids[$me]' and availability='1' and facility_code='$facilityCode')
                                          WHERE `kemsa_code`= '$ids[$me]' and availability='1' and facility_code='$facilityCode'; ");
			//echo "$numrows records updated";
			
			$inserttransaction1 = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction1->execute("UPDATE `facility_transaction_table` SET closing_stock = (SELECT SUM(balance)
			 FROM facility_stock WHERE kemsa_code = '$ids[$me]' and availability='1' and facility_code='$facilityCode')
                                          WHERE `kemsa_code`= '$ids[$me]' and availability='1' and facility_code ='$facilityCode'; ");
			}
			
			
			$data['title'] = "Stock";
			$data['drugs'] = Drug::getAll();
			$data['popout'] = "You have issued $count item(s)";
			$data['content_view'] = "issuesnRecpt";
			$data['banner_text'] = "Stock Control Card";
			$data['link'] = "order_management";
     		$data['quick_link'] = "stockcontrol_c";
			$this -> load -> view("template", $data);
			
		}
        
        
		
		
	}

public function InsertExt()
	{
		//exit;
		$ids=$_POST['kemsaCode'];
		$mfl=$_POST['mfl'];			
	    $Available=$_POST['AvStck'];
		$batchN=$_POST['batchNo'];
		$Expiry=$_POST['Expiries'];
		$sNo=$_POST['S11'];
        $qty=$_POST['Qtyissued'];
		$thedate=$_POST['date_issue'];
        $j=sizeof ($ids);
       $count=0;
	   $facilityCode=$facility_c=$this -> session -> userdata('news');
       $usernow=$this -> session -> userdata('identity'); 
		
		//loop through all th donated commodities and process
		for($me=0;$me<$j;$me++){
        	        	
			if ($qty[$me]>0) {
				///update the donating facility details
				$facility_name=Facilities::get_facility_name($mfl[$me]);
				$facility_details=$facility_name['facility_name']." ".$mfl[$me];
		        $sNo="Donation :".$sNo[$me];
				$count++;
				
				////checking if the facilility receiving the commodities is using HCMP
				$users_array=user::getUsers($mfl[$me]);
				$user_in_donated_facility=count($users_array);
				
				//inserting in the facility issues 
				$mydata = array('facility_code' => $facilityCode,'kemsa_code' => $ids[$me], 's11_No'=>$sNo, 'batch_no' => $batchN[$me] ,'expiry_date' => date('y-m-d',strtotime($Expiry[$me])) ,'qty_issued'=> $qty[$me] ,'balanceAsof'=>$Available[$me],
				 'date_issued'=>date('y-m-d',strtotime($thedate[$me])),'issued_to'=>$facility_details,'issued_by'=>$usernow);
				
				$u = new Facility_Issues();

    			$u->fromArray($mydata);

    			$u->save();
				
				//updating the facility stock
			$q = Doctrine_Query::create()
			->update('Facility_Stock')
				->set('balance', '?', $Available[$me])
					->where("kemsa_code='$ids[$me]' AND batch_no='$batchN[$me]'");

			$q->execute();
			///updating the trascation_table
			$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction->execute("UPDATE `facility_transaction_table` SET adj = (SELECT (SUM(qty_issued)*-1) FROM facility_issues WHERE kemsa_code = '$ids[$me]' and issued_to='$facility_details'and availability='1')
                                          WHERE `kemsa_code`= '$ids[$me]' and availability='1' and facility_code=$facilityCode; ");
			
			
			$inserttransaction1 = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction1->execute("UPDATE `facility_transaction_table` SET closing_stock = (SELECT SUM(balance) FROM facility_stock WHERE kemsa_code = '$ids[$me]'
			and availability='1' and facility_code='$facilityCode' and availability='1')
                                          WHERE`kemsa_code`= '$ids[$me]' and availability='1' and facility_code=$facilityCode; ; ");
					
						
			///updating the receiving facility records if they are using the system							  
			if($user_in_donated_facility>0){
				//getting the name of the mauf of the given drug
			$mauf=facility_stock::get_batch_details($batchN[$me],$ids[$me]);
				
			$mydata=array('facility_code'=>$mfl[$me],
			'kemsa_code'=>$ids[$me],
			'batch_no'=>$batchN[$me],
			'manufacture'=>$mauf['manufacture'],
			'expiry_date'=> date('y-m-d', strtotime($Expiry[$me])),
			'balance'=>$qty[$me] ,
			'quantity'=>$qty[$me] ,
			'stock_date'=>date('y-m-d'));
			
			Facility_Stock::update_facility_stock($mydata);	
			///checking if the receiving_facility_has_this_drug  //kemsa_code facility code
			$receiving_facility_has_this_drug=Facility_Transaction_Table::get_if_drug_is_in_table($mfl[$me],$ids[$me]);
			
			
			if(count($receiving_facility_has_this_drug)>0){//if yes update their records
				
			
			
			$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction->execute("UPDATE `facility_transaction_table` SET adj = (SELECT SUM(qty_issued) FROM facility_issues WHERE kemsa_code = '$ids[$me]' and issued_to='$facility_details' and availability='1')
                                          WHERE `kemsa_code`= '$ids[$me]' and availability='1' and facility_code=$mfl[$me]; ");
			
			
			$inserttransaction1 = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction1->execute("UPDATE `facility_transaction_table` SET closing_stock = (SELECT SUM(qty_issued) FROM facility_issues WHERE kemsa_code = '$ids[$me]' and issued_to='$facility_details' and availability='1')
                                          WHERE`kemsa_code`= '$ids[$me]' and availability='1' and facility_code=$mfl[$me];");
			
			}
			
			else{
				//if no insert the record in the transaction table
				
				$mydata2=array('Facility_Code'=>$mfl[$me],
			'Kemsa_Code'=>$ids[$me],
			'Opening_Balance'=>0,
			'Total_Issues'=>0,
			'Total_Receipts'=>0,
			'Adj'=>$qty[$me],
			'Closing_Stock'=>$qty[$me],
			'availability'=>1);
			
			Facility_Transaction_Table::update_facility_table($mydata2);
			
			}
				
			}	else{
				//do nothing
			}						  
				
			}
			
			
			
			
        	
		}
             $data['title'] = "Stock";
			$data['drugs'] = Drug::getAll();
			$data['popout'] = "You have Donated $count item(s)";
			$data['content_view'] = "issuesnRecpt";
			$data['banner_text'] = "Stock Control Card";
			$data['link'] = "order_management";
     		$data['quick_link'] = "stockcontrol_c";
			$this -> load -> view("template", $data);
        
		
		
	}
	
	}
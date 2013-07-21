<?php
/**
* 
*/
class issues_inline extends MY_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url'));
		
		
	}
	
	public function index(){
//	    $checker=$this->uri->segment(3);
//		$facility=$this -> session -> userdata('news');
//		$facility=$this->uri->segment(4);
$checker ="Internal";
$facility = '17401';	
		
		
			switch ($checker)
			{
					case 'Internal':
						$data['content_view'] = "IssueInternal_v_inline";
						$data['title'] = "Stock";
						$data['banner_text'] = "Issue";
						$data['link'] = "IssuesnReceipts";
						$data['quick_link'] = "IssueInternal_v_inline";
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

		
     	$this -> load -> view("issueinternal_v_inline", $data);
return $data;
	}

	public function codeklerk(){ 
                                        
         $data['content_view'] = "IssueInternal_v_inline";
         $data['title'] = "Stock";
	 $data['banner_text'] = "Issue";
         $data['link'] = "IssuesnReceipts";
	 $data['quick_link'] = "IssueInternal_v_inline";
	 
		$data['service']=Service::getall(17401);		
		$data['drugs'] = Facility_Stock::getAllStock(17401);
		$this -> load -> view("template",$data);
	}



}

?>
<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Report_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
		public function get_order_details_report(){
$order_id=0;
$kemsa_id=NULL;		
$order_id=$this->uri->segment(3);	
$kemsa_id=$this->uri->segment(4);
$detail_list=Orderdetails::get_order($order_id);	
$table_body="";
$total_fill_rate=0;
$order_value =0;
$tester= count($detail_list);
      if($tester==0){
      	
      }
	  else{
	  	

      
		foreach($detail_list as $rows){
			//setting the values to display
			 $received=$rows->quantityRecieved;
			 $price=$rows->price;
			 $ordered=$rows->quantityOrdered;
			 $code=$rows->kemsa_code;
			 
			 $total=$price* $ordered;
			 
			 
			 
		     if($ordered==0){
				$ordered=1;
			}
		    $fill_rate=round(($received/$ordered)*100,0,PHP_ROUND_HALF_UP);
	        $total_fill_rate=$total_fill_rate+$fill_rate;
		 
		
		 foreach($rows->Code as $drug) {
		 	
			 $drug_name=$drug->Drug_Name;
			 $kemsa_code=$drug->Kemsa_Code;
			 $unit_size=$drug->Unit_Size;
			 
			foreach($drug->Category as $cat){
				
			$cat_name=$cat;		
			}	 
		}
		 switch ($fill_rate) {
		case $fill_rate==0:
		 $table_body .="<tr style=' background-color: #FBBBB9;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;  	
				 
		 case $fill_rate<=60:
		 $table_body .="<tr style=' background-color: #FAF8CC;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;  
				 
				 case $fill_rate==100.01 || $fill_rate>100.01:
		 $table_body .="<tr style=' background-color: #FBBBB9;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;
				  
			 case $fill_rate==100:
		 $table_body .="<tr style=' background-color: #C3FDB8;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;
				 
				 default :
		 $table_body .="<tr>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;
			
		 }
		 
				  } 
	
	$order_value  = round(($total_fill_rate/count($detail_list)),0,PHP_ROUND_HALF_UP);
		} 


$table_head='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#D8D8D8;}</style><div > Fill Rate = (Quantity Received / Quantity Ordered ) * 100</div>
<caption ><p style="letter-spacing: 1px;font-weight: bold;text-shadow: 0 1px rgba(0, 0, 0, 0.1);font-size: 14px; " >Facility Order No '.$order_id.' | KEMSA Order No '.$kemsa_id.'  |Order Fill Rate '.$order_value.'%</p></caption><table class="data-table" style="margin-left: 0px">
<tr>
<td width="50px" style="background-color: #C3FDB8; "></td><td>Full Delivery 100%</td><td width="50px" style="background-color:#FFFFFF"></td><td>Ok Delivery 60%-less than 100%</td><td width="50px" style="background-color:#FAF8CC;"></td><td>Partial Delivery less than 60% </td><td width="50px" style="background-color:#FBBBB9;"></td><td>Problematic Delivery 0% or over 100%</td>
</tr></table>
<table class="data-table" width="100%">
<thead>
<tr>
<th><strong>Category</strong></th>
<th><strong>Description</strong></th>
<th><strong>KEMSA&nbsp;Code</strong></th>
<th><strong>Unit Size</strong></th>
<th><strong>Unit Cost Ksh</strong></th>
<th><strong>Quantity Ordered</strong></th>
<th><strong>Total Cost</strong></th>
<th><strong>Quantity Received</strong></th>
<th><strong>Fill rate</strong></th>
</tr>
</thead>
<tbody>';
	
		//echo $table_body;
	
$table_foot='</tbody></table>';
$report_name="Order-$order_id-detail-fill-rate";
$title="Order number $order_id fill rate";
$html_data=$table_head.$table_body.$table_foot;
$report_type='Download PDF';

$this->generate_pdf($report_name,$title,$html_data,$report_type);
	}
	
 public function commodity_excel(){
 	$drug_categories= Drug_Category::getAll();;
	$data='<table style="margin-left: 0;" width="80%">';
	
		foreach($drug_categories as $category):
			$data .=  '<tr><td style="font-weight: bold; text-align:left;">'.$category->Category_Name.'</td></tr>';
			$data .='<td><table style="margin-left: 0;" width="80%">
					<thead>
					<tr>
						<th style="text-align:left;"><b>KEMSA Code</b></th>
						<th style="text-align:left;"><b>Description</b></th>
						<th style="text-align:left;"><b>Order Unit Size</b></th>
						<th><b>Order Unit Cost (KSH)</b></th>				    
					</tr>
					</thead>';
						foreach($category->Category as $drug):
							$data .= '
						<tr>
							<td style="text-align:left;">'.$drug->Kemsa_Code.'</td>
							<td style="text-align:left;">'.$drug->Drug_Name.'</td>
							<td style="text-align:left;"> '. $drug->Unit_Size.'</td>
							<td style="text-align:left;"> '.$drug->Unit_Cost.' </td>
						</tr>';

							 endforeach;
							$data .='</tbody></table></td>';	 			
		 endforeach;
$data .='</table>';
 $filename="commodity_list_2012_2013";                      
          header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo "$data"; 
 }
	public function index() {
		$data['title'] = "System Reports";
		$data['content_view'] = "reports_v";
		$data['banner_text'] = "System Reports";
		$data['link'] = "reports_management";
		$this -> load -> view("template", $data);
	}
	public function tem(){
		$facility_code=$this -> session -> userdata('news');
		$data['title'] = "Stock Report";
		$data['category']=Drug_Category::getAll();
		$data['service_p']=Service::getall($facility_code);
		$data['content_view'] = "test";
		$data['banner_text'] = "Stock Report";
		$data['link'] = "reports_management";
		$this -> load -> view("template", $data);
	}
	public function get_drug_names(){
		//for ajax
		$district=$_POST['category_id'];
		$facilities=Drug::get_drug_name_by_category($district);
		$list="";
		foreach ($facilities as $facilities) {
			$list.=$facilities->Kemsa_Code;
			$list.="*";
			$list.=$facilities->Drug_Name;
			$list.="_";
		}
		echo $list;
	}
	public function commodity_search(){
		$data['title'] = "Commodity List";
		$data['content_view'] = "new_order_v2";
		$data['banner_text'] = "Commodity List";
		$data['link'] = "order_management";
		$data['drug_categories'] = Drug_Category::getAll();
		$data['quick_link'] = "commodity_list";
		$this -> load -> view("template", $data);
	}
	public function commodity_list(){
		$data['title'] = "Commodity Search";
		$data['content_view'] = "new_order_v2";
		$data['banner_text'] = "Commodity List";
		$data['link'] = "order_management";
		$data['drug_categories'] = Drug_Category::getAll();
		$data['quick_link'] = "commodity_list";
		$this -> load -> view("template", $data);
	}
	public function reports_Home()
	{
		
		$data['title'] = "Reports Home";
		$data['quick_link'] = "Reports";
		$data['content_view'] = "reportsmain";
		$data['drugs'] = Drug::getAll();
		$data['link'] = "raw_data";   
		$data['banner_text'] = "Reports";
		$data['link'] = "Reports";
		$this -> load -> view("template", $data);
	}
	public function division_reports(){
		$data['title'] = "Division Reports";
		$data['quick_link'] = "Reports";
		$data['content_view'] = "district/district_report/divisionreports_v";
		$data['banner_text'] = "Division Reports";
		$data['link'] = "Reports";
		$this -> load -> view("template", $data);
	}
	public function consum_v(){                   //New
               $data['title'] = "Stock Control Card";
			   $data['drugs'] = Drug::getAll();
			   $data['content_view'] = "stockcontrolC";
               $data['banner_text'] = "Stock Control Card";
               $data['link'] = "order_management";
               $data['quick_link'] = "facility_consumption";
               $this -> load -> view("template", $data);           
}
public function malaria_report(){   
		$facilityCode= $this-> session-> userdata('news');              //New
    	$current_year = date('Y');
		$current_month = date('F');
		$id=$this -> session -> userdata('identity');
		$data['title'] = "Monthly Summary Report for the Division of Malaria Control";
		$data['content_view'] = "facility/malaria_report_v";
		$data['banner_text'] = "Division of Malaria Control Report";
		$data['link'] = "order_management";
		$data['quick_link'] = "facility_consumption";
		$this -> load -> view("template", $data);
}

public function dist_malaria_report(){
	$this -> load -> view("district/district_report/malaria_report_v");
} 

public function dist_contraceptives_consumption_report(){
	$this -> load -> view("district/district_report/facility_contraceptives_v");
}
public function get_malaria_report_pdf($reportType){
		$facilityCode= $this-> session-> userdata('news');
		$current_year = date('Y');
		$current_month = date('F');
		$current_monthdigit = date('m');
		$id=$this -> session -> userdata('identity');
		$report_name='Division of Malaria Control Report for ' .$current_month. ' ' .$current_year;
		$title='Monthly Summary Report for the Division of Malaria Control';
		
$html_data='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#C9C299;}</style>';

$html_data1 = '';
/*****************************setting up the report*******************************************/
$html_data1 .='<table class="data-table" border=1><thead>
			<tr>		
				<th style = "font-size: 12px"><strong>Data Element</strong></th>
				<th style = "font-size: 12px"><strong>Beginning Balance</strong></th>
				<th style = "font-size: 12px"><strong>Quantity Received this Period</strong></th>
				<th style = "font-size: 12px"><strong>Total Quantity Dispensed</strong></th>
				<th style = "font-size: 12px"><strong>Losses (Excluding Expiries)</strong></th>
				<th style = "font-size: 12px"><strong>Positive Adjustments</strong></th>				
				<th style = "font-size: 12px"><strong>Negative Adjustments</strong></th>
				<th style = "font-size: 12px"><strong>Physical Count</strong></th>
				<th style = "font-size: 12px"><strong>Quantity of Expired Drugs</strong></th>
				<th style = "font-size: 12px"><strong>Medicines with 6 Months to Expiry</strong></th>
				<th style = "font-size: 12px"><strong>Days Out of Stock</strong></th>
				<th style = "font-size: 12px"><strong>Total</strong></th>			

</tr></thead><tbody>';

$query = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT f.facility_code,  f.kemsa_code,  d.id,  d.drug_name, d.unit_cost, f.cycle_date, f.opening_balance, f.total_receipts, f.total_issues, f.closing_stock, f.days_out_of_stock, f.adj, f.losses
FROM  facility_transaction_table f
INNER JOIN  drug d ON  d.id =  f.kemsa_code
WHERE d.drug_name LIKE  '%Artemether%'
AND f.cycle_date LIKE '%$current_year-$current_monthdigit%'
OR d.drug_name LIKE  '%Quinine%'
AND f.cycle_date LIKE '%$current_year-$current_monthdigit%'
OR d.drug_name LIKE  '%Artesunate%'
AND f.cycle_date LIKE '%$current_year-$current_monthdigit%'
OR  d.drug_name LIKE  '%Sulfadoxine%'
AND f.cycle_date LIKE '%$current_year-$current_monthdigit%'
ORDER BY  d.drug_name ASC ");
$results = count($query);
if ($results>0){

for ($got = 0; $got<$results; $got++){
$unitCost = 0.00;
	$drugID = $query[$got]['kemsa_code'];
	switch($drugID){
		case '41':
		$unitCost = 575.00;
		break;
		case '58':
		$unitCost = 1534.5;
		break;
		case '25':
		$unitCost = 4444.00;
		break;
		case '1':
		case '2':
		case '3':
		case '4':
		$unitCost = 0.01;
		break;
	}
$dataElement = $query[$got]['drug_name'];
	$bBalance = $query[$got]['opening_balance']*$unitCost;
	$qReceived = $query[$got]['total_receipts']*$unitCost;
	$qDispensed = $query[$got]['total_issues']*$unitCost;
	$losses = $query[$got]['losses']*$unitCost;
	$posAdjustments = $query[$got]['adj']*$unitCost;
	$negAdjustments = 0*$unitCost;
	$physicalCount = $query[$got]['closing_stock']*$unitCost;
	$quantityOfExp = 0*$unitCost;
	$medsAboutToExp = 0*$unitCost;
	$daysOutOfStock = 0;
	$total = 0;			    
							
$html_data1 .='<tr><td>'.$dataElement.'</td>
				<td>'.$bBalance.'</td>
				<td>'.$qReceived.'</td>
				<td>'.$qDispensed.'</td>
				<td>'.$losses.'</td>
				<td >'.$posAdjustments.'</td>
				<td >'.$negAdjustments.'</td>
				<td>'.$physicalCount.'</td>
				<td >'.$medsAboutToExp.'</td>
				<td >'.$quantityOfExp.'</td>
				<td >'.$daysOutOfStock.'</td>
				<td >'.$total.'</td>
				</tr>';
			}
			}
		

$html_data1 .='</tbody></table>';
$html_data .=$html_data1;

$report_type=$reportType;
switch ($report_type) {
	case 'excel':
		$this->generate_malaria_excel($report_name,$title,$html_data);
		break;
	case 'pdf':
		$this->generate_malaria_pdf($report_name,$title,$html_data,$report_type, $current_month, $current_year);
		break;
}
}
public function generate_malaria_excel($r_name,$title,$data){
	
 $filename=$r_name;                      
          header("Content-type: application/excel");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo "$data"; 
}
public function generate_malaria_pdf($r_name,$title,$data,$display_type, $current_month, $current_year){
		$current_year = date('Y');
		$current_month = date('F');
		$facility_code=$this -> session -> userdata('news');
		$facility_name_array=Facilities::get_facility_name($facility_code)->toArray();
		$facility_name=$facility_name_array['facility_name'];
		$districtName = $this->session->userdata('full_name');
					
	/********************************************setting the report title*********************/
			
		$html_title="<div ALIGN=CENTER><img src='".base_url()."Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold;'>Monthly Summary Report for the Division of Malaria Control</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold; '>
       Ministry of Public Health and Sanitation/Ministry of Medical Services</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>".$districtName." District</h2>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>".$current_month." ".$current_year."</h2>
       <hr />   ";
		

		$css_path=base_url().'CSS/style.css';
		
		/**********************************initializing the report **********************/
            $this->load->library('mpdf');
            $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
            $this->mpdf->SetTitle($title);
            $this->mpdf->WriteHTML($html_title);
            $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML('<br/>');
            $this->mpdf->WriteHTML($data);
			$report_name = $r_name.".pdf";
            $this->mpdf->Output($report_name,'D');
	}
public function Contraceptives_Report(){                   //New
               $data['title'] = "Contraceptives Consumption";
			   //$data['drugs'] = Drug::getAll();
			   $data['content_view'] = "facility/contraceptives_consumption_v";
               $data['banner_text'] = "Division of Reproductive Health - Contraceptives Consumption Report";
               $data['link'] = "order_management";
               $data['quick_link'] = "facility_consumption";
               $this -> load -> view("template", $data);           
}

public function Contraceptives_Report_pdf($reportType){
$report_name="Division of Reproductive Health - Division of Reproductive Health Report";
$title="Division of Reproductive Health Report";
$html_data1 ='';

$html_data1="<table border=1><tbody>
					<tr>
						<th><b>Contraceptive</b></th>
						<th><b>Beginning Balance</b></th>
						<th><b>Received This Month</b></th>
						<th><b>Dispensed</b></th>
						<th><b>Losses</b></th>
						<th><b>Adjustments</b></th>
						<th><b>Ending Balance</b></th>	
						<th><b>Quantity Requested</b></th>
								    
					</tr>
					<tr>
						<th><b>Combined Oral Contraceptive Pills</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
											    
					</tr>
					
					<tr>
						<th><b>Progestin Only Pills</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
													    
					</tr>
					<tr>
						<th><b>Injectables</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
														    
					</tr>
					<tr>
						<th><b>Implants(1-rod)</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
														    
					</tr>
					<tr>
						<th><b>Implants(2-rod)</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
														    
					</tr>
					
					<tr>
						<th><b>Emergency Contraceptive Pills</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
												    
					</tr>
					<tr>
						<th><b>IUCDs</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
														    
					</tr>
					<tr>
						<th><b>Male Condoms</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
														    
					</tr>
					<tr>
						<th><b>Female Condoms</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
												    
					</tr>
					
					<tr>
						<th><b>Standard Days Method (SDM) Cycle Beads</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
													    
					</tr>
					<tr>
						<th><b>Others</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
													    
					</tr>
					
					";
$html_data1 .='</tbody></table>';
$html_data = $html_data1;
$report_type=$reportType;
switch ($report_type) {
	case 'excel':
		$this->generate_contraceptives_report_excel($report_name,$title,$html_data);
		break;
	case 'pdf':
		$this->generate_contraceptive_report_pdf($report_name,$title,$html_data);
		break;
}


}

public function generate_contraceptive_report_pdf($report_name,$title,$html_data){
		$current_year = date('Y');
		$current_month = date('F');
		$facility_code=$this -> session -> userdata('news');
		$facility_name_array=Facilities::get_facility_name($facility_code)->toArray();
		$facility_name=$facility_name_array['facility_name'];
		//if ($display_type == "Download PDF") {
			
			/********************************************setting the report title*********************/
			
		$html_title="<div ALIGN=CENTER><img src='".base_url()."Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold;'>Division of Reproductive Health Report</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold; '>
       Ministry of Public Health and Sanitation/Ministry of Medical Services</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>".$current_month." ".$current_year."</h2>
       <hr />   ";
		

		$css_path=base_url().'CSS/style.css';
		
		/**********************************initializing the report **********************/
            $this->load->library('mpdf');
            $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
			//$stylesheet = file_get_contents("$css_path");
			//$this->mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
            $this->mpdf->SetTitle($title);
            $this->mpdf->WriteHTML($html_title);
            $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML('<br/>');
            $this->mpdf->WriteHTML($html_data);
			$reportname = $report_name.".pdf";
            $this->mpdf->Output($reportname,'D');

	}
public function generate_contraceptives_report_excel($report_name,$title,$html_data){
		$data = $html_data;
 $filename=$report_name;                      
          header("Content-type: application/excel");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo "$data"; 
		
	}

	public function Contraceptives_Consumption(){                   //New
               $data['title'] = "Contraceptives Consumption";
			   //$data['drugs'] = Drug::getAll();
			   $data['content_view'] = "facility/facility_contraceptives_v";
               $data['banner_text'] = "Division of Reproductive Health - D-CDRR";
               $data['link'] = "order_management";
               $data['quick_link'] = "facility_consumption";
               $this -> load -> view("template", $data);           
}


public function Contraceptives_Consumption_pdf($reportType){
$report_name="Division of Reproductive Health - D-CDRR";
$title="Contraceptives Consumption Data Report and Request Form(D-CDRR)";
$html_data='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#C9C299;}</style>';

		$html_data1 ='';	
		
		/*****************************setting up the report*******************************************/
$html_data1 .='<table class="data-table" border=1><tbody>
			<tr > 		
						<th><b>Programme</b></th>
						<th colspan = "3"><b>Family Planning</b></th>			
						<th colspan = "9"></th>
										    
					</tr>
<tr > 		
						<th><b>Name of District Store:</b></th>
						<th colspan = "4"><b></b></th>					
						
						<th><b>District:</b></th>
						<th colspan = "2"><b></b></th>
							
						<th><b>Province:</b></th>
						<th colspan = "4"><b></b></th>
							
										    
					</tr>
<tr > 		
						<th><b>Period of Reporting:</b></th>
						<th><b> Beginning:</b></th>
						<th colspan = "3"><b></b></th>					
						
						<th><b>Ending:</b></th>
						<th colspan = "7"><b></b></th>							
						
						</tr>
<tr > 		
						<th colspan="2"><b></b></th>
						<th colspan = "2"><b>(Day/Month/Year)</b></th>					
						<th colspan="2"></th>
						<th colspan = "2"><b>(Day/Month/Year)</b></th>						
						<th colspan="5"><b></b></th>
						</tr>
	<tr > 		
						<th><b>Contraceptive Name</b></th>
						<th><b>Unit of Issue</b></th>
						<th><b>Beginning Balance</b></th>
						<th><b>Quantity Received This Month</b></th>
						<th><b>Quantity Issued to facilities</b></th>
						<th><b>Losses</b></th>
						<th><b>Adjustments</b></th>
						<th><b>Ending Balance</b></th>	
						<th><b>Aggregated SDPs Quantity Dispensed</b></th>
						<th><b>Aggregated SDPs Ending Balance</b></th>
						<th><b>Quantity Requested for District Store</b></th>	
						<th><b>Quantity Requested (Aggregate SDP Qty Requested)</b></th>
						<th><i>Average MOS</i></th>				    
					</tr>
					<tr>
						<th><b>Combined Oral Contraceptive Pills</b></th>
						<th>Cycles</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>0</th>					    
					</tr>
					
					<tr>
						<th><b>Progestin Only Pills</b></th>
						<th>Cycles</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th>0</th>				    
					</tr>
					<tr>
						<th><b>Injectables</b></th>
						<th>Vials</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th>0</th>					    
					</tr>
					<tr>
						<th><b>Implants(1-rod)</b></th>
						<th>Sets</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>0</th>					    
					</tr>
					<tr>
						<th><b>Implants(2-rod)</b></th>
						<th>Sets</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>0</th>					    
					</tr>
					
					<tr>
						<th><b>Emergency Contraceptive Pills</b></th>
						<th>Doses</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>	
						<th>0</th>				    
					</tr>
					<tr>
						<th><b>IUCDs</b></th>
						<th>Sets</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>0</th>					    
					</tr>
					<tr>
						<th><b>Male Condoms</b></th>
						<th>Pieces</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>0</th>					    
					</tr>
					<tr>
						<th><b>Female Condoms</b></th>
						<th>Pieces</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>	
						<th>0</th>				    
					</tr>
					
					<tr>
						<th><b>Standard Days Method (SDM) Cycle Beads</b></th>
						<th>Cycles</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th>0</th>				    
					</tr>
					<tr>
						<th><b>Others</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						
						<th>0</th>				    
					</tr>
<tr>
						<th colspan = "10"><b>SERVICE STATISTICS</b></th>
								<th></th>
								<th></th>
						<th></th>		    
					</tr>
<tr>
						<th><b></b></th>
						<th colspan = "2"><b>Aggregate Clients	</b></th>
						<th colspan = "2"><b>Aggregate Change of Method</b></th>
						<th colspan="4"></th>
						<th><b>Natural FP Counseling</b></th>
						<th></th>
						<th colspan="2"></th>									    
					</tr>
<tr>
						<th></th>
						<th ><b>New	</b></th>
						<th><b>Revisits</b></th>
						<th ><b>From</b></th>
						<th><b>To</b></th>
						<th colspan="4"></th>						
						<th><b>Natural FP Referrals</b></th>
						<th></th>	
						<th colspan="2"></th>		    
					</tr>
<tr>
						<th><b>Combined Oral Contraceptive Pills</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="8"></th>								    
					</tr>
					<tr>
						<th><b>Progestin only pills</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2"><b>HIV Counselling & Testing</b></th>
						<th colspan="2">Known HIV status</th>
						<th colspan="3"></th>	
					</tr>
	<tr>
						<th><b>Injectables</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th><b>Counseled & Tested</b></th>
						<th><b>Referred for Counseling & Testing</b></th>	
						<th><b>1</b></th>
						<th><b>2</b></th>
						<th colspan="3"></th>	
															    
					</tr>
					<tr>
						<th><b>Implants</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th colspan="3"></th>	
						
										    
					</tr>
					<tr>
						<th><b>IUCDs</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2"><b>Sterilisation</b></th>	
						<th colspan="4"></th>  
					</tr>
<tr>
						<th><b>Male Condoms</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2"><b>Males</b></th>	
						<th></th>
						<th colspan="3"></th>	
							    
					</tr>
	<tr>
						<th><b>Female Condoms</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2"><b>Females</b></th>	
						<th></th>
						<th colspan="3"></th>
										    
					</tr>
					<tr>
						<th><b>Standard Days Method (SDM)</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2"><b>Referrals</b></th>	
						<th></th>
						<th colspan="3"></th>
										    
					</tr>
					<tr>
						<th colspan = "13"></th>
								    
					</tr>
					<tr>
						<th colspan="3"><b>SDP Reporting Rates</b></th>
						<th colspan="4"></th>
						<th colspan="2"><b>Cases for Emergency Pills</b></th>	
						<th></th>
						<th colspan="3"></th>										    
					</tr>
<tr>
						<th><b>Total Expected</b></th>
						<th ><b>Total Reported</b></th>
						<th><b>Reporting Rate</b></th>
						<th colspan="10"></th>						    
					</tr>
<tr>
						<th></th>
						<th ></th>
						<th><b>0%</b></th>
						<th colspan="10"></th>	
										    
					</tr>
					<tr><th colspan = "13"><b></b></th></tr>
			<tr>
						<th><b>Orders for Data</b></th>
						<th >DAR</th>
						<th></th>
						<th>SDP-CDRR</th>
						<th>DS-CDRR</th>
						<th colspan="8"></th>
						
										    
					</tr>
<tr>
						<th><b>Collection or</b></th>
						<th ></th>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="8"></th>
										    
					</tr>
	<tr>
						<th><b>Reporting tool</b></th>
						<th ><b>100 page</b></th>
						<th ><b>300 page</b></th>
						<th></th>
						<th></th>
						<th colspan="8"></th>
										    
					</tr>
<tr>
						<th><b>Quantity requested</b></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					<th colspan="8"></th>
						</tr>
		    <tr><th colspan = "13"></th></tr>
		    <tr>
						<th colspan="13"><b>Comments (On Commodity logistics and clinical issues, including explanation of Losses & Adjustments):</b></th>
						</tr>
						<tr>
						<th height="100px" colspan="13"></th>
						</tr>
					 <tr><th colspan = "13"></th></tr>
					 <tr>
						<th><b>Report submitted by: </b></th>
						<th colspan="3"></th>
						<th></th>
						<th colspan="2"></th>
						<th></th>
						<th colspan="2"></th>
						<th colspan="3"></th>
						
						</tr>
		<tr>
						<th></th>
						<th colspan="3">Head of the Health facility / SDP / Institution</th>
						<th></th>
						<th colspan="2">Designation</th>
						<th></th>
						<th colspan="2">Date</th>
						<th colspan="3"></th>
						</tr>
		<tr>
						<th><b>Report reviewed by:</b></th>
						<th colspan="3"></th>
						<th></th>
						<th colspan="2"></th>
						<th></th>
						<th colspan="2"></th>
						<th colspan="3"></th>
						</tr>
<tr>
						<th></th>
						<th colspan="3">Name of Reporting officer</th>
						<th></th>
						<th colspan="2">Designation</th>
						<th></th>
						<th colspan="2">Date</th>
						<th colspan="3"></th>
						</tr>
		';
$html_data1 .='</tbody></table>';
$html_data .=$html_data1;
$report_type=$reportType;
switch ($report_type) {
	case 'excel':
		$this->generate_contraceptives_consumption_excel($report_name,$title,$html_data);
		break;
	case 'pdf':
		$this->generate_contraceptives_consumption_pdf($report_name,$title,$html_data);
		break;
}

}

public function generate_contraceptives_consumption_pdf($report_name,$title,$html_data){
		$current_year = date('Y');
		$current_month = date('F');
		$facility_code=$this -> session -> userdata('news');
		$facility_name_array=Facilities::get_facility_name($facility_code)->toArray();
		$facility_name=$facility_name_array['facility_name'];
		$districtName = $this->session->userdata('full_name');
		//if ($display_type == "Download PDF") {
			
			/********************************************setting the report title*********************/
			
		$html_title="<div ALIGN=CENTER><img src='".base_url()."Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold;'>Contraceptives Consumption Data Report and Request Form(D-CDRR)</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold; '>
       Ministry of Public Health and Sanitation/Ministry of Medical Services</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>".$districtName." District</h2>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>".$current_month." ".$current_year."</h2>
       <hr />   ";
		

		$css_path=base_url().'CSS/style.css';
		
		/**********************************initializing the report **********************/
            $this->load->library('mpdf');
            $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
			//$stylesheet = file_get_contents("$css_path");
			//$this->mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
            $this->mpdf->SetTitle($title);
            $this->mpdf->WriteHTML($html_title);
            $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML('<br/>');
            $this->mpdf->WriteHTML($html_data);
			$reportname = $report_name.".pdf";
            $this->mpdf->Output($reportname,'D');
	}
public function generate_contraceptives_consumption_excel($report_name,$title,$html_data){
		$data = $html_data;
 $filename=$report_name;                      
          header("Content-type: application/excel");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo "$data"; 
		
	}
	
	//all the order reports to be generated
	public function order_report(){
					/****************************8get the facility code***************************************************/
  $facility_code=$this -> session -> userdata('news');
  $from_ordertbl=Ordertbl::get_facilitiy_orders($facility_code);
  //setting up the variables 
  $total_item_received=0;
  $total_item_ordered=0;
  $order_fill_rate=0;
  /****************************create a loop to fetch a facilities order details ***************/
  foreach($from_ordertbl as $infor_array){
		  
		  foreach($infor_array->Ord as $Ord_array){
		  	//giving the variables data
		  	$o_q=$Ord_array->quantityOrdered; 
		  	$total_item_ordered=$total_item_ordered+$o_q;
			$o_qr=$Ord_array->quantityRecieved; 
			$total_item_received=$total_item_received+$o_qr;
			
		  }
              if($total_item_ordered==0){$total_item_ordered=1;}
		    $order_fill_rate=($total_item_received/$total_item_ordered)*100;
		}
   //Create an XML data document in a string variable
   $strXML  = "";
   $strXML1="";
   $strXML .= "<chart bgAlpha='0' lowerLimit='0' upperLimit='100' numberSuffix='%25' showBorder='0' basefontColor='#8B8989' chartTopMargin='25' chartBottomMargin='25' chartLeftMargin='25' chartRightMargin='25' toolTipBgColor='80A905'  gaugeFillRatio='3'>";
   $strXML .= "<colorRange><color minValue='0' maxValue='45' code='FF654F'/><color minValue='45' maxValue='80' code='F6BD0F'/><color minValue='80' maxValue='100' code='8BBA00'/></colorRange>";
   $strXML .= "<dials><dial value='".$order_fill_rate."' rearExtension='10'/></dials>";
   $strXML .= "<trendpoints><point value='50' displayValue='Order Fill Rate' fontcolor='FF4400' useMarker='1' dashed='1' dashLen='2' dashGap='2' valueInside='1' /></trendpoints>";
   $strXML .= "<annotations><annotationGroup id='Grp1' showBelow='1' ><annotation type='rectangle' x='5' y='5' toX='345' toY='195' radius='10' color='#F0ECEC' showBorder='1' /></annotationGroup></annotations>";
   $strXML .= "<styles><definition><style name='RectShadow' type='shadow' strength='3'/></definition><application><apply toObject='Grp1' styles='RectShadow' /></application></styles>";
   $strXML .= "</chart>";
   
   /**********************************************/
    $strXML1 .= "<chart lowerLimit='0' upperLimit='100' lowerLimitDisplay='Good' upperLimitDisplay='Bad' palette='1' chartRightMargin='20'>";
    $strXML1 .="<colorRange><color minValue='0' maxValue='15'  code='8BBA00' label='Good'/><color minValue='16' maxValue='44' code='F6BD0F' label='Moderate'/><color code='FF654F'minValue='45' maxValue='100'  label='BAD'/></colorRange>";
    $strXML1 .="<pointers><pointer value='92' /></pointers>";
	$strXML1 .='</chart>';
		
		$data['strXML']=$strXML;
		$data['strXML1']=$strXML1;
		$data['title'] = "Order Report";
		$data['content_view'] = "facility/order_report";
		$data['banner_text'] = "Orders Report";
		$data['link'] = "order_management";
		$data['quick_link'] = "stock_level";
		$this -> load -> view("template", $data);
	}
	
	//generate order report
	public function generate_order_report(){
		$data_type=$_POST['type_of_data'];
		$duration=$_POST['duration'];
		$year=$_POST['year_from'];
		$report_type=$_POST['type_of_report'];
		$title='test';
		$report_name="Order Report For".$year;
		$facility_code=$this -> session -> userdata('news');
		$from_ordertbl=Ordertbl::get_facilitiy_orders($facility_code);
		$facility_name=Facilities::get_facility_name($facility_code);
		
/**************************************set the style for the table****************************************/

$html_data='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#D8D8D8;}</style>';

		//create the report based on the request of the user 
/**********bug detected mpdf cannot print a report that has nesteded loops the solution is to create the html body before creating the mpdf object****/
		$html_data1 ='';// order analysis
		$html_data2=''; // raw order details
		
		foreach($from_ordertbl as $infor_array){
			//setting up the variables
		$total_item_received=0;
		$total_item_ordered=0;
		$date=$infor_array->orderDate;
		$draw=$infor_array->drawing_rights;
		$total=$infor_array->orderTotal;
		$bal=number_format($draw-$total, 2, '.', ',');
		
/*****************************setting up the report*******************************************/

$html_data1 .='<table class="data-table"><thead>
<tr><td colspan="16"><p style="font-weight: bold;">Facility Order No: '.$infor_array->id.' | KEMSA Order No: '.$infor_array->kemsaOrderid.' | Order Date:'.$date.' | Order Total: '.number_format($total, 2, '.', ',').' | Drawing rights: '.number_format($draw, 2, '.', ',').' | 
Balance(Drawing rights - Order Total):'.$bal.' </p></span></td></tr>
<tr> <th><strong>KEMSA Code</strong></th><th><strong>Description</strong></th><th><strong>Quantity Ordered</strong></th><th><strong>Unit Cost</strong></th><th class="col5" ><strong><b>Total Cost</b></strong></th>
<th><strong>Quantity Ordered</strong></th><th><strong>Quantity Received</strong></th><th class="col5" ><strong><b>Fill rate</b></strong></th>
<th><strong><b>Opening Balance</b></strong></th>
<th><strong><b>Total Receipts</b></strong></th>
<th><strong><b>Total Issues</b></strong></th>
<th><strong><b>ADJ</b></strong></th>
<th><strong><b>Losses</b></strong></th>
<th><strong><b>Closing Stock</b></strong></th>
<th><strong><b>Days Out Of stock</b></strong></th>
<th><strong><b>Comment</b></strong></th>
</tr> </thead><tbody>';

/***********************************************************************************************/
$html_data2 .='<table class="data-table"><thead>
<tr><td colspan="16"><p style="font-weight: bold;">Facility Order No: '.$infor_array->id.' | KEMSA Order No: '.$infor_array->kemsaOrderid.' | Order Date:'.$date.' | Order Total: '.number_format($total, 2, '.', ',').' | Drawing rights: '.number_format($draw, 2, '.', ',').' | 
Balance(Drawing rights - Order Total):'.$bal.' </p></span></td></tr>
<tr> <th><b>KEMSA Code</b></th>
						<th><b>Description</b></th>
						<th><b>Order Unit Size</b></th>
						<th><b>Order Unit Cost</b></th>
						<th ><b>Opening Balance</b></th>
						<th ><b>Total Receipts</b></th>
					    <th><b>Total issues</b></th>
					    <th><b>Adjustments</b></th>
					    <th><b>Losses</b></th>
					    <th><b>Closing Stock</b></th>
					    <th><b>No days out of stock</b></th>
					    <th><b>Order Quantity</b></th>
					    <th><b>Order cost(Ksh)</b></th>	
					   <th><b>Comment(if any)</b></th>	
</tr> </thead><tbody>';

/*****************************creating the rows **************************************/
		  
		  foreach($infor_array->Ord as $Ord_array){
		  	//setting the variables
		  	$o_q=$Ord_array->quantityOrdered; $total_item_ordered=$total_item_ordered+$o_q;
		  	$o_p=$Ord_array->price;
		  	$o_t=number_format($o_p*$o_q, 2, '.', ',');
			$o_qr=$Ord_array->quantityRecieved; $total_item_received=$total_item_received+$o_qr;
			$fill=($o_qr/$o_q)*100;
			
/*******************************begin adding data to the report*****************************************/
		   $html_data1 .='<tr><td>'.$Ord_array->kemsa_code.'</td>';
		   $html_data2 .='<tr><td>'.$Ord_array->kemsa_code.'</td>';
	foreach($Ord_array->Code as $d){
		 $name=$d->Drug_Name; $html_data1 .='<td>'.$name.'</td>'; 
		/*********************************************************************************************/ 
		 $html_data2 .='<td>'.$name.'</td><td>'.$d->Unit_Size.'</td><td>'.$o_p.'</td>';
}
			 $html_data1 .='<td>'.$o_q.'</td>
							<td>'.$o_p.'</td>
							<td class="col5">'.$o_t.'</td>
							<td>'.$o_q.'</td>
							<td>'.$o_qr.'</td>
							<td class="col5">'.$fill.'%'.'</td>
							<td>'.$Ord_array->o_balance.'</td>
							<td >'.$Ord_array->t_receipts.'</td>
							<td >'.$Ord_array->t_issues.'</td>
							<td >'.$Ord_array->adjust.'</td>
							<td >'.$Ord_array->losses.'</td>
							<td >'.$Ord_array->c_stock.'</td>
							<td >'.$Ord_array->days.'</td>
							<td >'.$Ord_array->comment.'</td>
							</tr>';
	/****************************************************************************************************************/						
							$html_data2 .='<td>'.$Ord_array->o_balance.'</td>
							<td>'.$Ord_array->t_receipts.'</td>
							<td >'.$Ord_array->t_issues.'</td>
							<td>'.$Ord_array->adjust.'</td>
							<td>'.$Ord_array->losses.'</td>
							<td >'.$Ord_array->c_stock.'</td>
							<td>'.$Ord_array->days.'</td>
							<td >'.$o_q.'</td>
							<td class="col5">'.$o_t.'</td>
							<td >'.$Ord_array->comment.'</td>
							</tr>';
		  }
   if($total_item_ordered==0){$total_item_ordered=1;}
		    $order_fill_rate=($total_item_received/$total_item_ordered)*100;
		  
		  //close the table
		  $html_data1 .='<tr><td colspan="16"> <b>Total Items Received: '.$total_item_received.' | Total Items Ordered : '.$total_item_ordered.'|    Order Fill Rate(Total items received/Total Items Ordered)*100 :'.$order_fill_rate.' %</td></tr></tbody></table></b><hr /></br></br>';
		  $html_data2 .='</tbody></table></b><hr /></br></br>';	
		}

		if($data_type=='Order Analysis'){
			$html_data .= $html_data1;
		}
		
         else if($data_type=='Raw Order Data'){
	    $html_data .= $html_data2;
         }
		
    /**************************finally generate the report***********************/

		$this->generate_pdf($report_name,$title,$html_data,$report_type);
		
	}
	//generate pdf
	public function generate_pdf($r_name,$title,$data,$display_type){
		
		$facility_code=$this -> session -> userdata('news');
		$facility_name_array=Facilities::get_facility_name($facility_code)->toArray();
		$facility_name=$facility_name_array['facility_name'];
		
		if ($display_type == "Download PDF") {
			
			/********************************************setting the report title*********************/
			
		$html_title="<div ALIGN=CENTER><img src='".base_url()."Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-size: 14px;display: block;font-weight: bold;'>$title</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
       Ministry of Public Health and Sanitation/Ministry of Medical Services</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div><hr /> 
        <span><p style='font-weight: bold;'>MFL CODE: ".$facility_code."</p><p style='font-weight: bold;'> FACILITY NAME: ".$facility_name."</p>
          ";
		
		/**********************************initializing the report **********************/
            $this->load->library('mpdf');
            $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
            $this->mpdf->SetTitle($title);
            $this->mpdf->WriteHTML($html_title);
            $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML('<br/>');
            $this->mpdf->WriteHTML($data);
			$report_name = $r_name.".pdf";
            $this->mpdf->Output($report_name,'D');
            
        } 
        else if ($display_type == "View Report") {
        	
        $html_title= '<link href="'.base_url().'CSS/style.css" type="text/css" rel="stylesheet"/> 
		<div class="logo"><a class="logo" ></a> </div>
		 <div id="system_title">
		<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Public Health and Sanitation/Ministry of Medical Services</span>
		<span style="display: block; font-size: 12px;">Health Commodities Management Platform</span>
		</div>
		</div>
		<span style="display: block; font-size: 12px;">Health Commodities Management Platform</span><span style="text-align:center;" ><hr /> 
        <span><p style="font-weight: bold;">MFL CODE: '.$facility_code.'</p><p style="font-weight: bold;"> FACILITY NAME: '.$facility_name.'</p>';
		
            echo $html_title.$data;
        }
		
	}
/***************************MOH DASHBORD ************************/
function moh_consumption_report(){
		if ($this->input->post('id')) {
			$data['name']=$this->input->post('ajax');
			$year=date("Y");
			$drug_id=$this->input->post('id');
			$data['detail']= Facility_Issues::get_consumption_per_drug($drug_id,$year);
			$district=$this -> session -> userdata('district1');
			$data['facilities']=Facilities::getFacilities($district);
			
     $this -> load -> view("moh/ajax_reports/test",$data);   }
		
}
function moh_category_consumption_report(){
	  
		if ($this->input->post('id')) {
			$data['name']=$this->input->post('ajax');
     $this -> load -> view("moh/ajax_reports/consumption_category",$data);   }
		
}
public function generate_costofexpiries_chart(){
		 $commodity_array=Facility_Stock::get_district_cost_of_exipries(1);	
		 $detail=$commodity_array;
		
	    $strXML = "<chart
	    lineColor='FF5904' lineAlpha='85' showValues='1' rotateValues='1' valuePosition='auto'
	     palette='1' caption='Monthly Cost of Expired Commodities' subcaption='For the year 2013' xAxisName='Months' yAxisName='Cost of Commodities (KES)' yAxisMinValue='15000' showValues='0'  useRoundEdges='1' alternateHGridAlpha='20' divLineAlpha='50' canvasBorderColor='666666' canvasBorderAlpha='40' baseFontColor='666666' lineColor='AFD8F8' chartRightMargin = '60' showBorder='0' bgColor='FFFFFF'>";

	    for($i=0;$i<12;$i++){

switch ($i){
	case 0:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			$strXML .="<set label='Jan' value='$val' />";
			
		}	else{
			$val=0;
			$strXML .="<set label='Jan' value='$val' />";
		}
		
		break;
		case 1:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}
		$strXML .="<set label='Feb' value='$val' />";
		break;
		case 2:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Mar' value='$val' />";
		break;
		case 3:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML .="<set label='Apr' value='$val' />";
		break;
		case 4:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='May' value='$val' />";
		break;
		case 5:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Jun' value='$val' />";
		break;
		case 6:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Jul' value='$val' />";
		break;
		case 7:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Aug' value='$val' />";
		break;
		case 8:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Sep' value='$val' />";
		break;
		case 9:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Oct' value='$val' />";
		break;
		case 10:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Nov' value='$val' />";	
		break;
		case 11:
		if(isset($detail[$i]['total'])){
			$val=$detail[$i]['total'];
			
		}	else{
			$val=0;
		}	
		$strXML.="<set label='Dec' value='$val' />";
		break;
											
		
}
}
	    


$strXML .= "<styles>
<definition>
<style name='Anim1' type='animation' param='_xscale' start='0' duration='1'/>
<style name='Anim2' type='animation' param='_alpha' start='0' duration='0.6'/>
<style name='DataShadow' type='Shadow' alpha='40'/>
</definition>
<application>
<apply toObject='DIVLINES' styles='Anim1'/>
<apply toObject='HGRID' styles='Anim2'/>
<apply toObject='DATALABELS' styles='Anim2'/>
</application>
</styles>
</chart>";
	echo $strXML;
	
}

public function generate_costofordered_chart(){
$strXML = "<chart palette='1' lineColor='FF5904' lineAlpha='85' showValues='1' rotateValues='1' valuePosition='auto' caption='Cost Implication of Orders' subcaption='For the year 2012 to 2013' xAxisName='Months' yAxisName='Cost of Orders (KES)' yAxisMinValue='15000' showValues='0' useRoundEdges='1' alternateHGridAlpha='20' divLineAlpha='50' canvasBorderColor='666666' canvasBorderAlpha='40' baseFontColor='666666' lineColor='AFD8F8' chartRightMargin = '60' showBorder='0' bgColor='FFFFFF'>
<set label='Oct-Dec (2012)' value='18000'/>
<set label='Jan-Mar (2013)' value='16000'/>
<set label='Apr-Jun (2013)' value='21800'/>
<set label='Jul-Sep (2013)' value='19800'/>
<styles>
<definition>
<style name='Anim1' type='animation' param='_xscale' start='0' duration='1'/>
<style name='Anim2' type='animation' param='_alpha' start='0' duration='0.6'/>
<style name='DataShadow' type='Shadow' alpha='40'/>
</definition>
<application>
<apply toObject='DIVLINES' styles='Anim1'/>
<apply toObject='HGRID' styles='Anim2'/>
<apply toObject='DATALABELS' styles='Anim2'/>
</application>
</styles>
</chart>";
echo $strXML;
	
}

public function generate_leadtime_chart(){
	
	include_once("Scripts/FusionCharts/Code/PHP/Includes/FusionCharts.php");
	$currentDistrict = $this->session->userdata('district1');
	$facilityDetails = Facilities::getFacilities($currentDistrict);
  
  	$query = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT facilities.facility_code, facilities.facility_name FROM  facilities WHERE facilities.district = '$currentDistrict' ORDER BY facility_name ASC");
	$number = count($query);
	
	$strXMLlead_time ="<chart palette='1'  caption='Average Lead Time per Facility' shownames='1' showvalues='0'  xAxisName='Name of Commodity' yAxisName='Time in Days' numberSuffix=' Days' showSum='1' decimals='0' useRoundEdges='1' legendBorderAlpha='0'  showBorder='0' bgColor='FFFFFF'>
<categories>";
for ($counterforthis = 0; $counterforthis < $number; $counterforthis++) { 
         $strXMLlead_time .="<category label='".preg_replace("/[^A-Za-z0-9 ]/", "", $query[$counterforthis]['facility_name'])."' />";
      }
    
$strXMLlead_time .="</categories><dataset seriesName='Days Pending Approval' color='AFD8F8' showValues='0'>";
$theBarPlotter = "10";
for ($counterforthisother = 0; $counterforthisother < $number; $counterforthisother++) { 
         $strXMLlead_time .= "<set value='".$theBarPlotter."'  />";

          }

$strXMLlead_time .="</dataset><dataset seriesName='Days Pending Delivery' color='F6BD0F' showValues='0'>";
for ($counterforthisother1 = 0; $counterforthisother1 < $number; $counterforthisother1++) { 
         $strXMLlead_time .= "<set value='".$theBarPlotter."'  />";
          }
          $strXMLlead_time.="</dataset><dataset seriesName='Days Pending Dispatch' color='8BBA00' showValues='0'>";
          for ($counterforthisother2 = 0; $counterforthisother2 < $number; $counterforthisother2++) { 
         $strXMLlead_time .= "<set value='".$theBarPlotter."'  />";
          }
          $strXMLlead_time.="</dataset></chart>";
$data['strXML_leadtime'] = $strXMLlead_time;
echo $strXMLlead_time;
}


//view affected is district dash
public function get_stock_status($option=NULL,$facility_code=NULL){
	$chart =NULL;
	$title=NULL;
	$district=$this -> session -> userdata('district');
	$district_name=districts::get_district_name($district);
	if($option==NULL){
		
		
	    $title="".$district_name["district"]." District";
        $commodity_array=facility_stock::get_district_stock_level($district);
		
	}
	elseif($option=="ajax-request_facility") {
		$district_name=facilities::get_facility_name_($facility_code);
	    $title=$district_name["facility_name"];
        $commodity_array=facility_stock::get_facility_stock_level($facility_code);
		
	}
	elseif($option=="ajax-request_drug") {
		 $title="".$district_name["district"]." District";
        $commodity_array=facility_stock::get_district_drug_stock_level($district,$facility_code);
		
	}




$chart .="<chart palette='2' bgColor='FFFFFF' showBorder='0' caption='Commodity Stock Level :$title' shownames='1' showvalues='1'   showSum='1' decimals='0' useRoundEdges='1'>";
foreach($commodity_array as $commodity_detail){
$chart .="<set label='".preg_replace("/[^A-Za-z0-9 ]/", "", $commodity_detail['drug_name'])."' value='$commodity_detail[total]' />";
}
$chart .="<styles>
      <definition>
            <style name='myToolTipFont' type='font' font='Arial' size='18' color='FF5904'/>
      </definition>
      <application>
            <apply toObject='ToolTip' styles='myToolTipFont' />
      </application>
  </styles>";

$chart .="</chart>";
echo $chart;
}
//////
public function get_stock_status_ajax($option=NULL,$facility_code=NULL){
	$district=$this -> session -> userdata('district1');
	$data['facilities']=Facilities::getFacilities($district);
	$data['option']=$option;
	$data['facility_code']=$facility_code;
	$this->load->view("district/ajax_view/stock_status_v",$data);
}
	
public function consumption_trends(){	
				
$chart="<chart bgColor='FFFFFF' showBorder='0' caption=' Trends'lineThickness='1' xAxisName='Months Quarterly' yAxisName='Quantity Consumed' showValues='0' formatNumberScale='0' anchorRadius='2'   divLineAlpha='10' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridAlpha='5' alternateHGridColor='CC3300' shadowAlpha='40' labelStep='2' numvdivlines='5' chartRightMargin='35' bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10'>
<categories >
<category label='Oct-Dec' />
<category label='Jan-March' />
<category label='April-June' />
<category label='July-Sept' />

</categories>
<dataset seriesName='' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'>
	<set value='1327' />
	<set value='1826' />
	<set value='1699' />
	<set value='1511' />
<set value='1511' />
	</dataset>

	<styles>                
		<definition>
                         
			<style name='CaptionFont' type='font' size='12'/>
		</definition>
		<application>
			<apply toObject='CAPTION' styles='CaptionFont' />
			<apply toObject='SUBCAPTION' styles='CaptionFont' />
		</application>
	</styles>

</chart>";		
		echo $chart;
}
public function get_consumption_trends_ajax(){
	$district=$this -> session -> userdata('district1');
	$data['facilities']=Facilities::getFacilities($district);
	$this->load->view("district/ajax_view/consumption_trends_v", $data);
}

public function get_costofexpiries_chart_ajax(){
	$district=$this -> session -> userdata('district1');
	$data['facilities']=Facilities::getFacilities($district);
	$this->load->view("district/ajax_view/costofexpiries_v",$data);
}
public function get_costoforders_chart_ajax(){
	$district=$this -> session -> userdata('district1');
	$data['facilities']=Facilities::getFacilities($district);
	$this->load->view("district/ajax_view/costoforders_v",$data);
}
public function get_leadtime_chart_ajax(){
	$district=$this -> session -> userdata('district1');
	$data['facilities']=Facilities::getFacilities($district);
	$this -> load -> view("district/ajax_view/leadtime_v",$data);
	$data['drugs'] = Drug::getAll();
	}
// the facility settings user settings	
public function facility_settings(){
	    $data['title'] = "Facility Settings";
		$data['content_view'] = "facility/facility_settings_v";
		$data['banner_text'] = "Facility Settings";
		$data['link'] = "reports_management";
		$this -> load -> view("template", $data);
}	

	public function get_district_facility_stock_($graph_type,$facility_code){
		
		switch ($graph_type) {
			case 'bar2d_facility':
				 $this->get_stock_status_ajax($option="ajax-request_facility",$facility_code);
			break;
			case 'bar2d_drug':
				 $this->get_stock_status_ajax($option="ajax-request_drug",$facility_code);
			break;
			
			default:
				
				break;
		}
	}
	
	public function get_county_facility_mapping(){
		
		$data['title'] = "Facility Mapping";
		$data['banner_text'] = "Facility Mapping";
		$data['content_view'] = "county/facility_mapping_v";	
		$owner_array=array("GOK","CBO","FBO","NGO","Private","Other");
		$counties=districts::getDistrict(1);
		$table_body='';
		
		foreach($counties as $county_detail){
			$id=$county_detail->id;
			$table_body .="<tr><td><a class='ajax_call_1' id='county_facility' name='get_rtk_county_detail/$id' href='#'> $county_detail->district</a></td>";
			
			$county_detail=facilities::get_total_facilities_in_district($id);
			
			$table_body .="<td>".$county_detail[0]['total_facilities']."</td>";
			foreach($owner_array as $key => $value){
				
				$owner_count=facilities::get_total_facilities_district_ownership($id, $value);
				
				
				$table_body .="<td>".$owner_count[0]['ownership_count']."</td>";
			}
			$table_body .="</tr>";
			
		}

		$data['table_body']=$table_body;
	  
	  $this -> load -> view("template",$data);
	}
	
	/////////county
	public function county_orders(){
		$data['title'] = "County Orders";
		$data['content_view'] = "county/county_orders";
		$data['banner_text'] = "County Orders";
		$data['link'] = "reports_management";
		$counties=districts::getDistrict(1);
		$table_body='';
		
		foreach($counties as $county_detail){
			$id=$county_detail->id;
			$table_body .="<tr><td><a class='ajax_call_1' id='county_facility' name='get_rtk_county_detail/$id' href='#'> $county_detail->district</a></td>";
			
			$county_detail=facilities:: get_no_of_facilities($id);
			$test=$county_detail[0]['total_facilities'];
			$link="<a href=".site_url('report_management/county_view_orders/'.$id)." class='link'>View</a>";
			$table_body .="<td>$test</td>
			<td>$test</td>
			<td>$test</td>
			<td>$test</td>
			<td>$test</td>
			<td>$link</td></tr>";
			
			
		}

		$data['table_body']=$table_body;
	  
	  $this -> load -> view("template",$data);
	}

public function county_view_orders($id){
		$data['title'] = "County Orders";
		$data['content_view'] = "county/county_orders_v";
		$data['banner_text'] = "District Orders";
		$id=$this -> session -> userdata('district');
		$data['order_list']=Ordertbl::get_county_view_orders($id);
		$this -> load -> view("template", $data);
		
	}




//county charts  1
public function expired_commodities_chart(){
$strXML ="<chart caption='Expired Commodities'yAxisName='No. of batch units' xAxisName='Commodities' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>
        <set label='Dagoretti' value='23'/> 
        <set label='Embakasi' value='12'/> 
        <set label='Kamukunji' value='17'/> 
        <set label='Kasarani' value='14' /> 
        <set label='Langata' value='12' />
        <set label='Makadara' value='12'/> 
        <set label='Njiru' value='17'/> 
        <set label='Starehe' value='14' /> 
        <set label='Westlands' value='12' />
</chart>";
echo $strXML;
}

//county charts  2
public function cost_of_expired_commodities_chart(){
$strXML ="<chart canvasPadding='10' caption='Cost of Expired Commodities' xAxisName='Month' yAxisName='ksh' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>
<set label='Jan' value='17400' />
<set label='Feb' value='19800' />
<set label='Mar' value='21800' />
<set label='Apr' value='23800' />
<set label='May' value='29600' />
<set label='Jun' value='27600' />
<set label='Jul' value='31800' />
<set label='Aug' value='39700' />
<set label='Sep' value='37800' />
<set label='Oct' value='21900' />
<set label='Nov' value='32900' />
<set label='Dec' value='39800' />
</chart>";
echo $strXML;
}

//county charts  3
public function stock_status_chart(){
$strXML ="<chart caption='Stock Status'yAxisName='No. of batch units' xAxisName='Commodities' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>
        <set label='Dagoretti' value='23'/> 
        <set label='Embakasi' value='12'/> 
        <set label='Kamukunji' value='17'/> 
        <set label='Kasarani' value='14' /> 
        <set label='Langata' value='12' />
        <set label='Makadara' value='12'/> 
        <set label='Njiru' value='17'/> 
        <set label='Starehe' value='14' /> 
        <set label='Westlands' value='12' />
</chart>";
echo $strXML;
}
//county charts  4
public function orders_chart(){
$strXML ="<chart canvasPadding='10' caption='Orders in the county' xAxisName='Month' yAxisName='No of Orders' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>
<set label='Jan' value='17400' />
<set label='Feb' value='19800' />
<set label='Mar' value='21800' />
<set label='Apr' value='23800' />
<set label='May' value='29600' />
<set label='Jun' value='27600' />
<set label='Jul' value='31800' />
<set label='Aug' value='39700' />
<set label='Sep' value='37800' />
<set label='Oct' value='21900' />
<set label='Nov' value='32900' />
<set label='Dec' value='39800' />
</chart>";
echo $strXML;
}
//county charts  5
public function cost_of_ordered_commodities_chart(){
$strXML ="<chart canvasPadding='10' caption='cost of ordered commodities' xAxisName='Month' yAxisName='Ksh' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>
<set label='Jan' value='17400' />
<set label='Feb' value='19800' />
<set label='Mar' value='21800' />
<set label='Apr' value='23800' />
<set label='May' value='29600' />
<set label='Jun' value='27600' />
<set label='Jul' value='31800' />
<set label='Aug' value='39700' />
<set label='Sep' value='37800' />
<set label='Oct' value='21900' />
<set label='Nov' value='32900' />
<set label='Dec' value='39800' />
</chart>";
echo $strXML;
}
//county charts  6
public function cummulative_fill_rate_chart(){
	$strXML ="<chart bgAlpha='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='100' numberSuffix='%25' showBorder='0' basefontColor='#000000' chartTopMargin='25' chartBottomMargin='25' chartLeftMargin='25' chartRightMargin='25' toolTipBgColor='80A905' gaugeFillMix='{dark-10},FFFFFF,{dark-10}' gaugeFillRatio='3'>
<colorRange>
<color minValue='0' maxValue='45' code='FF654F'/>
<color minValue='45' maxValue='80' code='F6BD0F'/>
<color minValue='80' maxValue='100' code='8BBA00'/>
</colorRange>
<dials>
<dial value='92' rearExtension='10'/>
</dials>
<trendpoints>
<point value='50' displayValue='Cummulative Fill Rate' fontcolor='FF4400' useMarker='1' dashed='1' dashLen='2' dashGap='2' valueInside='1'/>
</trendpoints>
<!-- Rectangles behind the gauge  -->
<annotations>
<annotationGroup id='Grp1' showBelow='1'>
<annotation/>
</annotationGroup>
</annotations>
<styles>
<definition>
<style name='RectShadow' type='shadow' strength='3'/>
</definition>
<application>
<apply toObject='Grp1' styles='RectShadow'/>
</application>
</styles>
</chart>";

echo $strXML;
}
//county charts  7
public function district_drawing_rights_chart(){
$strXML ="<chart palette='3' caption='Districts Drawing Rights'  numberprefix='$' xaxisName='Districts'yaxisName='Amount' useRoundEdges='1' showValues='0' legendBorderAlpha='0'>  

<categories showValues='1'>
      <category label='Dagoretti' />
      <category label='Embakasi' />
      <category label='Kamukunji' />
      <category label='Kasarani' />
      <category label='Langata' />
      <category label='Makadara' />
      <category label='Njiru' />
      <category label='Starehe' />
      <category label='Westlands' />
           
</categories>

<dataset>
      <set value='570' />
      <set value='589' />
      <set value='611' />
      <set value='635' />
      <set value='570' />
      <set value='589' />
      <set value='611' />
      <set value='635' />
      <set value='656' />
         
</dataset>
</chart>";
echo $strXML;
}

//county charts  8
public function orders_placed_chart(){
$strXML ="<chart caption=' Orders Placed By Districts' formatNumberScale='0' color='FF4400'>
<set label='Dagoretti' value='51852' />
<set label='Embakasi' value='88168' />
<set label='Kamukunji' value='73897' />
<set label='Kasarani' value='93933' />
<set label='Langata' value='19289' />
<set label='Makadara' value='79623' />
<set label='Njiru' value='48262' />
<set label='Starehe' value='29162' />
<set label='Westlands' value='96878' />
</chart>";
echo $strXML;
}


//county charts  9
public function lead_time_chart(){
	$title='Lead Time';
$str_xml_body="<value>1</value>";

$strXML = "<Chart bgColor='FFFFFF' bgAlpha='0' numberSuffix='%' caption='$title' showBorder='0' upperLimit='100' lowerLimit='0' gaugeRoundRadius='5' chartBottomMargin='5' ticksBelowGauge='0' 
showGaugeLabels='0' valueAbovePointer='0' pointerOnTop='1' pointerRadius='5'>
    <colorRange> 
       
        <color minValue='0' maxValue='33' name='Orders Placed' code='FF0000' />
        
        <color minValue='34' maxValue='67' name='Orders Approved' code='FFFF00' /> 
         <color minValue='68' maxValue='100' name='Orders Delivered' code='00FF00' />
    </colorRange>";   
$strXML .="$str_xml_body
<styles>
        <definition>
            <style name='ValueFont' type='Font' bgColor='333333' size='10' color='FFFFFF'/>
        </definition>
        <application>
            <apply toObject='VALUE' styles='valueFont'/>
        </application>	
    </styles>
</Chart>";

echo $strXML;
}
////////////////////////////////////////////////////////////////////////////////////////////
	
	
	

}

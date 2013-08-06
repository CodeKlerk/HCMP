<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class cd4_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		
	}

	public function index() {

//		$this->get_kenyan_county_map();
		$data['content_view']="cd4/dashboard";
		$data['title']= "CD4 Home";
		$data['banner_text']="b";
		$this->load->view('template',$data);
	}
	public function get_cd4_allocation_kenyan_map(){

	$this->load->view("allocation_committee/ajax_view/cd4_allocation_county_map");
}
	// currently using county details from RTK/HCMP will load from cd4_  as next step
	public function map_chart(){
	$map="";
	$map .="<map showBevel='0' caption='CD4 county allocation: Click to view facilities in county' showMarkerLabels='1' fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >";
	$map .="<data>";
	$colors=array("FFFFCC"=>"1","E2E2C7"=>"2","FFCCFF"=>"3","F7F7F7"=>"5","FFCC99"=>"6","B3D7FF"=>"7","CBCB96"=>"8","FFCCCC"=>"9");
	
	$counties=Counties::get_county_map_data();
   	foreach( $counties as $county_detail){
   	$countyid=$county_detail->id;
	$county_map_id=$county_detail->kenya_map_id;
   	$countyname=trim($county_detail->county);
   	
	$county_detail=hcmp_stock_status::get_county_reporting_rate ($countyid);
	$total_facilities=$county_detail[0]['total_facilities'];
	$reporting_facilities=$county_detail[0]['reported'];
	$reporting_rate=round((($reporting_facilities/$total_facilities)*100),1);
 	$map .="<entity  link='".base_url()."cd4_management/county_allocation_details/$county_map_id' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."'  toolText='County :$countyname&lt;BR&gt; Total Facilities :".$total_facilities."&lt;BR&gt; Facilities Reporting  :".$reporting_facilities."&lt;BR&gt; Facility Reporting Rate :".$reporting_rate." %'/>";
   		}

	$map .="</data>
		<styles>
		<definition>
   		<style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   		<style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   		<style name='myShadow' type='Shadow' distance='1'/>
		</definition>
		<application>
		<apply toObject='MARKERS' styles='myShadow' /> 
		<apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
		<apply toObject='TOOLTIP' styles='TTipFont' />
		</application>
		</styles>
		</map>";

		echo $map;
	}



	public function get_kenyan_county_map(){
	$data['content_view']="cd4/ajax_view/kenyan_county_v";
	$data['title'] = "CD4";
	$data['banner_text'] = "CD4";
	$this -> load -> view("template",$data);	
		
		
		
	}
	
	public function kenya_county_map(){
		$map ="";
		
		$map .="<map showBevel='0' showMarkerLabels='1' fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >";
		$map .="<data>";
		$colors=array("FFFFCC"=>"1","E2E2C7"=>"2","FFCCFF"=>"3","F7F7F7"=>"5","FFCC99"=>"6","B3D7FF"=>"7","CBCB96"=>"8","FFCCCC"=>"9");

	    $counties=Counties::get_county_map_data();
   		   foreach( $counties as $county_detail){
   		$countyid=$county_detail->id;
	  	$county_map_id=$county_detail->kenya_map_id;
   	    $countyname=trim($county_detail->county);
   	
	   	$county_detail=hcmp_stock_status::get_county_reporting_rate ($countyid);
	   	$total_facilities=$county_detail[0]['total_facilities'];
	   	$reporting_facilities=$county_detail[0]['reported'];
	   	$reporting_rate=round((($reporting_facilities/$total_facilities)*100),1);
 		$map .="<entity  link='cd4_management/county_detail_zoom/$countyid' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."'  toolText='County :$countyname&lt;BR&gt; Total Facilities :".$total_facilities."&lt;BR&gt; Facilities Reporting  :".$reporting_facilities."&lt;BR&gt; Facility Reporting Rate :".$reporting_rate." %'/>";
   		}
		$map .="</data>
		<styles>
		<definition>
   		<style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   		<style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   		<style name='myShadow' type='Shadow' distance='1'/>
		</definition>
		<application>
		<apply toObject='MARKERS' styles='myShadow' /> 
		<apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
		<apply toObject='TOOLTIP' styles='TTipFont' />
		</application>
		</styles>
		</map>";

		echo $map;
		
		
	}
	public function kenyan_map($data, $title=NULL){
	    $map ="";
		$map .="<map showBevel='0' showMarkerLabels='1' caption='$title'  fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >";
		
			$map .="<data>";
			$map .=$data;
			$map .="</data>
		<styles> 
  <definition>
   <style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   <style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   <style name='myShadow' type='Shadow' distance='1'/>
  </definition>
  <application>
   <apply toObject='MARKERS' styles='myShadow' /> 
   <apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
   <apply toObject='TOOLTIP' styles='TTipFont' />
  </application>
 </styles>
</map>";
			
	return $map;
	
}

	public function cd4_allocation_kenyan_map(){
$colors=array("FFFFCC"=>"1","E2E2C7"=>"2","FFCCFF"=>"3","F7F7F7"=>"5","FFCC99"=>"6","B3D7FF"=>"7","CBCB96"=>"8","FFCCCC"=>"9");

  
   $map ="";
   
 $counties=Counties::get_county_map_data();
	$table_data="";
	$allocation_rate=0;
	$total_facilities_in_county=1;
	$total_facilities_allocated_in_county=1;
   foreach( $counties as $county_detail){
   	
   	   $countyid=$county_detail->id;
	   $county_map_id=$county_detail->kenya_map_id;
   	   $countyname=trim($county_detail->county);
   	
	   $county_detail=rtk_stock_status::get_allocation_rate_county($countyid);
	   $total_facilities_in_county=$county_detail['total_facilities_in_county'];
	   $total_facilities_allocated_in_county=$county_detail['total_facilities_allocated_in_county'];

	  @$allocation_rate=round((($total_facilities_allocated_in_county/$total_facilities_in_county)*100),1);
     $map .="<entity  link='".base_url()."cd4_management/allocation_county_detail_zoom/$countyid' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."' toolText='County :$countyname&lt;BR&gt; Total Facilities Reporting:".$total_facilities_in_county."&lt;BR&gt; Facilities Allocated  :".$total_facilities_allocated_in_county."&lt;BR&gt; Facility Allocation Rate :".$allocation_rate." %'/>";

   		}
 echo  $this->kenyan_map($map,"CD4 County allocation: Click to view facilities in county");
	
	
}

public function county_allocation_details($county_id){


	$data['content_view']='cd4/ajax_view/county_allocation_v';
	


	
$htm='';


	$facilities =$this->db->query('SELECT DISTINCT AutoID,fname,MFLCode,countyname
			FROM cd4_facility, cd4_facilityequipments, cd4_districts
			WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
			AND cd4_facility.district = cd4_districts.ID
			AND equipment  <=3
			AND county = "'.$county_id.'"');

			


		if ($facilities->num_rows() > 0){

			// checks whether any equipments 
//			$htm.='<table class=" "  style="position:fixed; width:300px">';
//			$htm.='<tr><thead><th>Facility</th><!--<th>Device</th>--><th></th></thead></tr>';
			$htm.='<ul class="facility-list">';
		foreach ($facilities->result_array() as $facilitiessarr) 
		{
			$countyname = $facilitiessarr['countyname'];



			$facility= $facilitiessarr['AutoID'];
			$facility_name = $facilitiessarr['fname'];
			$facility_mfl = $facilitiessarr['MFLCode'];
			$facilitiessarr['equipmentname'] ='';
//			echo $facility_name .' - '.$facility;
		

//			echo"<pre>";
// 			var_dump($facilitiessarr);
//			echo"</pre>";	
//	 		
		//	$htm.='<tr><!--Facility --><td>'.$facilitiessarr['fname'].'</td><!-- MFLCode '.$facilitiessarr['MFLCode'].' equipment <td>'.$facilitiessarr['equipmentname'].'</td>--><td><a href="#'.$facility.'" class="allocate" onClick="showpreview('.$facility.')" >Allocate</a></td></tr>';
			$htm .='<li><a href="#'.$facility.'" class="allocate" onClick="showpreview('.$facility.')" >'.$facilitiessarr['fname'].'</a></li>';

//			echo 'Facility '.$facilitiessarr['fname'].' MFLCode '.$facilitiessarr['MFLCode']
//			.' equipment '.$facilitiessarr['equipment']		;

	 

		}$htm.='</ul>';
		//$htm.='</table>';

		}
		$data['htm'] = $htm;
			$data['banner_text']='Allocate '.$countyname;
			$data['title']='CD4 Allocation '.$countyname;
			$data['countyname'] =$countyname;

	$this->load->view('template',$data);

		  
 

}

function facility_allocate($facility){
	$htm = '';

	$equipments  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagentcategory.equipmentType = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.ID = cd4_equipments.ID
AND facility= '.$facility.'');

			if ($equipments->num_rows()>0){

				$facility_details = $this->db->query('SELECT * 
								FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
								WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
								AND cd4_reagentcategory.equipmentType = cd4_equipments.ID
								AND cd4_reagents.categoryID = cd4_equipments.ID
								AND cd4_equipments.ID = cd4_equipments.ID
								AND facility ='.$facility.'
								LIMIT 0 , 1');
				foreach ($facility_details->result_array() as $facility_details_arr) {	 
					$facility_equipment =$facility_details_arr['equipmentname'];
					$facility_name  = $facility_details_arr['fname'];
					$facility_mfl  = $facility_details_arr['fname'];

			 $htm .= '<fieldset style="font-size: 14px;background: #FCF8F8;padding: 10px;">
			<span><b>DEVICE :</b>'.$facility_equipment.'</span><br>
			<span><b>FACILITY :</b> '.$facility_name.'</span><br>
			</fieldset>';

}
		$htm .=  "<table class='data-table' style='font-size: 0.9em;'>";
		$htm .=  "<thead>
		<!--<th>Equipment Name</th> -->
		<th ROWSPAN=2> Description(Unit)</th>
		<th COLSPAN=3>Quantity Received(3 months av)</th>
		<th COLSPAN=3>Quantity Received(3 months av)</th>
		<th ROWSPAN=2>End Balance(June)</th>
		<th ROWSPAN=2>Requested</th>
		<th ROWSPAN=2>Allocated</th>
		</tr>
		<tr>
		<th>May</th><th>June</th><th>July</th>
		<th>May</th><th>June</th><th>July</th>
		</tr></thead>
		";
				foreach ($equipments->result_array() as $equipmentsarr) {

				$reagentname = $equipmentsarr['reagentname'];
				$equipmentname = $equipmentsarr['equipmentname'];
				$unit = $equipmentsarr['unit'];

//				echo "<pre>";
 //				var_dump($equipmentsarr);

			 	$htm .= '<tr> <td>'.$reagentname.'<br />('.$unit.')</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>3</td><td>3</td><td><input type="text" value="0" /></td></tr>';

//				echo "</pre>";
			}
			$htm.="</table>";
			$htm.='<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';

			}
			else{ 
		echo '<fieldset style="
		    position: absolute;
		    margin-top: 112px;
		    font-size: 2em;
		    border: solid 1px #DDE2BB;
		    padding: 79px;
		    color: rgb(221, 154, 154);
		    background: snow;
		    /* margin-left: 80px; */
		"> <h1>No data has been submitted yet</h1></fieldset>';}
			echo $htm;
}
public function county_detail_zoom($county_id){

    $data['facility'] =Facilities::get_total_facilities_cd4_in_county($county_id);
	$data['table_body']="Hello World"; 
	$data['title'] = "County View";
	$data['banner_text'] = "County View";
	$data['content_view']="cd4/ajax_view/county_detail_zoom_v";
	$this -> load -> view("template",$data);
	 }

	

function national_yearly_reporting_chart(){
	 $caption='National Reporting Status';
	 $xAxisName='Month';
	 $yAxisName='Reagents';
	echo "<chart yAxisName='National Reporting Status' numberPrefix='' showValues='1'>	
	   <set label='Jan' value='40' />
	   <set label='Feb' value='90' />
	   <set label='Mar' value='70' />
	   <set label='Apr' value='50' />
	   <set label='May' value='80' />
	   <set label='Jun' value='50' />
	   <set label='Jul' value='60' />
	   <set label='Aug' value='60' />
	   <set label='Sep' value='60' />
	   <set label='Oct' value='40' />
	   <set label='Nov' value='50' />
	   <set label='Dec' value='30' />	
	   <trendLines>
	      <line startValue='700000' color='009933' displayvalue='Target' /> 
	   </trendLines>
	
	</chart>";
}

public function get_cd4_facility_detail($facility_code){
	$county_data=hcmp_stock_status::get_facility_reporting_details($facility_code);
	
	
	$table_body='';
	$fill_rate=0;
	
	if(count($county_data)>0){
		
	
	
	foreach($county_data as $county_detail){
		
			
		
	   $mos=$county_detail['moc'];
	   $unittests=$county_detail['unittests'];
	   $facility_name=$county_detail['facility_name'];
	   
 
	$table_body .="<tr>
	<td>$facility_code</td>
	<td>$facility_name</td>
	<td>$county_detail[test_name]</td>
	<td>$mos</td>
	<td>$unittests</td>
	<td>10</td>
	<td>10</td>
	<td>100 %</td>
	 </tr>";	

	}
	
	}
else{
	//do nothing 
}

$data['table_body']=$table_body;
$this -> load -> view("cd4/ajax_view/facility_zoom_v",$data);
	
	
	
	
}
 public function allocated(){
	//  $data['facility'] =Facilities::get_total_facilities_cd4_in_county($county_id);
	$data['table_body']="Hello World"; 
	$data['title'] = "County View";
	$data['banner_text'] = "County View";
	$data['content_view']="cd4/ajax_view/county_detail_zoom_v";
	$data['counties'] = array();
	$countiesid[] = array();
	$countiesnames[] = array();


		/* Manual Database Config for test putposes. 
		 * Monday presentation is required. no time to create models and integrate the two databases for new database
		 * API will come later
		*/
 
		$counties =$this->db->query('SELECT DISTINCT county, countyname
			FROM cd4_facility, cd4_facilityequipments, cd4_districts
			WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
			AND cd4_facility.district = cd4_districts.ID');

	
		foreach ($counties->result_array() as $countiesarr) {
			array_push($data['counties'], $countiesarr['countyname']);
		//echo $countiesarr['countyname'].' - '.$countiesarr['county'];		
		$county_id = $countiesarr['county'];

		// Query to get facilities details(county,district,name,owner)	
		$facility_e1  = $this->db->query('SELECT * FROM cd4_facility, cd4_facilityequipments, cd4_districts WHERE cd4_facility.AutoID = cd4_facilityequipments.facility AND cd4_facility.district = cd4_districts.ID AND equipment =1 AND county= '.$county_id.' ORDER BY  `cd4_facility`.`name` ASC ');
		foreach ($facility_e1->result_array() as $fe1) {
//			echo "<pre>";
// 			var_dump($fe1);
//			echo "</pre>";
			
			/*$reagents -> $this->db->query('SELECT * 
						FROM facilityequipments, equipments, reagents, equipmentcategories, reagentcategory
						WHERE facilityequipments.equipment = equipments.ID
						AND reagentcategory.equipmentType = equipments.ID
						AND reagents.categoryID = reagentcategory.equipmentType
						AND equipments.category = reagentcategory.equipmentType
						AND facility = '.$facility_id.'');
 */
	}
}
		 
//		$county_id = 1;
//		$res = $this->db->query('SELECT * FROM  `countys` WHERE `ID`='.$county_id.'');
/*		$all_counties = $this->db->query('SELECT * FROM  `cd4_countys` WHERE ID =3');

		foreach
		($all_counties->result_array()as $row){
			var_dump($row);
		$countyid = $row['ID']; // We have the ID of the county 
		echo $countyid;
		$districts_in_county = $this->db->query('SELECT * FROM cd4_districts WHERE `county` = '.$countyid.'');
	 

		foreach ($districts_in_county->result_array() as $districts_row) {
		$district_id =	$districts_row['ID'];
 		echo $district_id."<br />";
 
		$facilities_in_district= $this->db->query('SELECT * FROM `cd4_facility` WHERE `district` = '.$district_id.'');

		foreach ($facilities_in_district->result_array() as $facility_row) {
		$
		echo "<pre>";
		var_dump($facility_row);
		echo "</pre>";

		
		}
   	
	 }

	}
*/
$this->db->close();

$this -> load -> view("template",$data);
}

function loaddistricts($county){
	$districtsarr = array();
		$districts =$this->db->query('SELECT DISTINCT districtname, district
			FROM cd4_facility, cd4_facilityequipments, cd4_districts
			WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
			AND cd4_facility.district = cd4_districts.ID AND countyname = "'.$county.'"');

		if ($districts->num_rows() > 0){
		foreach ($districts->result_array() as $districtsarr) 
		{echo'<option value="'.$districtsarr['district'].'">'.$districtsarr['districtname'].'</option>';}
		} else{echo "<option>No data</option>";}

}
function loadfacilities($district){
	$facilityarr = array();
		$facility =$this->db->query('SELECT fname, facility
FROM cd4_facility, cd4_facilityequipments, cd4_districts
WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
AND cd4_facility.district = cd4_districts.ID
AND district ='.$district.'');

		if ($facility->num_rows() > 0){
		foreach ($facility->result_array() as $facilityarr) 
		{echo'<option value="'.$facilityarr['facility'].'">'.$facilityarr['fname'].'</option>';}
		} else{echo "<option>No data</option>";}
	}

	function loaddevices($facility){

	$facilityarr = array();
	$facility_dev1  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 1
AND facility = '.$facility.'');
	$facility_dev2  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 2
AND facility = '.$facility.'');
	$facility_dev3  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 3
AND facility = '.$facility.'');
	$facility_dev4  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 4
AND facility = '.$facility.'');

 
		if ($facility_dev1->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev1->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
//		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";

	}


		if ($facility_dev2->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev2->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
//		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";
	}


		if ($facility_dev3->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev3->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
//		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";
		}


		if ($facility_dev4->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev4->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";
		}

		 else{ 
		echo '<fieldset style="
		    position: absolute;
		    margin-top: 112px;
		    font-size: 2em;
		    border: solid 1px #DDE2BB;
		    padding: 79px;
		    color: rgb(221, 154, 154);
		    background: snow;
		    /* margin-left: 80px; */
		"> <h1>No data has been submitted yet</h1></fieldset>';;}
	 

	}




}
?>
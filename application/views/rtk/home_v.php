<?php
$month = $this->session->userdata('Month');
if ($month==''){
 $month = date('mY',time());
}

$year= substr($month, -4);
$month= substr_replace($month,"", -4);
//echo $year;
//echo $month;
//die();

$monthyear = $year . '-' . $month . '-1';
$englishdate = date('F, Y', strtotime($monthyear));
?>
<script type="text/javascript">
  function loadcountysummary(county){
//            $(".dash_main").load("<?php echo base_url(); ?>rtk_management/rtk_reporting_by_county/" + county);
            $("#county_summary").load("<?php echo base_url(); ?>rtk_management/summary_tab_display/" + county + "/<?php echo $year.'/'.$month.'/'; ?>");
            $("#county_graph").load("<?php echo base_url(); ?>rtk_management/fusion_test/" + county + "/<?php echo $month.'/'.$year.'/'; ?>");

   }
$(document).ready(function(){

  $(".breadcrumb").load("<?php echo base_url(); ?>rtk_management/reporting_counties/<?php echo $month.'/'.$year.'/'; ?>");
  $(".breadcrumb a").click( function(event)
{
   var clicked =  $(this).text();
   $( "#selectedcounty" ).html(clicked);
});
 

});
 
$(function(){

            $('#switch_month').change(function(){
                var value = $('#switch_month').val();
              var path = "<?php echo base_url().'rtk_management/switch_district/0/rtk_manager/';?>"+value + "/";
//              alert (path);
                 window.location.href=path;
            });
               });
</script>
<style>
.leftpanel{
    	width: 17%;
    	height:auto;
    	float: left;
    }

.alerts{
	width:95%;
	height:auto;
	background: #E3E4FA;	
	padding-bottom: 2px;
	padding-left: 2px;
	margin-left:0.5em;
	-webkit-box-shadow: 0 8px 6px -6px black;
	   -moz-box-shadow: 0 8px 6px -6px black;
	        box-shadow: 0 8px 6px -6px black;
	
}
    
    .dash_menu{
    width: 100%;
    float: left;
    height:auto; 
    -webkit-box-shadow: 2px 3px 5px#888;
	box-shadow: 2px 3px 5px #888; 
	margin-bottom:3.2em; 
    }
    
    .dash_main{
    width: 80%;
   min-height:100%;
height:600px;
    float: left;
    -webkit-box-shadow: 2px 2px 6px #888;
	box-shadow: 2px 2px 6px #888; 
    margin-left:0.75em;
    margin-bottom:0em;
    
    }
    .dash_notify{
    width: 15.85%;
    float: left;
    padding-left: 2px;
    height:450px;
    margin-left:8px;
    -webkit-box-shadow: 2px 2px 6px #888;
	box-shadow: 2px 2px 6px #888;
    
    }
    
#accordion {
    width: 300px;
    margin: 50px auto;
    float:left;
    margin-left:0.45em;
}
.collapsible,
.page_collapsible,
.accordion {
    margin: 0;
    padding:5%;
    height:15px;
    border-top:#f0f0f0 1px solid;
    background: #cccccc;
    font:normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;
    text-decoration:none;
    text-transform:uppercase;
	background: #29527b; /* Old browsers */
     border-radius: 0.5em;
     color: #fff; }
.accordion-open,
.collapse-open {
	background: #289909; /* Old browsers */    
    color: #fff; }
.accordion-open span,
.collapse-open span {
    display:block;
    float:right;
    padding:10px; }
.accordion-open span,
.collapse-open span {
    background:url('<?php echo base_url()?>Images/minus.jpg') center center no-repeat; }
.accordion-close span,
.collapse-close span {
    display:block;
    float:right;
    background:url('<?php echo base_url()?>Images/plus.jpg') center center no-repeat;
    padding:10px; }
div.container {
    width:auto;
    height:auto;
    padding:0;
    margin:0; }
div.content {
    background:#f0f0f0;
    margin: 0;
    padding:10px;
    font-size:.9em;
    line-height:1.5em;
    font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif; }
div.content ul, div.content p {
    padding:0;
    margin:0;
    padding:3px; }
div.content ul li {
    list-style-position:inside;
    line-height:25px; }
div.content ul li a {
    color:#555555; }
code {
    overflow:auto; }
.accordion h3.collapse-open {}
.accordion h3.collapse-close {}
.accordion h3.collapse-open span {}
.accordion h3.collapse-close span {}   
</style>

<div class="leftpanel">

<!--
<div class="dash_menu">
    
   <!-- <h3 class="accordion" class="ajax-call" id="facility_list">Facility List<span></span><h3>
<div class="container">
  
</div> 
<a class="ajax-call" id="reporting_rate" ><h3 class="accordion" >Reporting Rate<span></span><h3></a>
<div class="container">

</div>
<a class="ajax-call" id="county" ><h3 class="accordion" >County<span></span><h3></a>
<div class="container">

</div>

   <h3 class="accordion" >Reports <span></span><h3>
<div class="container">
	
   <div class="content">
   	
   	
    	<button class="awesome blue" ><a class="ajax-call" id="fcdrr">FCDRR</a></button>
      <button class="awesome blue" > <a class="ajax-call" id="lab_commodities">LAB COMMODITIES</a></button>
  
    </div>
</div>

</div>-->
<div class="sidebar">
<br />
<div class="span2 bs-docs-sidebar">
<select id="switch_month" style="width: 170px;background-color: #ffffff;border: 1px solid #cccccc;">
<option>-- <?php echo $englishdate;?> --</option>
<option value="092013">Sept 2013</option>
<option value="102013">Oct 2013</option>
<option value="112013">Nov 2013</option>
<option value="122013">Dec 2013</option>

</select>
   <!-- <ul class="nav nav-tabs nav-stacked">
        <li><a href="http://localhost/HCMP/">Counties</a></li>
        <li class="active"><a href="#" onclick="loadDistrict()">Districts</a></li>
        <li class="active"><a href="#" onclick="loadPendingFacilities()">Facilities</a></li>
<!--        <li><a href="#" onclick="loadSummary()">Reports</a></li>-->
  <!--  </ul>-->
</div>
	<!--
		<h2>Quick Access</h2>
<nav class="sidenav">
	<ul>
		<li class="orders_minibar"><a href="#">demo</a></li>

	<ul>
</nav>
-->				
		</fieldset>
	
</div>
</div>
<div class="dash_main" id = "dash_main">
<div id="test_a" style="overflow: scroll; height: 51em; min-height:100%; margin: 0; width: 100%">
<ul class="breadcrumb" style="margin: 0 0 0px;">
<?php
$this->load->database();
$q = 'SELECT id,county FROM  `counties` ORDER BY  `counties`.`county` ASC   ';
$res_arr = $this->db->query($q);
foreach ($res_arr->result_array() as $value) {
  ?> 
<li><a href="#" value ="<?php echo $value['county'] ; ?>" onclick="loadcountysummary(<?php echo $value['id'] ; ?>)"><?php echo $value['county'] ; ?></a> <span class="divider">/</span></li>
<?php 
} ?>

   </ul>
<div class="well">
<div class="page-header">
     <h1 style="font-size: 207%;">County summary <?php echo $englishdate;?><small> Kenya</small></h1>
   </div>
<!--     <h4>Leading County in reporting: Nakuru</h4>-->
     <div id="county_graph"></div>
     <div id="county_summary"></div>
</div>
		</div>
</div>


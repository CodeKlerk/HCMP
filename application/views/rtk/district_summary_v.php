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
   
</style>

<div class="leftpanel">

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
</div>
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


<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript">
$(document).ready(function(){
	        //$('.accordion').accordion({defaultOpen: ''});
         //custom animation for open/close
    $.fn.slideFadeToggle = function(speed, easing, callback) {
        return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
    };
    $('.accordion').accordion({
        defaultOpen: 'section1',
        cookieName: 'nav',
        speed: 'medium',
        animateOpen: function (elem, opts) { //replace the standard slideUp with custom function
            elem.next().slideFadeToggle(opts.speed);
        },
        animateClose: function (elem, opts) { //replace the standard slideDown with custom function
            elem.next().slideFadeToggle(opts.speed);
        }
    });
    //default call
    var url = "<?php echo base_url().'report_management/get_stock_status_ajax' ?>"
    
    ajax_request (url);

$(".ajax-call").click(function(){
var id  = $(this).attr("id"); 
 
  if(id=='consumptionTrends'){
  	 var url = "<?php echo base_url().'report_management/get_consumption_trends_ajax' ?>";
       	
  }
  if(id=='stockStatus'){
  	var url = "<?php echo base_url().'report_management/get_stock_status_ajax' ?>";
       
  }
  if(id=='costoforders'){
  	var url = "<?php echo base_url().'report_management/get_costoforders_chart_ajax'?>";
  }
  if(id=='costofexpiries'){
  	 var url = "<?php echo base_url().'report_management/get_costofexpiries_chart_ajax'?>";
  }
  if(id=='leadtime'){
  	var url = "<?php echo base_url().'report_management/get_leadtime_chart_ajax'?>";
  }
  if(id=='consumptionTrends'){
  	
  }
  
  ajax_request (url);
    
});

		$('#facilities').change(function() {
		var url = "<?php echo base_url().'report_management/get_district_facility_stock_/'?>";	
		url=url+"bar2d_facility/"+$(this).val();
		ajax_request(url);
		});

        $('#desc').change(function() {
		var url = "<?php echo base_url().'report_management/get_district_facility_stock_/'?>";	
		url=url+"bar2d_drug/"+$(this).val();
		ajax_request(url);
		});

function ajax_request (url){
	var url =url;
	var loading_icon="<?php echo base_url().'Images/loader.gif' ?>";
	 $.ajax({
          type: "POST",
          url: url,
          beforeSend: function() {
            $("#test_a").html("");
            
             $("#test_a").html("<img style='margin-left:20%;' src="+loading_icon+">");
            
          },
          success: function(msg) {
          $("#test_a").html("");
            $("#test_a").html(msg);           
          }
        }); 
}

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
    width: 65%;
    height:auto;
    float: left;
    -webkit-box-shadow: 2px 2px 6px #888;
	box-shadow: 2px 2px 6px #888; 
    margin-left:0.75em;
    
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

<div class="dash_menu">
    
    <h3 class="accordion" id="section1">Stock Status<span></span><h3>
   <select id="desc" name="desc" class="dropdownsize">
    <option>Select Commodity Name</option>
		<?php 
		foreach ($drugs_array as $drugs) {
			$id=$drugs->id;
			$kemsa=$drugs->Kemsa_Code;
			$drug=$drugs->Drug_Name;
			?>
			<option value="<?php echo $id; ?>"><?php echo $drug; ?></option>
			
		<?php } ?>		
	</select>
		<select id="facilities" class="dropdownsize">
		<option>Select Facility</option>
		<?php 
		foreach ($facilities as $counties) {
			$id=$counties->facility_code;
			$county=$counties->facility_name;?>
			<option value="<?php echo $id;?>"><?php echo $county;?></option>
		<?php }
		?>
	</select>
<div class="container">
    <div class="content">
    	 <h3 ><a href="#" class="ajax-call" id="stockStatus" >Stock Status in the District</a></h3>
    </div>
</div>
<h3 class="accordion" >Lead Time<span></span><h3>
<div class="container">
    <div class="content">
    	
      <h3 ><a href="#" class="ajax-call" id="leadtime" >Lead time of orders per facility</a></h3>
  
    </div>
</div>
<h3 class="accordion" id="section3">Costing<span></span><h3>
<div class="container">
    <div class="content">
      <h3><a href="#" class="ajax-call" id ='costofexpiries'>Cost of expired commodities</a></h3>
      <h3><a href="#" class="ajax-call" id = 'costoforders'>Cost of ordered commodities</a></h3>
    
    </div>
</div>
<h3 class="accordion" id="section4">Consumption Trends<span></span><h3>
<div class="container">
    <div class="content">
       <h3 ><a href="#" class="ajax-call" id="consumptionTrends" >Consumption Trends</a></h3>
        
    </div>
</div>


</div>
<div class="sidebar">
	
		<h2>Quick Access</h2>
<nav class="sidenav">
	<ul>
		<li class="orders_minibar"><a href="<?php echo site_url('order_approval/district_orders');?>">Orders</a></li>
		<li class="users_minibar"><a href="<?php echo site_url('user_management/dist_manage');?>">Users</a></li>
		<li class="reports_minibar"><a href="<?php echo site_url('report_management/division_reports');?>">Reports</a></li>
	<ul>
</nav>
				
		</fieldset>
	
</div>
</div>
<div class="dash_main" id = "dash_main">
<div id="test_a" style="overflow: scroll; height: 51em; min-height:100%; margin: 0; width: 100%">

		</div>
</div>
<div class="dash_notify">
	<h2>Notifications</h2>
	
			<?php if($pending_orders>0):?>
		<div class="alerts">
			<h2>&nbsp;</h2>
			<p>
				<a href="<?php 
				echo site_url('order_approval/district_orders');?>" <a class="link"><?php echo $pending_orders.' Orders Pending approval'?> </a>
			</p>
		</div>
		<?php endif; ?>
		<?php if($decommisioned>0):?>
		<div class="alerts">
			<h2>Decommissioned</h2>
			<p>
				<a href="<?php 
				echo site_url('order_approval/district_orders');?>" <a class="link"><?php echo ($decommisioned).' facilities have flagged expired Commodities'?> </a>
			</p>
		</div>
		<?php endif; ?>
		
</div>

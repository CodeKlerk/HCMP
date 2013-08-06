<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript">
$(document).ready(function(){


  $.fn.slideFadeToggle = function(speed, easing, callback) {
				return this.animate({
					opacity : 'toggle',
					height : 'toggle'
				}, speed, easing, callback);
			};

			$('.accordion').accordion({
				defaultOpen : 'section1',
				cookieName : 'nav',
				speed : 'medium',
				animateOpen : function(elem, opts) {//replace the standard slideUp with custom function
					elem.next().slideFadeToggle(opts.speed);
				},
				animateClose : function(elem, opts) {//replace the standard slideDown with custom function
					elem.next().slideFadeToggle(opts.speed);
				}
			});
    //default ca
    //default call
    var url = "<?php echo base_url().'cd4_management/get_cd4_allocation_kenyan_map' ?>"
    
    ajax_request (url);

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

			  //popout
$( "#dialog1" ).dialog({
			height: 140,
			modal: true
		});
		
		var chart = new FusionCharts("<?php echo base_url()."scripts/FusionWidgets/Charts/HLinearGauge.swf"?>", "ChartId", "100%", "10%", "0", "0");
		var url = '<?php echo base_url()."rtk_management/get_allocation_rate_national_hlineargauge//"?>'; 
		chart.setDataURL(url);
		chart.render("chart4");

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
height:1400px;
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
<div>


<!--<div style="width:100%; height:200px; ">

<div class="multiple_chart_content" style="width:100%; height: 100%;"  id="national_reporting"></div>

</div>-->
<div class="leftpanel">

<div class="dash_menu">  
<!-- <h3 class="accordion" class="ajax-call" id="facility_list">Facility List<span></span><h3>
<div class="container">
 </div>-->
<h3 class="accordion" id="section1" >Allocation Rate<span></span><h3>
<div class="container">

	<div class="multiple_chart_content" style="width:100%; height:15%" id="chart4"></div>
	<table class="data-table" style="margin-left: 0px;">
		<thead>
		<tr>
			<td width="50%">Counties</td><td><h6>No. Reporting Facilities | No. Allocated Facilities</h6></td>
		</tr>
		</thead>
		<tbody>
    <tr><td><a href="#"> Baringo</a> </td><td>23 | 1</td></tr><tr><td><a href="#"> Bomet</a> </td><td>56 | 0</td></tr><tr><td><a href="#"> Bungoma</a> </td><td>64 | 0</td></tr><tr><td><a href="#"> Busia</a> </td><td>28 | 0</td></tr><tr><td><a href="#"> Elgeyo Marakwet</a> </td><td>40 | 0</td></tr><tr><td><a href="#"> Embu</a> </td><td>0 | 0</td></tr><tr><td><a href="#"> Garissa</a> </td><td>8 | 0</td></tr><tr><td><a href="#"> Homa Bay</a> </td><td>80 | 0</td></tr><tr><td><a href="#"0> Isiolo</a> </td><td>2 | 0</td></tr><tr><td><a href="#"1> Kajiado</a> </td><td>24 | 0</td></tr><tr><td><a href="#"2> Kakamega</a> </td><td>47 | 0</td></tr><tr><td><a href="#"3> Kericho</a> </td><td>64 | 0</td></tr><tr><td><a href="#"4> Kiambu</a> </td><td>68 | 0</td></tr><tr><td><a href="#"5> Kilifi</a> </td><td>129 | 0</td></tr><tr><td><a href="#"6> Kirinyaga</a> </td><td>0 | 0</td></tr><tr><td><a href="#"7> Kisii</a> </td><td>37 | 0</td></tr><tr><td><a href="#"8> Kisumu</a> </td><td>103 | 0</td></tr><tr><td><a href="#"9> Kitui</a> </td><td>75 | 0</td></tr><tr><td><a href="#"0> Kwale</a> </td><td>47 | 0</td></tr><tr><td><a href="#"1> Laikipia</a> </td><td>0 | 0</td></tr><tr><td><a href="#"2> Lamu</a> </td><td>20 | 0</td></tr><tr><td><a href="#"3> Machakos</a> </td><td>40 | 0</td></tr><tr><td><a href="#"4> Makueni</a> </td><td>61 | 0</td></tr><tr><td><a href="#"5> Mandera</a> </td><td>4 | 0</td></tr><tr><td><a href="#"6> Marsabit</a> </td><td>20 | 0</td></tr><tr><td><a href="#"7> Meru</a> </td><td>42 | 0</td></tr><tr><td><a href="#"8> Migori</a> </td><td>119 | 0</td></tr><tr><td><a href="#"9> Mombasa</a> </td><td>25 | 0</td></tr><tr><td><a href="#"0> Muranga</a> </td><td>50 | 0</td></tr><tr><td><a href="#"> Nairobi</a> </td><td>1 | 0</td></tr><tr><td><a href="#"1> Nakuru</a> </td><td>76 | 0</td></tr><tr><td><a href="#"2> Nandi</a> </td><td>66 | 0</td></tr><tr><td><a href="#"3> Narok</a> </td><td>65 | 0</td></tr><tr><td><a href="#"4> Nyamira</a> </td><td>40 | 0</td></tr><tr><td><a href="#"5> Nyandarua</a> </td><td>52 | 0</td></tr><tr><td><a href="#"6> Nyeri</a> </td><td>113 | 0</td></tr><tr><td><a href="#"7> Samburu</a> </td><td>1 | 0</td></tr><tr><td><a href="#"8> Siaya</a> </td><td>112 | 0</td></tr><tr><td><a href="#"9> Taita Taveta</a> </td><td>45 | 0</td></tr><tr><td><a href="#"0> Tana River</a> <
/td><td>10 | 0</td></tr><tr><td><a href="#"1> Tharaka Nithi</a> </td><td>18 | 0</td></tr><tr><td><a href="#"2> Trans Nzoia</a> </td><td>36 | 0</td></tr><tr><td><a href="#"3> Turkana</a> </td><td>12 | 0</td></tr><tr><td><a href="#"4> Uasin Gishu</a> </td><td>23 | 0</td></tr><tr><td><a href="#"5> Vihiga</a> </td><td>29 | 0</td></tr><tr><td><a href="#"6> Wajir</a> </td><td>6 | 0</td></tr><tr><td><a href="#"7> West Pokot</a> </td><td>26 | 0</td></tr><tr><td>TOTAL </td><td> 2007 | 1</td><tr>  
		<?php 
		
 //		echo $table_data;
		?>
			
		 
		</tbody>
	</table>
	
</div>


</div>

</div>
<?php $this->load->view('cd4/ajax_view/kenyan_county_v'); ?>
 </div>
<!--
<div class="dash_main" id = "dash_main">
<div id="test_a" style="overflow: scroll; height: 51em; min-height:100%; margin: 0; width: 100%">

		</div>
</div>-->
<?php if(isset($pop_up)){   echo '<div id="dialog1" title="System Notification"><h3>'.$pop_up.'</h3><div>'; } unset($pop_up);  ?>
<script type="text/javascript">
  var chart = new FusionMaps("<?php echo base_url()."Scripts/FusionCharts/Column2D.swf"?>","ChartId", "30%", "80%", "0", "1" );
    var url = '<?php echo base_url()."cd4_management/national_yearly_reporting_chart"?>'; 
    chart.setDataURL(url);
    chart.render("national_reporting");
</script>
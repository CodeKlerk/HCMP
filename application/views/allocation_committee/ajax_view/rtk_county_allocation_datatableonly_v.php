<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>

<script type="text/javascript">

$(document).ready(function(){

		
	 

				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable( {
					"bJQueryUI": true,
					"aaSorting": [[ 10, "desc" ]],
					"bPaginate": false} );				
					$( "#allocate" )
			.button()
			.click(function() {
				  $('#myform').submit();
				
});	
								
		 

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
 
			$('#countiesselect').change(function(){
				var value = $('#countiesselect').val();
 
				 window.location.href=value;

			});
				

});
</script>
<style>
	@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
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

<div class="leftpanel">
 
<br />
<div class="dash_menu">  
<!-- <h3 class="accordion" class="ajax-call" id="facility_list">Facility List<span></span><h3>
<div class="container">
 </div>-->
 <br />
 <select id="countiesselect">
			<option> -- Select county -- </option>
							<option value="1">Nairobi </option>
								<option value="2">Baringo </option>
								<option value="3">Bomet </option>
								<option value="4">Bungoma </option>
								<option value="5">Busia </option>
								<option value="6">Elgeyo Marakwet </option>
								<option value="7">Embu </option>
								<option value="8">Garissa </option>
								<option value="9">Homa Bay </option>
								<option value="10">Isiolo </option>
								<option value="11">Kajiado </option>
								<option value="12">Kakamega </option>
								<option value="13">Kericho </option>
								<option value="14">Kiambu </option>
								<option value="15">Kilifi </option>
								<option value="16">Kirinyaga </option>
								<option value="17">Kisii </option>
								<option value="18">Kisumu </option>
								<option value="19">Kitui </option>
								<option value="20">Kwale </option>
								<option value="21">Laikipia </option>
								<option value="22">Lamu </option>
								<option value="23">Machakos </option>
								<option value="24">Makueni </option>
								<option value="25">Mandera </option>
								<option value="26">Marsabit </option>
								<option value="27">Meru </option>
								<option value="28">Migori </option>
								<option value="29">Mombasa </option>
								<option value="30">Muranga </option>
								<option value="31">Nakuru </option>
								<option value="32">Nandi </option>
								<option value="33">Narok </option>
								<option value="34">Nyamira </option>
								<option value="35">Nyandarua </option>
								<option value="36">Nyeri </option>
								<option value="37">Samburu </option>
								<option value="38">Siaya </option>
								<option value="39">Taita Taveta </option>
								<option value="40">Tana River </option>
								<option value="41">Tharaka Nithi </option>
								<option value="42">Trans Nzoia </option>
								<option value="43">Turkana </option>
								<option value="44">Uasin Gishu </option>
								<option value="45">Vihiga </option>
								<option value="46">Wajir </option>
								<option value="47">West Pokot </option>
							</select>
 
<h3 class="accordion" id="section1" >Allocation Rate<span></span><h3>
<div class="container">

<!--	<div class="multiple_chart_content" style="width:100%; height:15%" id="chart4"></div>-->
	<table class="data-table" style="margin-left: 0px;">
		<thead>
		<tr>
			<td width="50%">Counties</td><td><h6>(Allocated/Total) Facilities</h6></td>
		</tr>
		</thead>
		<tbody>
		<?php 
		
		echo $table_data;
		
		
		?>
			
		 
		</tbody>
	</table>
	
</div>


</div>

</div>
<div class="dash_main" id = "dash_main">

<?php $attributes = array( 'name' => 'myform', 'id'=>'myform');
	 echo form_open('rtk_management/rtk_allocation_data/'.$county_id,$attributes); ?>
		<table id="example">
					<thead>
					<tr>
						<th><b>MFL</b></th>
						<th><b>Facility Name</b></th>
                                                <th><b>District</b></th>
				 
						<th><b>Commodity</b></th>
						<th><b>Quantity Received</b></th>
						<th><b>Quantity Consumed</b></th>
						<th><b>End of Month Physical Count</b></th>

						<th><b>Quantity Requested for Re-Supply</b></th>
						<th><b>Quantity Allocated</b></th>
						<th><b>Quantity Issued(From KEMSA)</b></th>
						<th><b>Status</b></th>
											    
					</tr>
					</thead>
					<tbody>
		<?php 
			echo $table_body;
			
		 ?>
							
				</tbody>
				</table>
				<input  class="button" id="allocate"  value="Allocate" >
		<?php  echo form_close();
		?>	
</div>
 

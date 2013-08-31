<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
			.user2{
	width:70px;
	
	text-align: center;
	}
	 #allocated{
	 	background: #D1F8D5;
        }
		</style>	 
				<script type="text/javascript" charset="utf-8">
			
			$(function() { 

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
								
			} );
			
			</script>
	<style>
 
</style>
 
<?php $attributes = array( 'name' => 'myform', 'id'=>'myform');
	 echo form_open('rtk_management/rtk_allocation_data/'.$county_id,$attributes); ?>
		<table id="example" width="100%">
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
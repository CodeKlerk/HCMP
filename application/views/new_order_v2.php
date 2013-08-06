<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>
		<style>

			.warning2 {
	background: #FEFFC8 url('<?php echo base_url()?>Images/excel-icon.jpg') 20px 50% no-repeat;
	border: 1px solid #F1AA2D;
	}
		</style>
<?php $current_year = date('Y');
$earliest_year = $current_year - 10;
?>
		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
				return ((x < y) ? -1 : ((x > y) ?  1 : 0));
			};
			
			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
				return ((x < y) ?  1 : ((x > y) ? -1 : 0));
			};
			
			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable( {
					"bJQueryUI": true,
					
					"aaSorting": [ [0,'asc'], [1,'asc'] ],
					"aoColumnDefs": [
						{ "sType": 'string-case', "aTargets": [ 2 ] }
					]
				} );
			} );
		</script>
		<div style="margin-left: 80%" >
		<a href="<?php echo site_url('report_management/commodity_excel');?>">
			<div class="activity excel"><h2> Download</h2></div>
			</a></div>
						<table  style="margin-left: 0;" id="example" width="100%">
					<thead>
					<tr>
						<th><b>Category</b></th>
						<th><b>Description</b></th>
						<th><b>KEMSA Code</b></th>
						<th><b>Order Unit Size</b></th>
						<th><b>Order Unit Cost (KSH) <br> 2012-2013</b></th>				    
					</tr>
					</thead>
					<tbody>
		<?php 
		foreach($drug_categories as $category):?>

					<?php
						foreach($category->Category as $drug):?>
							
						<tr>
							
							
							<td><?php echo $category->Category_Name?></td>
							<td><?php echo $drug->Drug_Name;?></td>
							<td><?php echo $drug->Kemsa_Code;?></td>
							<td> <?php echo $drug->Unit_Size;?> </td>
							<td><?php echo $drug->Unit_Cost;?> </td>
						</tr>
						
						<?php endforeach;?>
		<?php endforeach;?>
		</tbody>
						
						
				</table>
 
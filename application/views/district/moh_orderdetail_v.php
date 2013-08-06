<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media2/css/jquery.dataTables.css";
		</style>	
<script>
/******************************************data-table set up*********************/
/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
				return ((x < y) ? -1 : ((x > y) ?  1 : 0));
			};
			
			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
				return ((x < y) ?  1 : ((x > y) ? -1 : 0));
			};
			
			 $(function() {
			//button to post the order
			$( "#approve" )
			.button()
			.click(function() {
			//document.myform.submit();
			//alert($('input:hidden[name=f_order_id]').val())
			$('#myform').submit();
			});	

	});	
			

	   $(document).ready(function() {

    	$('#main1').dataTable( {
    		"aaSorting": [ [0,'asc'], [1,'asc'] ],
					"bJQueryUI": true,
                   "bPaginate": false
				} );
    
});
</script>

<div id="notification">Quantified Quantity = (Consumption * 4/) - Closing Stock</div>
<caption><p style="letter-spacing: 1px;font-weight: bold;text-shadow: 0 1px rgba(0, 0, 0, 0.1);font-size: 14px; " >
	Facility Order No <?php echo $this->uri->segment(3);?>| Facility MFl code <?php echo $this->uri->segment(4);?></p></caption>
<?php $attributes = array( 'name' => 'myform', 'id'=>'myform');
	 echo form_open('Order_Approval/update_order',$attributes); ?>	
	 
<table id="main1">
	<?php echo form_hidden('f_order_id', $this->uri->segment(3));?>
	<thead>
	<tr>
		
		                <th><b>Category</b></th>
						<th><b>Description</b></th>
						<th><b>KEMSA Code</b></th>
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
					   <th><b>Quantified Quantities</b></th>
	</tr>
	</thead>
	<tbody>
		
	<?php $count=0;
	
		foreach($detail_list as $rows){
			
			
			//setting the values to display
			 $ordered=$rows->quantityOrdered;
			 $code=$rows->kemsa_code;
			 $t_issues=$rows->t_issues;
			 $c_stock=$rows->c_stock;
			 $value=(($t_issues*4)/3)-$c_stock;
			 if($value<0){
			 	$value=0;
			 }
			?>
			
	<tr>
		<?php echo form_hidden('order_id[]', $rows->id);?>
		<?php foreach($rows->Code as $drug)
		foreach($drug->Category as $cat){
				
			$cat_name=$cat;	
				
			}
			echo "<td>$cat_name</td>";
		
		$cost=$drug->Unit_Cost; $t_cost=$cost*$ordered;
		 echo '<td>'.$drug->Drug_Name.'</td><td>'.$drug->Kemsa_Code.'</td><td>'.$drug->Unit_Size.'</td><td>'.$drug->Unit_Cost.'</td>';?>
		<td ><?php echo $rows->o_balance;?></td>
		<td><?php echo $rows->t_receipts;?></td>
		<td><?php echo $t_issues;?></td>
		<td><?php echo $rows->adjust;?></td>
		<td><?php echo $rows->losses;?></td>
		<td><?php echo $c_stock;?></td>
		<td><?php echo $rows->days;?></td>
		<td><?php echo $ordered;?></td>
		<td><?php echo  ceil($t_cost);?></td>
		<td><?php echo $rows->comment;?></td>
		<td><input type="text" value="<?php echo  ceil($value);?>" <?php echo ' name="adj[]"'?> /></td>		
	</tr> 
	<?php
	$count++;	}
	?></ol>
	</tbody>
</table>

<br>
<br />
<input type="submit" class="button" id="approve"  value="Approve Order" style="margin-left: 0%" >
<?php echo form_close(); ?>


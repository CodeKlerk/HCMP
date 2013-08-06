<script type="text/javascript">
	$(function() {

		// Accordion
		$("#accordion").accordion({
			header : "h3"
		});
		//tabs
		$('#tabs').tabs();
		
		//popout
		  $( "#dialog" ).dialog();
	});

</script>
<div id="tabs">
	<?php if(isset($popout)){ ?><div id="dialog" title="System Message"><p><?php echo $popout;?></p></div><?php }?>
	<!--tabs!-->
	<ul>
		<li>
			<a href="#tabs-1">Pending Approval </a>
		</li>
		<li>
			<a href="#tabs-2">Pending Dispatch</a>
		</li>
		<!--<li>
			<a href="#tabs-4">Dispatched From KEMSA</a>
		</li>-->
		<li>
			<a href="#tabs-5">Received by Facility</a>
		</li>
	</ul>
	<div id="tabs-1">
		<!--tab1 content!-->
		<?php if(count($pending)>0) :?>
		<table class="data-table">
			<tr>
				<th><strong>Facility Order No </strong></th>
				<th><strong>Order Total Ksh</strong></th> 
				<th><strong>Date Ordered</strong></th> 
				<th><strong>Days Pending </strong></th>
				<th>Action</th>
			</tr>
			<?php foreach($pending as $rows):?>
			<tr>
				<td><?php echo $rows->id;?></td>
				<td><?php echo number_format($rows->orderTotal, 2, '.', ',');?></td>
				<td><?php 
		$datea= $rows->orderDate;
		$fechaa = new DateTime($datea);
		$today=new DateTime();
        $datea= $fechaa->format(' d  M Y');
		echo $datea;?></td> 
				<td><?php 
		$days1=$myClass->getWorkingDays($fechaa,$today,0);
        	echo $days1;
?></td> 

				<td><a href="<?php echo site_url('order_management/moh_order_details/'.$rows->id.'/'.$rows->kemsaOrderid)?>"class="link">View</a></td>
			</tr>
			<?php
 endforeach;
	?>	 
		</table>
		<?php 
else :
	echo '<p id="notification">No Records Found </p>';
endif; ?>
		<div class="pagination"></div>
	</div><!--tab1!-->
		<div id="tabs-2">
		<!--tab1 content!-->
		<?php if(count($pending_d)>0) :?>
		<table class="data-table">
			<tr>
				<th><strong>Facility Order No </strong></th>
				<th><strong>KEMSA Order No </strong></th>
				<th><strong>Order Total Ksh</strong></th> 
				<th><strong>Date Ordered</strong></th> 
				<th><strong>Days Pending </strong></th>
				<th>Action</th>
			</tr>
			<?php foreach($pending_d as $rows_d):?>
			<tr>
				<?php echo "<td>$rows_d->id</td>
				<td>$rows_d->kemsaOrderid</td>
				 <td>".number_format($rows_d->orderTotal, 2, '.', ',')."</td>";
				
		$datea= $rows_d->orderDate;
		$fechaa = new DateTime($datea);
		$today=new DateTime();
        $datea= $fechaa->format(' d  M Y');
		echo "<td>".$datea."</td>"; 
			
		$days1=$myClass->getWorkingDays($fechaa,$today,0);
        	echo "<td>".$days1."</td>";
?></td> 

				<td><a href="<?php echo site_url('order_management/moh_order_details/'.$rows_d->id.'/'.$rows_d->kemsaOrderid)?>"class="link">View</a>|<a href="<?php echo site_url('stock_management/new_update/'.$rows_d->id.'/'.$rows_d->kemsaOrderid)?>" class="link">Update</a?</a></td>
			</tr>
			<?php
 endforeach;
	?>	 
		</table>
		<?php 
else :
	echo '<p id="notification">No Records Found </p>';
endif; ?>
		<div class="pagination"></div>
	</div><!--tab1!-->
	<!--
	<div id="tabs-4">
		<!--tab 4 content
		<?php if(count($dispatched)>0) :?>
		<table class="data-table">
			<tr>
				<th><strong>Facility Order No </strong></th>
				<th><strong>KEMSA Order No </strong></th>
				<th><strong>Order Total Ksh</strong></th>
				<th><strong>Date Ordered</strong></th> 
				<th><strong>Date Reviewed</strong></th> 
				<th><strong>Date Received(kemsa)</strong></th>
				<th><strong>Date Dispatched</strong></th> 
				<th>Action</th>
			</tr>
			<?php foreach($dispatched as $d):?>
			<tr>
				<td><?php echo $d->id;?></td>
				<td><?php echo $d->kemsaOrderid;?></td>
				<td><?php echo number_format($d->orderTotal, 2, '.', ',');?></td>
				<td><?php 
		$datead= $d->orderDate;
		$fechaad = new DateTime($datead);
        $dated= $fechaad->format(' d  M Y');
		echo $dated;?></td> 
				<td><?php 
		if($d->approvalDate!=NULL){
		$date_approval = new DateTime($d->approvalDate);
        $dateb_approval= $date_approval->format(' d  M Y');
		echo $dateb_approval;}
		?></td> 
		<td><?php echo $dateb_approval; ?></td>
				<td><?php 
		$datebd= $d->dispatchDate;
		if($d->dispatchDate!=NULL){
		$fechabd = new DateTime($datebd);
		$today=new DateTime();
        $datebd= $fechabd->format(' d  M Y');
		echo $datebd;}?></td>
				<td><a href="<?php echo site_url('order_management/moh_order_details/'.$d->id.'/'.$d->kemsaOrderid)?>"class="link">View</a></td>
			</tr>
	<?php
endforeach;
	?>
			
		</table>
		<?php 
else :
	echo '<p id="notification">No Records Found </p>';
endif; ?>
	</div><!--tab 3!-->
	<div id="tabs-5">
		<!--tab 4 content!-->
		<?php if(count($received)>0) :?>
		<table class="data-table">
			<tr>
				<th><strong>Facility Order No </strong></th>
				<th><strong>KEMSA Order No </strong></th>
				<th><strong>Order Total Ksh</strong></th>
				<th><strong>Date Ordered</strong></th> 
				<th><strong>Date Reviewed (DPF) </strong></th> 
				<th><strong>Lead Time</strong></th>
				<th><strong>Date Dispatched(KEMSA)</strong></th> 
				<th><strong>Date Received(facility)</strong></th>
				<th><strong>Lead Time</strong></th>
				<th><strong>Average Lead Time</strong></th>
				<th>Action</th>
			</tr>
			<?php foreach($received as $d1):?>
			<tr>
				<?php echo "<td>$d1->id</td>
				<td>$d1->kemsaOrderid</td>
				<td>$d1->orderTotal</td>";
				 
	
		$orderDate = new DateTime(date($d1->orderDate));
        $dated= $orderDate->format('d  M Y');
		echo "<td>".$dated."</td>";
				
		$date_approval = new DateTime(date($d1->approvalDate));
        $dateb_approval= $date_approval->format('d  M Y');
		echo "<td>".$dateb_approval."</td>";
		
		//$date_diff=$myClass->getWorkingDays($orderDate,$date_approval,0);
         $dDiff = $orderDate->diff($date_approval);
         $date_diff= $dDiff->days;
        echo "<td>".$date_diff." day(s)"."</td>";

		$dispatchDate = new DateTime(date($d1->dispatchDate));
        $datebd= $dispatchDate->format(' d  M Y');
		echo "<td>".$datebd."</td>";
	
		$deliverDate = new DateTime(date($d1->deliverDate));
        $datebd1= $deliverDate->format(' d  M Y');
		echo "<td>".$datebd1."</td>";
		
	    //$date_diff=$myClass->getWorkingDays($dispatchDate,$deliverDate,0);
	     $dDiff = $dispatchDate->diff($deliverDate);
         $date_diff= $dDiff->days;
        echo "<td>".$date_diff." day(s)"."</td>";
        
       // $date_diff=$myClass->getWorkingDays($orderDate,$deliverDate,0);
       	  $dDiff = $orderDate->diff($deliverDate);
         $date_diff= $dDiff->days;
        echo "<td>".$date_diff." day(s)"; ?></td>
		<td><a href="<?php echo site_url('order_management/moh_order_details/'.$d1->id.'/'.$d1->kemsaOrderid)?>"class="link">View</a></td>
		
			</tr>
	<?php
endforeach;
	?>
		</table>
		<?php 
else :
	echo '<p id="notification">No Records Found </p>';
endif; ?>
	</div><!--tab 3!-->
</div>
<!--tabs!-->

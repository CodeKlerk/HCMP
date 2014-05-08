<?php 
$facility=$this -> session -> userdata('news');
$access_level = $this -> session -> userdata('user_indicator');
?>
<style>

	  #right_content h2 {
		background: #b6b6b6; /* Old browsers */
		padding: 5px;
		text-align: center;
		margin: 0 0 0.625em 0;
		border-right-style: inset;
	}
</style>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript">
$(document).ready(function(){
	$("#pop").popover({trigger :'hover', delay: { show:200, hide: 1000 }});
	
    
        var url = "<?php echo base_url()."report_management/get_district_facility_stock_/bar2d_facility/$facility"?>";	
		
		
		var div=".stockstatuschart";
		
		ajax_request(url,div);
		
		
		
		function ajax_request (url,div){
	var url =url;
	var loading_icon="<?php echo base_url().'Images/loader.gif' ?>";
	 $.ajax({
          type: "POST",
          url: url,
          beforeSend: function() {
            $(div).html("");
            
             $(div).html("<img style='margin-left:20%;' src="+loading_icon+">");
            
          },
          success: function(msg) {
          $(div).html("");
            $(div).html(msg);           
          }
        }); 
}
	
});

</script>

<div id="main_content">
	<div id="left_content" style="">
		<fieldset>
			<legend>Notifications</legend>
			<!--<?php if($incomplete_order > 0): ?>
			<div class="message warning">
			<h2>Incomplete Order</h2>
			<p>
				<a href="<?php 
				echo site_url('order_management/new_order');?>" <a class="link"> There exists an incomplete order </a>
			</p>
		</div>
			<?php endif; ?>
			<?php if($diff > 0): ?>
			<div class="message warning">
			<h2>Make order</h2>
			<p>
				<a href="<?php 
				echo site_url('stock_management/stock_level');?>" <a class="link"><?php echo $diff.' Days to deadline. Order now'?> </a>
			</p>
		</div>
			<?php endif; ?>-->
		<?php if($dispatched>0):?>
		<div class="message information">			
			<h2>Dispatched Orders</h2>			
			<p>
			<a class="link" href="<?php echo site_url("Order_Management/index/");?>"><?php echo$dispatched;  ?> Order(s) has been Dispatched from KEMSA stores.</a>
			</p>
		</div>
		<?php endif;?>
               <?php if($pending_orders >0):?>
		<div class="message warning">
			<h2>Orders Pending Approval by District Pharmacist</h2>
			<p>
				<a class="link" href="<?php 
				 echo site_url("Order_Management/index/#tabs-2");?>"><?php echo $pending_orders;?> Order(s) pending</a> 
			</p>
		</div>
		<?php endif;?>
		  <?php if($rejected_orders >0):?>
		<div class="message warning">
			<h2>Orders Rejected by District Pharmacist</h2>
			<p>
				<a class="link" href="<?php 
				 echo site_url("Order_Management/index/#tabs-0/true");?>"><?php echo $rejected_orders;?> Order(s) rejected</a> 
			</p>
		</div>
		<?php endif;?>
		<?php if($pending_orders_d>0):?>
		<div class="message warning">
			<h2>Pending Dispatch</h2>
			<p>
				<a class="link" href="<?php 
				 echo site_url("Order_Management/index/#tabs-2");?>"><?php echo $pending_orders_d;?> Order(s) pending dispatch from KEMSA</a>
			</p>
		</div>
		<?php endif;?>
		 <?php if($exp >0):?>
		<div class="message warning">
			<h2>Expired Commodities</h2>
			<p>
			<a class="link" href="<?php echo site_url("stock_expiry_management/expired/");?>"><?php echo $exp?> Expired Commodities awaiting decommisioning.</a> 
			</p>
		</div>
		<?php endif;?>
		<?php if($exp_count>0):?> 
		<div class="message warning">
                       <h2>Potential Expiries</h2>
                       <p>
                       <a href="<?php echo site_url('report_management/reports_home');?>" <a class="link"><?php echo $exp_count; ?> Product(s) Expiring in the next 6 months</a>
                       </p>
               </div>
               <?php endif;?>
                <?php 
               
          if (count($stock)<1){?> 
	<div class="message warning">
			<h2>1. No Stock (On First Run)</h2>
			<p>
				<a href="<?php 
				echo site_url('stock_management/facility_first_run');?>" <a class="link"> Please update your stock details </a>
			</p>
		</div>
	
		<?php }
		  
               $histrorical_count= count($percentage_complete)==0 ? 0 : round($percentage_complete[0]['percentage'],1);
			   
			   
			
       if ($histrorical_count<100){?> 
		<div class="message warning">
<h2>2. Incomplete Historical Stock (<?php echo $histrorical_count ?>% complete)</h2>
			<p>
				<a href="<?php 
				echo site_url('stock_management/historical_stock_take');?>" <a class="link"> Please provide your historical stock information (<?php
				
				echo ($histrorical_count==0)? $total_drugs : $percentage_complete[0]['balance'] ; 
				?> commodities remaining) </a>
			</p>
		</div>
		<?php }?>
		
               
		</fieldset>
		<fieldset>
		<legend>Actions</legend>
	     <?php
	   //  $stock=1;
	      if(count($stock)>0){?>
	     	 
		<!--<div class="activity update">
	    <a href="<?php echo site_url('service_point/index');?>"><h2>Add Service Points</h2>	</a>
		</div>-->
		<!--<div class="activity update">
	    <a href="<?php echo site_url('stock_management/facility_first_run');?>"><h2>Add Initial Stock Level</h2>	</a>
		</div>-->
		<div class="activity issue">
		<a href="<?php echo site_url('Issues_main/Index/Internal/'.$facility);?>"><h2>Issue Commodities to Sevice Points</h2></a>
		</div>
		<div class="activity ext">
		<a href="<?php echo site_url('Issues_main/Index/External/'.$facility);?>"><h2>Donate Commodities</h2></a>
		</div>	

		<div class="activity ext">
		<a href="<?php echo site_url('Issues_main/Index/Donation/'.$facility)?>"><h2>Receive Donation From Other Sources</h2></a>
		</div>
		
		<!-- <div class="btn-group" style="margin-left:15%">
    <button class="btn dropdown-toggle" data-toggle="dropdown">
     <a>Order Commodities</a>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
     <li><a class="link"  href="<?php echo site_url('order_management/new_order');?>">KEMSA</a></li> 
    </ul>
  </div>-->
		<a id="pop" title="" 
		data-content="<ol type='i'><li><a href='<?php echo site_url('order_management/new_order');?>'>KEMSA</a></li></ol>" 
		data-placement="right" data-toggle="popover" 
	
		data-original-title="" data-html="true">
		<div class="activity order"><h2>Order Commodities</h2></div></a>
		
		
		
		<div class="activity update_order">
		<a href="<?php echo site_url('order_management/#tabs-2');?>"><h2>Update Order Delivery</h2>	</a>
		</div>
		<?php if($access_level=="facility"): ?>
		<div class="activity users">
		<a href="<?php echo site_url('user_management/users_manage');?>"><h2>User Management</h2></a>
		</div>
		<?php endif; ?>
		
	    <!-- <div class="activity update">
	    <a href="<?php echo site_url('order_management/stock_level/v');?>"><h2>Update Physical Stock Count</h2>	</a>
		</div>-->
		<div class="activity reports">
	    <a href="<?php echo site_url('report_management/reports_Home');?>">	<h2>Facility Reports</h2>	</a>
		</div>	
		<!--<div class="activity settings">
	    <a href="<?php echo site_url('report_management/facility_settings');?>"><h2>Settings</h2>	</a>
		</div>-->
		    <?php } else if (count($stock)==0){?> 
	    <div class="activity update">
	    <a href="<?php echo site_url('stock_management/facility_first_run');?>"><h2>Update Stock Level</h2>	</a>
		</div>
		<div class="activity update">
	    <a href="<?php echo site_url('stock_management/historical_stock_take');?>"><h2>Provide Historical Stock Data</h2></a>
		</div>
	<?php }else if (count($percentage_complete)==0){?> 
	
		<div class="activity update">
	    <a href="<?php echo site_url('stock_management/historical_stock_take');?>"><h2>Provide Historical Stock Data</h2></a>
		</div>
	
		<?php }?>
		
		</fieldset>
		
		
	</div>
	<div id="right_content" style="">

		<h2 style="margin-bottom: 1.5em">Commodity Stock Level in Pack Size</h2>
        <h4>Mouse over to see values</h4>
	
		
			<div id="stock_status" class='stockstatuschart' style="overflow: auto; height: 80em; min-height:100%; margin: 0;">
				
			
		</div>

	</div>
	
</div>

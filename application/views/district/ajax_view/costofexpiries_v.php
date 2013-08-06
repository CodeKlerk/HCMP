<script type="text/javascript">
jQuery(document).ready(function() {
		var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Line.swf"?>", "ChartId", "85%", "85%", "0", "0");
		var url = '<?php echo base_url()."report_management/generate_costofexpiries_chart"?>'; 
		chart.setDataURL(url);
		chart.render("chart");
		
			$( "#filter-b" )
			.button()
			.click(function() {
				
});
			});
			
</script>
<?php      
     $currentYear = date('Y');
     $earliestYear = $currentYear-3;
      ?>
		<div id="filter" align="center">
		<fieldset>
			<!--<label for='expiriesselectedyear'>Select Year:</label>
			<select name='expiriesselectedyear' id='expiriesselectedyear'>
		<?php
		for($x=$currentYear;$x>=$earliestYear;$x--){
		?>
		<option value='<?php echo $x;?>'
		<?php
		if ($x == $currentYear) {echo 'selected';
		}
		?>><?php echo $x;?></option>
		<?php }?>
		</select>-->
	<label>Select Facility</label>
	<select id="facilities">
		<option>--facilities--</option>
		<?php 
		foreach ($facilities as $counties) {
			$id=$counties->id;
			$county=$counties->facility_name;?>
			<option value="<?php echo $id;?>"><?php echo $county;?></option>
		<?php }
		?>
	</select>			
	<input style="margin-left: 10px" type="button" id="filter-b" value="filter" />
	</fieldset>
	</div>
	
	<div id="chart-area" style="width: 100%; height: 100%">
	<div id="chart" >
		
	</div>
</div>
      

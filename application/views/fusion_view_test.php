
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>

<script src="<?php echo base_url();?>Scripts/jquery.js" type="text/javascript"></script> 

<script type="text/javascript">
	$().ready(function(){
		var chart = new FusionCharts("<?php echo base_url();?>scripts/FusionCharts/Column2D.swf", "ChartId1", "85%", "80%", "0", "0");
		var url = '<?php echo base_url();?>rtk_management/fusion_test/<?php echo $county.'/'. $month.'/'.$year.'/'; ?>fusion'; 
		chart.setDataURL(url);
		chart.render("chartarea");
		

	});

</script>


<div class="chart">
<div id="chartarea">
	
</div>
	
</div>
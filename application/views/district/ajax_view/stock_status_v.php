<script>
	$(function() {
		var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Bar2D.swf"?>", "ChartId", "100%", "200%", "0", "0");
		var url = '<?php echo base_url()."report_management/get_stock_status/$option/$facility_code"?>'; 
		chart.setDataURL(url);
		chart.render("chart");
	});
	</script>
<div id="chart-area" style="width: 100%; height: 100%">
	<div id="chart" >
		
	</div>
</div>


<script type="text/javascript">
jQuery(document).ready(function() {
		var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Line.swf"?>", "ChartId", "85%", "85%", "0", "0");
		var url = '<?php echo base_url()."report_management/generate_costofordered_chart"?>'; 
		chart.setDataURL(url);
		chart.render("chart");
			});
</script>
			<div id="chart-area" style="width: 100%; height: 100%">
	<div id="chart" >
		
	</div>
</div>
      
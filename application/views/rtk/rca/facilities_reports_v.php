
<?php
$month = $this->session->userdata('Month');
if ($month == '') {
    $month = date('mY', time());
}

$year = substr($month, -4);
$month = substr_replace($month, "", -4);
$monthyear = $year . '-' . $month . '-1';
$englishdate = date('F, Y', strtotime($monthyear));
?> 


<?php
$option = '';
$id = $this->session->userdata('user_id');
$q = 'SELECT counties.id AS countyid, counties.county
            FROM rca_county, counties
            WHERE rca_county.county = counties.id
            AND rca_county.rca =' . $id;
$res = $this->db->query($q);
foreach ($res->result_array() as $key => $value) {
    $option .= '<option value = "' . $value['countyid'] . '">' . $value['county'] . '</option>';
}
?>
<style type="text/css">
    #reports td{
        font-size: 13px;
        font-family: calibri;
    }
    #top{
    	position: fixed;
    	margin-top: -45px;
    	font-size: 13px;
        font-family: calibri;
    }
</style>
<link rel="stylesheet" type="text/css" href="http://tableclothjs.com/assets/css/tablecloth.css">
<script src="http://tableclothjs.com/assets/js/jquery.tablesorter.js"></script>
<script src="http://tableclothjs.com/assets/js/jquery.metadata.js"></script>
<script src="http://tableclothjs.com/assets/js/jquery.tablecloth.js"></script>

<script src="http://localhost/HCMP/scripts/bootstrap-typeahead.js"></script>

<script type="text/javascript">

           
    $(document).ready(function() {
        $("table").tablecloth({theme: "paper",         
          bordered: true,
          condensed: true,
          striped: true,
          sortable: true,
          clean: true,
          cleanElements: "th td",
          customClass: "my-table"
        });

        
    });
    var county = <?php echo $this->session->userdata('county_id'); ?>;


    $(function() {        
        $('#switch_month').change(function() {
            var value = $('#switch_month').val();
            var path = "<?php echo base_url() . 'rtk_management/switch_district/0/rca/'; ?>" + value + "/";
//              alert (path);
            window.location.href = path;
        });

        $('#switch_county').change(function() {
            var value = $('#switch_county').val();
            var path = "<?php echo base_url() . 'rtk_management/switch_district/0/rca/0/home_controller/'; ?>" + value + "";
//              alert (path);
            window.location.href = path;
        });
    });

    
</script>
<br />
<div class="span2 bs-docs-sidebar">
    <select id="switch_county" style="width: 170px;background-color: #ffffff;border: 1px solid #cccccc;">
        <option>-- Select county --</option>
<?php echo $option; ?>
    </select>
    <select id="switch_month" style="width: 170px;background-color: #ffffff;border: 1px solid #cccccc;">
        <option>-- <?php echo $englishdate; ?> --</option>
        <option value="092013">Sept 2013</option>
        <option value="102013">Oct 2013</option>
        <option value="112013">Nov 2013</option>
        <option value="122013">Dec 2013</option>
        <option value="12014">Jan 2014</option>
        <option value="22014">Feb 2014</option>
        <option value="32014">Mar 2014</option>


    </select>
    <ul class="nav nav-tabs nav-stacked" >
        <li><a href="<?php echo base_url().'rtk_management/county_home'?>">Summary</a></li>        
        <li><a href="<?php echo base_url().'rtk_management/rca_districts'?>">Districts</a></li>
        <li><a href="<?php echo base_url().'rtk_management/rca_pending_facilities'?>">Pending Facilities</a></li>
        <li><a href="<?php echo base_url().'rtk_management/rca_facilities_reports' ?>">Reports</a></li>
    </ul>
</div>

<div class="dash_main" style="width: 80%;float: right; overflow: scroll; height: 400px">
<div id="top" style="margin-left:140px">
    <p>
        <h2>Available Reports for <?php echo $county; ?> County</h2>
    </p>
</div>

<?php if (($this->session->userdata('switched_from') == 'rtk_manager')) { ?>
            <div id="fixed-topbar" style="position: fixed; top: 104px;background: #708BA5; width: 100%;padding: 7px 1px 0px 13px;border-bottom: 1px solid #ccc;border-bottom: 1px solid #ccc;border-radius: 4px 0px 0px 4px;">
                <span class="lead" style="color: #ccc;">Switch back to RTK Manager</span>
                &nbsp;
                &nbsp;
                <a href="<?php echo base_url() . 'rtk_management/switch_district/0/rtk_manager/0/home_controller/0/'; ?>/" class="btn btn-primary" id="switch_idenity" style="margin-top: -10px;">Go</a>
            </div>
<?php }?>	
		<?php $date = date('F-Y', mktime(0, 0, 0, $month, 1, $year));		                  
              $counter = 0;
        ?>             
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto; margin-top:20px;">
        	 <table class="table" id="reports">
                <thead>
                	<th>Report for</th>
                	<th>MFL Code</td>
                	<th>Facility Name</th>
                	<th>District</th>
                	<th>Reported on</th>
                	<th>Compiled by</th>
                	<th> Action</th>
                </thead>
                <tbody id="">
                	<?php 
                		
                		$count = count($reports);

                		for ($i=0; $i <$count ; $i++) { 

                			foreach ($reports as $value) {
                				$order_date = date('F', strtotime($value[$i]['order_date']));
                				$mfl = $value[$i]['facility_code'];
	                			$facility = $value[$i]['facility_name'];	                			
	                			$district = $value[$i]['district'];
	                			$reported_on = $value[$i]['order_date'];
	                			$compiled_by = $value[$i]['compiled_by'];
	                			$action = base_url() . 'rtk_management/lab_order_details/' . $value[$i]['id'];	                			
	                		?>
	                			<tr>
	                				<td><?php echo $order_date; ?></td>
	                				<td><?php echo $mfl; ?></td>	                				
	                				<td><?php echo $facility; ?></td>	                				
	                				<td><?php echo $district; ?></td>	                				
	                				<td><?php echo $reported_on; ?></td>	                				
	                				<td><?php echo $compiled_by; ?></td>	                				
	                				<td><a href="<?php echo $action; ?>">View</a></td>	                				                				
                				</tr>
	                		
	                		<?php }
	                	}
	                ?>

                		
                </tbody>
            </table>

        </div>
        

    </div>

</div>

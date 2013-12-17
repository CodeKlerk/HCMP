 
<script type="text/javascript" language="javascript" src="http://localhost/HCMP/Scripts/jquery.dataTables.js"></script>


<script type="text/javascript">

    $(document).ready(function() {

        $('#example_mainw').dataTable({
            "bJQueryUI": true,
            "bPaginate": true,
            "aaSorting": [[3, "desc"]]
        });
    });
    var county = <?php echo $this->session->userdata('county_id'); ?>;
    
    $(function () { 
        $("#grapharea").load("./rtk_management/county_reporting_percentages/" + county);
    });
    

    function loadPendingFacilities() {
        $(".dash_main").load("<?php echo base_url(); ?>rtk_management/rtk_reporting_by_county/" + county);
    }
    function loadDistrict() {
        $(".dash_main").load("<?php echo base_url(); ?>rtk_management/reports_in_county/" + county);
    }
    function loadSummary() {
        $(".dash_main").load("<?php echo base_url(); ?>rtk_management/reports_in_county/" + county);
    }

</script>
<br />
<div class="span2 bs-docs-sidebar">
    <ul class="nav nav-tabs nav-stacked">


        <li><a href="<?php echo base_url(); ?>">Summary</a></li>
        <li><a href="#" onclick="loadDistrict()">Districts</a></li>
        <li><a href="#" onclick="loadPendingFacilities()">Pending Facilities</a></li>
        <li><a href="#" onclick="loadSummary()">Reports</a></li>
    </ul>
</div>
<div class="dash_main" style="width: 80%;float: right; overflow: scroll; height: 500px">

    <?php
//echo "<pre>";var_dump($reports);echo "</pre>";
    ?>
        <div id="graphs">
        <script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Nakuru County Reporting Rates'
            },subtitle: {
                text: 'Live data reports on RTK'
            },
            xAxis: {
                categories: <?php echo $graphdata['districts'] ; ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Percentage Complete (%)'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
                series: [{
                name: 'Not reported',
                data: <?php echo $graphdata['nonreported'] ; ?>
            }, {
                name: 'Reported',
                data: <?php echo $graphdata['reported'] ; ?>
            }]
        });
    });
    


    

    </script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    </div>

<?php // $this->load->view('rtk/rca/county_reporting_view');?>
    <table id="example_main" class="data-table">
        <thead>
        <th>Report for</th> 		
        <th>MFL Code</td>
        <th>Facility Name</th>
        <th>District</th>
        <th>Reported on</th>


        <th>Compiled by</th>
        <th> Action</th>
        </thead>
        <tbody>
            <?php
            /*   foreach ($reports as $reports_val) {
              $order_date = date('F', strtotime($reports_val[0]['order_date']));
              echo'<tr>
              <td>' . $order_date . '</td>
              <td>' . $reports_val[0]['facility_code'] . '</td>
              <td>' . $reports_val[0]['facility_name'] . '</td>
              <td>' . $reports_val[0]['district'] . '</td>
              <td>' . $reports_val[0]['order_date'] . '</td>
              <td>' . $reports_val[0]['compiled_by'] . '</td>
              <td><a href="' . base_url() . 'rtk_management/lab_order_details/' . $reports_val[0]['id'] . '">View</a></td>
              <tr>';


              } */echo $tdata;
            ?>
        </tbody>
    </table>

</div>

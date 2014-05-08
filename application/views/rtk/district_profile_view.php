<style type="text/css">
    .row{
        font-size: 13px;
        font-family: calibri;
    }
</style>
<link rel="stylesheet" type="text/css" href="http://tableclothjs.com/assets/css/tablecloth.css">
<script src="http://tableclothjs.com/assets/js/jquery.tablesorter.js"></script>
<script src="http://tableclothjs.com/assets/js/jquery.metadata.js"></script>
<script src="http://tableclothjs.com/assets/js/jquery.tablecloth.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("table").tablecloth({theme: "paper"});
    });

</script>

<div class="row">
<div class="span12">
<ul class="nav nav-pills">

                 <?php foreach ($districts as $key => $value) {
                    echo '<li><a href="'.$value['id'].'">'.$value['district'].'</a></li>';
                 } ?>
               </ul>
    
</div>
</div>

<div class="row">
    <div class="span3">
    <ul class="nav nav-tabs nav-stacked">
                   <li class="nav-header">Menu</li>
<!--          <li><a href="<?php echo base_url() . 'rtk_management/county_profile/' . $county_id; ?>">County: <?php echo $county_name; ?></a></li>-->
            <li class="active"><a href="#">Sub County: <?php echo $district_name; ?></a></li> 
                   <li class="nav-header">Facilities</li>
                 </ul>
                 <div style="height:400px;overflow:scroll;border:1px ridge #ccc" >
                      <?php foreach ($facilities as $key => $value) {
                    echo '<a href="'.base_url().'rtk_management/facility_profile/'.$value['facility_code'].'">'.$value['facility_name'].'</a> <br />';
                 } ?>
                 </div>

                 
 
        <ul class="nav nav-tabs nav-stacked">
         </ul>
    
    </div>

    <div class="span5" style="margin-left: 5px;">
        <dl class="dl-horizontal">
               <dt>Reporting Period</dt>
               <dd><?php echo $district_summary['Month'] .', '.$district_summary['Year']; ?></dd>
               <dt>Facilities</dt>
               <dd><?php echo $district_summary['total_facilities']; ?></dd>
               <dt>Reported (%)</dt>
               <dd>
               <div class="progress progress-success progress-striped"><div class="bar" style="width: <?php echo $district_summary['reported_percentage']; ?>%"><?php echo $district_summary['reported']; ?>(<?php echo $district_summary['reported_percentage']; ?>%)</div></div>
               </dd>
               <dt>Late Reports (%)</dt>
               <dd>
               <div class="progress progress-warning progress-striped"><div class="bar" style="width: <?php echo $district_summary['late_reports_percentage']; ?>%"><?php echo $district_summary['late_reports']; ?>(<?php echo $district_summary['late_reports_percentage']; ?>%)</div></div>
                </dd>
               <dt>Remaining Facilities (%)</dt>
               <dd>
               <div class="progress progress-danger progress-striped"><div class="bar" style="width: <?php echo $district_summary['nonreported_percentage']; ?>%"><?php echo $district_summary['nonreported']; ?>(<?php echo $district_summary['nonreported_percentage']; ?>%)</div></div>
               </dd>
               </dl>
    </div>
    <div class="span4" style="border-left: solid 1px  #ccc;margin-left: 10px;padding-left: 10px;">
        <h3><?php echo $district_name; ?> Sub-County Stock Card</h3>

   <table class="table" style="">
                                <thead>
                                    <tr>
                                        <th>Kit</th>
                                        <th>Beginning Balance</th>
                                        <th>Received Quantity</th>
                                        <th>Used Total</th>
                                        <th>Total Tests</th>
                                        <th>Losses</th>
                                        <th>Closing Balance</th>
                                        <th>Requested</th>
                                        <th>Expiring <br />(6-months)</th>
                                        <th>Days out of stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Determine</td>
                                        <td><?php echo $district_balances_current[0]['sum_opening']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_received']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_used']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_tests']; ?></td>

                                        <td><?php echo $district_balances_current[0]['sum_losses']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_closing_bal']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_requested']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_expiring']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_days']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Unigold</td>
                                        <td><?php echo $district_balances_current[1]['sum_opening']; ?></td>
                                        <td><?php echo $district_balances_current[1]['sum_received']; ?></td>
                                        <td><?php echo $district_balances_current[1]['sum_used']; ?></td>
                                        <td><?php echo $district_balances_current[1]['sum_tests']; ?></td>

                                        <td><?php echo $district_balances_current[1]['sum_losses']; ?></td>
                                        <td><?php echo $district_balances_current[1]['sum_closing_bal']; ?></td>
                                        <td><?php echo $district_balances_current[1]['sum_requested']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_expiring']; ?></td>
                                        <td><?php echo $district_balances_current[0]['sum_days']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
    </div>    
    <div id="chart" style="margin-left:20%;margin-top:260px;height:450px;width:76%;border:1px ridge #ccc;">
      
        
    </div>
    <div class="span8">
        ----
    </div>

</div>
<?php 
  
  
  
 
    $opening_c =  str_replace("\"", " ",json_encode($district_balances_current[0]['sum_opening']));
    $used_c =   str_replace("\"", " ",json_encode($district_balances_current[0]['sum_used']));
    $tests_c =   str_replace("\"", " ",json_encode($district_balances_current[0]['sum_tests']));
    $closing_c =   str_replace("\"", " ",json_encode($district_balances_current[0]['sum_closing_bal']));
    $allocated_c =  str_replace("\"", " ",json_encode($district_balances_current[0]['sum_allocated']));

    $opening_c1 =  str_replace("\"", " ",json_encode($district_balances_previous[0]['sum_opening']));
    $used_c1 =   str_replace("\"", " ",json_encode($district_balances_previous[0]['sum_used']));
    $tests_c1 =   str_replace("\"", " ",json_encode($district_balances_previous[0]['sum_tests']));
    $closing_c1 =   str_replace("\"", " ",json_encode($district_balances_previous[0]['sum_closing_bal']));
    $allocated_c1 =  str_replace("\"", " ",json_encode($district_balances_previous[0]['sum_allocated']));

    $opening_c2 =  str_replace("\"", " ",json_encode($district_balances_previous_2[0]['sum_opening']));
    $used_c2 =   str_replace("\"", " ",json_encode($district_balances_previous_2[0]['sum_used']));
    $tests_c2 =   str_replace("\"", " ",json_encode($district_balances_previous_2[0]['sum_tests']));
    $closing_c2 =   str_replace("\"", " ",json_encode($district_balances_previous_2[0]['sum_closing_bal']));
    $allocated_c2 =  str_replace("\"", " ",json_encode($district_balances_previous_2[0]['sum_allocated']));

    $first_month =  str_replace("\"", " ",json_encode($months[0]));
    $second_month =  str_replace("\"", " ",json_encode($months[1]));
    $third_month =  str_replace("\"", " ",json_encode($months[2]));


  ?>

  <script type="text/javascript">
$(function () {
  
   $('#chart').highcharts({
        title: {
            text: 'District Monthly Summaries'
        },
        xAxis: {
            categories: ['Begining Balance',  'Used Total', 'Total Tests', 'Closing Balance' ,'Allocated']           
        },
        labels: {
            items: [{
                html: 'Total Determine Consumption',
                style: {
                    left: '50px',
                    top: '18px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: '<?php echo $first_month ;?>',
            data:[<?php echo $opening_c2 ?>,<?php echo $used_c2 ?>, <?php echo $tests_c2 ?>, <?php echo $closing_c2 ?>, <?php echo $allocated_c2 ?>]           
        }, {
            type: 'column',
            name: '<?php echo $second_month ?>',
            data:[<?php echo $opening_c1 ?>,<?php echo $used_c1 ?>, <?php echo $tests_c1 ?>, <?php echo $closing_c1 ?>, <?php echo $allocated_c1 ?>]
            
        }, {
            type: 'column',
            name: '<?php echo $third_month ?>',
            //data:[45,98,25,19,8]
            data:[<?php echo $opening_c ?>,<?php echo $used_c ?>, <?php echo $tests_c ?>, <?php echo $closing_c ?>, <?php echo $allocated_c ?>]                     
        }, ]
    });
});
</script>
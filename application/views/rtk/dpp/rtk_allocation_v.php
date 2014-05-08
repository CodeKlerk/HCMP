<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
<style type="text/css" title="currentStyle">

    @import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
    #main-allocation-side-nav{
        
        width: 200px;
        height: 400px;
        margin-top: 50px;
    }
    #main-content-allocations{
        
        width: 100%;
    }
    .allocation_minibar{
        width: 200px;
    }
    #notification{
        float: left;
    }
</style>
<script type="text/javascript">
    $(function() {
        //tabs
        $('#tabs').tabs();
 $('#example').dataTable({
            "bJQueryUI": true,
            "bPaginate": true,
            "aaSorting": [[3, "asc"]]
        });
    });

</script>

<?php
$district = $this->session->userdata('district1');
$district_name = Districts::get_district_name($district)->toArray();
$d_name = $district_name[0]['district'];
?>
<div id="notification">View all Allocations for <?php echo $d_name; ?> district below</div><br>
<!--div id="main-allocation-side-nav">    
        <p class="allocation_minibar" id="dpp_stats"><a href="#" style="margin: 0;  padding: 5%;  height: 15px;  border-top: #f0f0f0 1px solid;  background: #cccccc;  font: normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;  text-decoration: none;  text-transform: uppercase;  background: #29527b;  border-radius: 0.5em;  color: #fff;">Statistics</a></p>
        <p class="allocation_minibar"><a href="<?php //echo site_url('rtk_management/rtk_orders'); ?>" style="margin: 0;  padding: 5%;  height: 15px;  border-top: #f0f0f0 1px solid;  background: #cccccc;  font: normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;  text-decoration: none;  text-transform: uppercase;  background: #29527b;  border-radius: 0.5em;  color: #fff;">Orders</a></p>
        <p class="allocation_minibar"><a href="<?php // echo site_url('rtk_management/rtk_allocation'); ?>" style="margin: 0;  padding: 5%;  height: 15px;  border-top: #f0f0f0 1px solid;  background: #cccccc;  font: normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;  text-decoration: none;  text-transform: uppercase;  background: #29527b;  border-radius: 0.5em;  color: #fff;">Allocation</a></p>
    
</div-->
<div id="main-content-allocations"> 
    <div id="tab-1">
<?php if (count($lab_order_list) > 0) : ?>
            <table width="100%" id="example" class="data-table">
                <thead>
                    <th><b>Month</b></th>
                    <th><b>MFL Code</b></th>
                    <th><b>Facility Name</b></th>
                    <th><b>Commodity</b></th>
                    <th><b>(AMC)</b></th> 
                    <th><b>End Balance</b></th>
                    <th><b>Quantity Requested</b></th>
                    <th><b>Quantity Allocated</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($lab_order_list as $order) {
                        //$english_date = date('D dS M Y',strtotime($order['order_date']));
                        //$reportmonth = date('F',strtotime('-1 month',strtotime($order['order_date'])));                       
                        $my_amc = $amc[$count];                  

                    ?>
                        <tr>
                            <td><?php echo $month;?></td>
                            <td><?php echo $order['facility_code'];?></td>
                            <td><?php echo $order['facility_name'];?></td>
                            <td><?php echo $order['commodity_name'];?></td>
                            <td><?php echo $my_amc;?></td>
                            <td><?php echo $order['closing_stock'];?></td>
                            <td><?php echo $order['q_requested'];?></td>
                            <td><?php echo $order['allocated'];?></td>
                        </tr>
                        
                        <?php
                         $count++;
                    }
                    ?>
                </tbody>
            </table>
            <?php
        else :?>
            <table width="100%" id="example_2" class="data-table">
                <thead>
                    <th><b>MFL Code</b></th>
                    <th><b>Facility Name</b></th>
                    <th><b>Commodity</b></th>
                    <th><b>(AMC)</b></th> 
                    <th><b>End Balance</b></th>
                    <th><b>Quantity Requested</b></th>
                    <th><b>Quantity Allocated</b></th>
                    </tr>
                </thead>
                <tbody>                   
                    <tr><td colspan="7"><center>No Records Found</center></td></tr>
                      
                </tbody>
            </table>
        <?php endif;
        ?>

    </div>
  

</div>



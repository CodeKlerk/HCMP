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
<script src="<?php echo base_url() . 'Scripts/accordion.js' ?>" type="text/javascript"></script>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url(); ?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT> 
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
<style type="text/css" title="currentStyle">

    @import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";


</style>
<script type="text/javascript">

    $(document).ready(function() {

        $('#example_main').dataTable({
            "bPaginate": false,
            "aaSorting": [[3, "asc"]]
        });
        $.fn.slideFadeToggle = function(speed, easing, callback) {
            return this.animate({
                opacity: 'toggle',
                height: 'toggle'
            }, speed, easing, callback);
        };


        //       $(".alert").fadeIn(400);
        $(".alert").delay(20000).slideUp(1000);
        $("#tablediv").delay(15000).css("height", '450px');
        $(".dataTables_filter").delay(15000).css("color", '#ccc');




        $("#dpp_stats").click(function(event)
        {
            $(".dataTables_wrapper").load("<?php echo base_url(); ?>rtk_management/summary_tab_display/" + <?php echo $countyid; ?> + "/<?php echo $year; ?>/<?php echo $month; ?>/");

        });
    });

    function loadcountysummary(county) {
//            $(".dash_main").load("http://localhost/HCMP/rtk_management/rtk_reporting_by_county/" + county);
    }

</script>


<style>
    .leftpanel{
        width: 17%;
        height:auto;
        float: left;
    }

    .alerts{
        width:95%;
        height:auto;
        background: #E3E4FA;  
        padding-bottom: 2px;
        padding-left: 2px;
        margin-left:0.5em;
        -webkit-box-shadow: 0 8px 6px -6px black;
        -moz-box-shadow: 0 8px 6px -6px black;
        box-shadow: 0 8px 6px -6px black;

    }

    .dash_menu{
        width: 100%;
        float: left;
        height:auto; 
        -webkit-box-shadow: 2px 3px 5px#888;
        box-shadow: 2px 3px 5px #888; 
        margin-bottom:3.2em; 
    }

    .dash_main{
        width: 82%;       
        height:500px;
        float: left;
        margin-left:0.75em;
        margin-bottom:0em;
    }
    .dash_notify{
        width: 15.85%;
        float: left;
        padding-left: 2px;
        height:450px;
        margin-left:8px;
        -webkit-box-shadow: 2px 2px 6px #888;
        box-shadow: 2px 2px 6px #888;

    }

    div.container {
        width:auto;
        height:auto;
        padding:0;
        margin:0; }
    div.content {
        background:#f0f0f0;
        margin: 0;
        padding:10px;
        font-size:.9em;
        line-height:1.5em;
        font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif; }
    div.content ul, div.content p {
        padding:0;
        margin:0;
        padding:3px; }
    div.content ul li {
        list-style-position:inside;
        line-height:25px; }
    div.content ul li a {
        color:#555555; }
    code {
        overflow:auto; }

</style>

<script type="text/javascript">

    $(function() {

        $('#switch_district').change(function() {
            var value = $('#switch_district').val();
            var path = "<?php echo base_url() . 'rtk_management/switch_district/'; ?>" + value + "/dpp";
//              alert (path);
            window.location.href = path;
        });
    });
</script>



<?php
if ($this->session->userdata('switched_as') == 'dpp') {
    ?>
    <div id="fixed-topbar" style="position: fixed; top: 104px;background: #708BA5; width: 100%;padding: 7px 1px 0px 13px;border-bottom: 1px solid #ccc;border-bottom: 1px solid #ccc;border-radius: 4px 0px 0px 4px;">
        <span class="lead" style="color: #ccc;">Switch back to RTK Manager</span>
        &nbsp;
        &nbsp;
        <a href="<?php echo base_url(); ?>rtk_management/switch_district/0/rtk_manager/0/home_controller/0//" class="btn btn-primary" id="switch_idenity" style="margin-top: -10px;">Go</a>
    </div>

<?php }
?>
<div class="leftpanel">

    <!--   <div class="dash_menu">
  
          <h3 class="accordion" >Reports <span></span><h3>
                 <div class="container">
  
                      <div class="content">
                          <select id="facilities" class="dropdownsize">
                              <option>--Select Facility--</option>
    <?php
    foreach ($facilities as $counties) {
        $facility_code = $counties['facility_code'];
        $facility_name = $counties['facility_name'];
        ?>
                                                                  <option value="<?php echo $facility_code . '|' . $facility_name ?>"><?php echo $facility_name; ?></option>
    <?php }
    ?>
                          </select>   
                          <input  type="hidden"  name="facilities" id="facilities" value="<?php echo $facility_name; ?>" />
  
                          <select id="report" class="dropdownsize">
                              <option>--Select Report--</option>
                              <option value="fcdrr">FCDRR</option>
                              <option value="lab">LAB COMMODITIES</option>
  
                          </select>   
                          <input  type="hidden"  type="submit" value="Submit" />
  
                          <h2>Select Month</h2>
                          <select id="month" class="dropdownsize" placeholder="Month">
                              <option value="01">January</option>
                              <option value="02">February</option>
                              <option value="03">March</option>
                              <option value="04">April</option>
                              <option value="05">May</option>
                              <option value="06">June</option>
                              <option value="07">July</option>
                              <option value="08">August</option>
                              <option value="09">September</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="12">December</option>
                          </select>
  
                          <h2>Select Year</h2>
                          <select id="year" class="dropdownsize" placeholder="Year">
    <?php
    $this_year = date('Y');

    for ($i = 0; $i < 5; $i++) {
        ?>
                                                                  <option value="<?php echo $this_year - $i; ?>"><?php echo $this_year - $i; ?></option>
    <?php } ?>
                          </select>
                          <a href="<?php echo base_url() . 'rtk_management/view_report' ?>"><button class="awesome blue" id="generate" style="margin-left:30%" align="left">Generate Report</button></a>
                      </div>
                  </div>
    -->


    <!--
                    <h3 class="accordion" >Statistics<span></span><h3>
                            <div class="container">
    
    
                            </div>
    
    
                            </div>
    -->

    <div class="sidebar">
        <a href="<?php echo site_url('rtk_management/rtk_orders'); ?>">&nbsp;</a>


        <nav class="sidenav">
            <?php
            $option = '';
            $id = $this->session->userdata('user_id');
            $q = 'SELECT * from dmlt_districts,districts 
where dmlt_districts.district=districts.id
and dmlt_districts.dmlt=' . $id;
            $res = $this->db->query($q);
            foreach ($res->result_array() as $key => $value) {
                $option .= '<option value = "' . $value['id'] . '">' . $value['district'] . '</option>';
            }
            ?>

            <span style="
                  font-size: 19px;
                  text-transform: uppercase;
                  font-style: oblique;
                  font-family: calibri;
                  " class="label label-info">Switch districts</span>
            <br />

            <select id="switch_district">
                <option>-- Select District --</option>
                <?php echo $option; ?>
            </select>
            <br />
            <ul>
                <li class="orders_minibar" id="dpp_stats"><a href="#" style="margin: 0;  padding: 5%;  height: 15px;  border-top: #f0f0f0 1px solid;  background: #cccccc;  font: normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;  text-decoration: none;  text-transform: uppercase;  background: #29527b;  border-radius: 0.5em;  color: #fff;">Statistics</a></li>
                <li class="orders_minibar"><a href="<?php echo site_url('rtk_management/rtk_orders'); ?>" style="margin: 0;  padding: 5%;  height: 15px;  border-top: #f0f0f0 1px solid;  background: #cccccc;  font: normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;  text-decoration: none;  text-transform: uppercase;  background: #29527b;  border-radius: 0.5em;  color: #fff;">Orders</a></li>
                <li class="orders_minibar"><a href="<?php echo site_url('rtk_management/rtk_allocation'); ?>" style="margin: 0;  padding: 5%;  height: 15px;  border-top: #f0f0f0 1px solid;  background: #cccccc;  font: normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;  text-decoration: none;  text-transform: uppercase;  background: #29527b;  border-radius: 0.5em;  color: #fff;">Allocation</a></li>
            </ul>
        </nav>
    </div>

</div>

<div class="dash_main" id = "dash_main">
    <div style="font-size: 13px;">
        <?php
        $district = $this->session->userdata('district1');
        $district_name = Districts::get_district_name($district)->toArray();
        $d_name = $district_name[0]['district'];
        ?>
        <br />
        <!-- Report Progress-->
        <?php
        $progress_class = " ";
        if ($percentage_complete < 100) {
            $progress_class = 'success';
        }
        if ($percentage_complete < 75) {
            $progress_class = 'info';
        }
        if ($percentage_complete < 50) {
            $progress_class = 'warning';
        }
        if ($percentage_complete < 25) {
            $progress_class = 'danger';
        }
        ?>


        <?php
        $alertype = '';
        $alertmsg = '';
        $date = date('d', time());
        $lastmonth = date('F', strtotime("last day of previous month"));
        $thismonth = date('F', strtotime("this month"));
        $nextmonth = date('F', strtotime("next month"));
        $remainingdays = 12 - $date;
        $remainingpercentage = 100 - $percentage_complete;

        // first reminder between 1st and 6th which should just tell DMLT to report.
        if ($date < 7) {
            $alertmsg = '<strong>Take note: ' . $d_name . ' District</strong><br /><br />
                                        Reporting for ' . $lastmonth . ' is on,<br > Click on <u>Report</u> for all Facilities with the red label
                                        after this label within the table below<br > <span class="label label-important">  Pending for ' . $lastmonth . '</span>';
            $alertype = 'warning';
            if ($percentage_complete == 100) {
                $alertype = 'success';
                $alertmsg = '<i aria-hidden="true" class="icon-thumbs-up"> </i><strong> Congratulations !</strong> <br /><br />
                                        You have reported for all facilities in your district in record time.<br /><br />
                                        You have ' . $remainingdays . ' days to cross-check and edit your reports';
//                                        You will be allowed to begin reporting for ' . $lastmonth . ' as from 25th of ' . $thismonth . '';
            }
        }
        // Final reminder between 7th and 12th to indicate that the end is in sight
        if ($date > 6 && $date < 12) {
            $alertmsg = '<br /> Reporting period is almost over. <br />
                                    You have ' . $remainingdays . ' days to fill in the remaining ' . $nonreported . ' Facilities (' . $remainingpercentage . '%)';
            $alertype = 'error';
            if ($percentage_complete == 100) {
                $alertype = 'success';
                $alertmsg = '<i aria-hidden="true" class="icon-thumbs-up"> </i><strong> Congratulations !</strong> <br /><br />
                                        You have already reported for all facilities in your district. <br /><br />
                                        You have ' . $remainingdays . ' days to cross-check and edit your reports';
//                                        You will be allowed to begin reporting for ' . $lastmonth . ' as from 25th of ' . $thismonth . '';
            }
        }
        // Checks for out of reporting period and alerts
        if ($date > 12) {
            $alertmsg = 'Reporting period over, you have been locked out of reporting';
            $alertype = 'error';
            if ($percentage_complete == 100) {
                $alertype = 'success';
                $alertmsg = '<strong>Congratulations !</strong> Reporting period over, All your reports have been submitted <br /> You will be allowed to begin reporting for ' . $thismonth . ' as from 1st of ' . $nextmonth . '';
            }
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    //                    $(".dataTables_wrapper").load("<?php echo base_url(); ?>rtk_management/summary_tab_display/" + <?php echo $countyid; ?> + "/<?php echo $year; ?>/<?php echo $month; ?>/");
                });
            </script>
            <?php
        }
        if (isset($notif_message)) {
            if ($notif_message != '') {
                $alertype = "error";
                echo '<div class="alert alert-success">' . $notif_message . ' </div>';
            }
        }
        echo '<div class="alert alert-' . $alertype . '">' . $alertmsg . ' </div>';
        ?>
    </div>
    <div id="tablediv" style="height:350px; overflow:scroll;">
        <table  style="margin-left: 0;" id="example_main" width="100%" >
            <thead>
                <tr>
                    <th><b>MFL Code</b></th>
                    <th><b>Facility Name</b></th>
                    <th><b>District</b></th>
                    <th ><b>FCDRR Reports</b></th> 

                </tr>
            </thead>
            <tbody id="facilities_home">
                <?php echo $table_body; ?>
            </tbody>            
        </table>

    </div>
</div>
<div style="position:fixed; bottom: 0;margin-bottom: 22px;width: 100%;font-size: 152%; background: #fff;">
    <span>Reports Progress: <?php echo $percentage_complete; ?>% </span>
    <div class="progress progress-<?php echo $progress_class; ?>" style="height: 10px;">
        <div class="bar" style="width: <?php echo $percentage_complete; ?>%"></div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="http://tableclothjs.com/assets/css/tablecloth.css">


<script src="http://tableclothjs.com/assets/js/jquery.tablesorter.js"></script>
<script src="http://tableclothjs.com/assets/js/jquery.metadata.js"></script>
<script src="http://tableclothjs.com/assets/js/jquery.tablecloth.js"></script>
<script type="text/javascript">
                $(document).ready(function() {
                    $("table").tablecloth({theme: "paper"});
                });


</script>
</div>
</div>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
<script src="http://tableclothjs.com/assets/js/jquery.tablecloth.js"></script>


<script type="text/javascript">

    $(document).ready(function() {
        /* Build the DataTable with third column using our custom sort functions */

        $('#example').dataTable({
            "bStateSave": true,
            "iDisplayLength": 10,
            "aaSorting": [[11, "desc"]],
            "bPaginate": false,
        });

        $("#allocate").button().click(function() {
        	var loading = '<div id="loading"> &nbsp;&nbsp;<img src="<?php echo base_url(); ?>Images/ajax-loader.gif"><span style="font-size: 13px;color: #92CA8F;font-family: calibri;">Saving Allocations</span></div>';
        	$('#system_alerts').html(loading);
      	

            var data = $('#myform').serialize();
            $.post(
                    '../rtk_allocation_data/',
                    {data: data},
            function(response) {
                $('#system_alerts').html(response);
                $('#system_alerts').addClass('alert alert-success');
               location.reload(true);
//                $( "#loading" ).hide();
            }
            );


        });

        $('.nav li a').click(function(e) {
            var $this = $(this);
            var thistext = $(this).text();
            $('.nav li').removeClass('active');
            $this.parent().addClass('active');
            $(".dataTables_filter label input").focus();
            $('.dataTables_filter label input').val(thistext).trigger($.Event("keyup", {keyCode: 13}));

            e.preventDefault();
        });
        $("table").tablecloth({theme: "paper"});


    });
</script>

<style>
    @import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
    @import "http://tableclothjs.com/assets/css/tablecloth.css";

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
    .user2{
        width: 40px;
    }
    #example{
        width: 100% !important;
    }    
    .nav{
        margin-bottom: 0px;
    } 
</style> 
<div style="width:100%;font-size: 15px;background: #F8F8F8;padding: 10px 10px 10px 10px;border-bottom: solid 1px #ccc;">
    <ul class="nav nav-pills">

        <?php foreach ($districts_in_county as $value) { ?>
            <li class=""><a href="#"><?php echo $value['district']; ?></a></li>
        <?php } ?>
            <li class="disabled" style=""><a href="#">&nbsp;</a></li>     
            <li class="disabled" style="border-left: solid 0.1em #ccc;"><a href="#">&nbsp;</a></li>

            <li class=""><a href="#">Tie Breaker</a></li>
            <li class=""><a href="#">Confirmatory</a></li>
            <li class=""><a href="#">Screening</a></li>
<!--            <li class="pull-right"><a href="#">View last Allocation</a></li>-->

    </ul>
</div>
<div style="height:411px;overflow:scroll;">
    <?php
    $attributes = array('name' => 'myform', 'id' => 'myform');
    echo form_open('rtk_management/rtk_allocation_data/' . $county_id, $attributes);
    ?>
    <table id="example">
        <thead>
            <tr>
                <th colspan="3">Facility Details</th>
                <th rowspan="2"><b>Commodity</b></th>
                <th colspan="2">Quantity</th>
                <th colspan="2">Quantity</th>
                <th rowspan="2"><b>AMC</b></th>
                <th rowspan="2"><b>Qty to allocate</b></th>
                <th rowspan="2"><b>Qty Issued<br />(From KEMSA)</b></th>
                <th rowspan="2"><b>Status</b></th>
            </tr>
            <tr>
                <th><b>MFL</b></th>
                <th><b>Facility Name</b></th>
                <th><b>District</b></th>
                <th><b>Received</b></th>
                <th><b> Consumed</b></th>
                <th><b>End balance<br />Physical Count</b></th>
                <th><b>Qty Requested <br />for Re-Supply</b></th>
            </tr>
        </thead>
        <tbody><?php echo $table_body; ?></tbody>
    </table>
    <br />
<div id="clear">&nbsp;</div>
    <div>
<input type="button" id="allocate" value="Allocate" style="background: #F8F7F7; padding: 7px;margin: 8px 0px 5px 19px;color: #0088cc;font-family: calibri;font-size: 18px;border: 1px solid #ccc;">

</div>
<?php echo form_close(); ?>	
</div>
 
<?php 

$dist = array();
$json_dist = "";

foreach ($districts as $districts_arr) {
  $id = $districts_arr['id'];
  $district = $districts_arr['district'];

$district_arr = array($id => $district);
array_push($dist, $districts_arr);
//array_push($dist, $id);


}

$json_dist = json_encode($dist);
$json_dist = substr($json_dist,0, -1);
$json_dist = substr($json_dist, 1);
$json_dist = str_replace('"', "'", $json_dist);
$json_dist = str_replace('{', "", $json_dist);
$json_dist = str_replace('}', "", $json_dist);
//echo $json_dist;

//{"199":"Gilgil"},{"200":"Kuresoi"},{"201":"Molo"},{"202":"Naivasha"},{"203":"Nakuru"},{"204":"Nakuru North"},{"205":"Njoro"},{"206":"Rongai"},{"207":"Subukia"}]
?>
<style>
#facilities_tlb_paginate{
font-size: 13px;
float: right;
padding:4px;
}
#facilities_tlb_info{
font-size: 15px; 
float: left;
}
#facilities_tlb_length{
  float: left;
}
#facilities_tlb_filter{
  float: right;
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
          customClass: "data-table"
        });

        
    });
</script>
<script type="text/javascript">
  $(document).ready( function () {
   $('#facilities_tlb').dataTable(); 

// functions may apply here
function update_rtk(val){
  alert(val);
}

  })
</script>


<!-- Button to trigger modal -->
<a href="#Add_Facility" role="button" class="btn" data-toggle="modal">Add Facility</a>
<hr />

<!-- Modal -->
<div id="Add_Facility" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3 id="myModalLabel">Add Facility</h3>

    </div>
    <div class="modal-body">
        <p></p>
        <form id="add_facility_form"> 
            <div class="modal-body">
                            <h4>Facility Name: </h4>
                            <form id="add_facility" method="POST" action="">
                            <p> <input type="text" name="facilityname" id="facilityname" /></p>
                            <h4>Facility MFL Code: </h4>
                            <p> <input type="text" name="facilitycode" id="facilitycode" /></p>
                            <h4>Facility Owner: </h4>
                            <p> <input type="text" name="facilityowner" id="facilityowner" /></p>
                            <h4>Facility type: </h4>
                            <p> <input type="text" name="facilitytype" id="facilitytype" /></p>

                            <select name="district" id="district">
                              <option> -- Select District --</option>
                              <?php foreach ($districts as $dists) { ?>
                              <option value="<?php echo $dists['id']; ?>"><?php echo $dists['district']; ?></option>
                              <?php }?>
                            </select>
                            <hr>
                        </div>
        </form>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button id="save_facility" class="btn btn-primary">Save changes</button>
    </div>
</div>

<table class="data-table" id="facilities_tlb">

  <thead>
<th>MFL Code</th>
    <th>Name</th>
    <th>Owner</th>
    <th>County</th>
    <th>District</th>
    <th>Reporting Status</th>
   </thead>
  <tbody>
<?php foreach ($facilities as $row) { 
   $code =$row['facility_code'];
   ?>
    <tr id="<?php echo $row['facil_id'];?>">    
    <td><?php echo '<a href="../../rtk_management/facility_profile/' . $code. '" title="View">'.$code.'</a>' ?></td>
    <td><?php echo $row['facility_name'];?></td>
    <td><?php echo $row['owner'];?></td>
    <td><?php echo $county;?></td>    
    <td><?php echo $row['districtname'];?></td>
    <td><?php if($row['rtk_enabled']==0)
    {

      echo "Non-Reporting";
      echo ' <a href="../../rtk_management/activate_facility/' . $row['facility_code'] . '" title="Add"><i class="icon-plus-sign"> </i></a>';


    }
    else
      {
        echo "Reporting";
        echo ' <a href="../../rtk_management/deactivate_facility/' . $row['facility_code'] . '" title="Remove"><i class="icon-minus-sign"> </i></a>';
      }?></td>
  </tr>
  <?php }?>
  </tbody>

</table>
<script type="text/javascript">
   $(function(){

    $('#save_facility').click(function(){
      var facilityname = $('#facilityname').val();
      var facilitycode = $('#facilitycode').val();
      var facilityowner = $('#facilityowner').val();
      var facilitytype = $('#facilitytype').val();
      var district = $('#district').val();

      $.post( "<?php echo base_url().'rtk_management/create_facility_county';?>", { 
        facilityname: facilityname,
        facilitycode: facilitycode,
        facilityowner: facilityowner,
        facilitytype: facilitytype,
        district: district
      })
  .done(function( data ) {   
$('#Add_DMLT').modal('hide');
window.location = "<?php echo base_url().'rtk_management/county_admin/facilities';?>";
  });
      


})

   });
</script>
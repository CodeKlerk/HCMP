<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
<script type="text/javascript">

<?php
$this->load->database();
$q = 'SELECT id,county FROM  `counties` ORDER BY  `counties`.`county` ASC ';
$res_arr = $this->db->query($q);
$counties_option_html="";
foreach ($res_arr->result_array() as  $value) {
  $counties_option_html .='<option value="'.$value['id'].'">'.$value['county'].'</option>';
}
$districts_option_html = "";
$q1 = 'SELECT id,district,county FROM  `districts` ORDER BY  `districts`.`district` ASC ';
$res_arr1 = $this->db->query($q1);
foreach ($res_arr1->result_array() as  $value) {
  $districts_option_html .='<option county="'.$value['county'].'" value="'.$value['id'].'">'.$value['district'].'</option>';
}
?>
     $(document).ready(function() {

        $('#users').dataTable({
          "bJQueryUI": true,
            "bPaginate": true
        });
$('#add_user').click(function(){
$('#user_add_form').submit();
});

$('#county_add').click(function(){
  var data_id = $(this).data('id');
  alert(data_id);
  $('$county_text').val(data_id);
});



      });
</script>
<style type="text/css">
  .dataTables_wrapper{
    margin-left: 16px;
    font-size: 11.5px;
    background: #FFFFEC;
    padding: 12px;
  }
  .dataTables_filter{
    float: right;
  }
  #users_length{
    float: left;
  }
  #users{
    width: 100%; 
  }
  #users_paginate{
    float: right;
  }
</style>
<div class="tabbable tabs-left" style="font-size:117%;">
                 <ul class="nav nav-tabs">
                   <li class="active"><a href="#lA" data-toggle="tab">Users</a></li>
<!--                   <li class=""><a href="#lB" data-toggle="tab">Facilities</a></li>
                   <li class=""><a href="#lC" data-toggle="tab">Section 3</a></li>-->
                 </ul>
                 <div class="tab-content">
                   <div class="tab-pane active" id="lA">
                   <h3>Users</h3>
   
   <a href="#Add_DMLT" role="button" class="btn" data-toggle="modal" style="margin-left: 15px;">Add user</a>

   <div id="Add_DMLT" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3 id="myModalLabel">Add User</h3>

    </div>
    <div class="modal-body">
       <form id="user_add_form" method="POST" action="<?php echo base_url();?>rtk_management/adduser" title="Add User">

                            <label for="FirstName">First Name</label><br />
                            <input type="text" name="FirstName" rel="1" required/><br />

                            <label for="Lastname">Last Name</label><br />
                            <input type="text" name="Lastname" rel="2" required/><br />

                            <label for="email">Email</label><br />
                            <input type="text" name="email" rel="3" required/><br />
                            <select name="level" rel="0">
                              <option value="0">-- select user level --</option>
                              <option value="13">County Admin</option>
                              <option value="12">DMLT</option>
                            </select>
                            <br />
                            <select name="county" rel="5">
                              <option value="0">-- select County --</option>
                              <?php echo $counties_option_html;?>

                            </select>
                            <br />
                            <select name="district" rel="4">
                              <option value="0">-- select District --</option>
                              <?php echo $districts_option_html;?>
                            </select>
                        </form>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button id="add_user" class="btn btn-primary">Save changes</button>
    </div>
</div>



<div id="AddCounty" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3 id="myModalLabel">Add County</h3>

    </div>
    <div class="modal-body">
       <form id="user_add_form" method="POST" action="<?php echo base_url();?>rtk_management/adduser" title="Add User">

                            <label for="FirstName">First Name</label><br />
                            <input id="county_text" type="text" name="FirstName" rel="1" value="" required/><br />

                    
                        
                            <br />
                            <select name="county" rel="5">
                              <option value="0">-- select County --</option>
                              <?php echo $counties_option_html;?>

                            </select>
                        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button id="add_county" class="btn btn-primary">Save changes</button>
    </div>
</div>

                       
                   <table class="" id="users">
                     <thead style="text-align:left; font-size:13px; font-style:bold;">
                       <th>First Name</th>
                       <th>Last Name</th>
                       <th>email</th>
                       <th>User Level</th>
                       <th>district</th>
                       <th>county</th>
                       <th>Delete</th>
                     </thead>
                     <tbody style="border-top: solid 1px #828274;">
<?php foreach ($users as  $value) {
  if ($value['level']=='dpp'){
    $value['level']='Sub-county admin';
    } ?>  

<tr>
<td><?php echo $value['fname']; ?></td>
<td><?php echo $value['lname']; ?></td>
<td><?php echo $value['email']; ?></td>
<td><?php echo $value['level']; ?></td>
<td><?php  if ( $value['level']=='rtkcountyadmin'){
     echo 'Not Applicable';
     }
     else 
      {
        echo $value['district'];
        }?></td>
<td><?php echo $value['county']; ?> 
<?php if ( $value['level']=='rtkcountyadmin'){echo '<a id="county_add" href="#AddCounty"  data-toggle="modal" data-id="'.$value['user_id'].'">add</a>';}?>
<span id="morecounties_<?php echo $value['user_id']; ?>"></span></td>
<td><a style="color:red;" title="Delete user" href="<?php echo base_url().'rtk_management/delete_user_gen/'.$value['user_id'].'/rtk_manager';?>">[x]</a></td>
</tr>
<?php }?></tbody>
                   </table>

                   </div>
                   <div class="tab-pane" id="lB">
                     <p>Howdy, I'm in Section B.</p>
                   </div>
                   <div class="tab-pane" id="lC">
                     <p>What up girl, this is Section C.</p>
                   </div>
                 </div>
               </div>
 <script type="text/javascript">
                $(function(){
                  $( "#morecounties<?php echo $value['id']; ?>" ).load( "<?php echo base_url();?>rtk_management/show_rca_counties/<?php echo $value['user_id']; ?>" );
                });
                </script>
               
<!-- Button to trigger modal -->
<a href="#Add_DMLT" role="button" class="btn" data-toggle="modal">Add DMLT</a>
<hr />

<!-- Modal -->
<div id="Add_DMLT" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3 id="myModalLabel">Add DMLT</h3>

    </div>
    <div class="modal-body">
        <p></p>
        <form id="add_dmlt_form"> 
            <table>
                <tr>    
                    <td>First Name</td>
                    <td><input id="first_name" type="text" name="first_name" /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input id="last_name" type="text" name="last_name" /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input id="email" type="text" name="email" /></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><input id="phone" type="text" name="phone" />
                        <input id="county" type="hidden" name="county" value="<?php echo $countyid; ?>" /></td>
                </tr>
                <tr>
                    <td>District</td>
                    <td>
                        <select id="district">
                            <option> -- Select Sub County --</option>
                            <?php foreach ($districts as $dists) { ?>
                                <option value="<?php echo $dists['id']; ?>"><?php echo$dists['district']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button id="save_dmlt" class="btn btn-primary">Save changes</button>
    </div>
</div>

<table class="data-table">
    <thead>
    <th style="width: 10px;"></th>
    <th>Name</th>
    <th>email</th>
    <th>Phone</th>

    <th>Main Sub County</th>
    <th>Other Sub Counties</th>

<!--		<th>Action</th>-->
</thead>
<tbody>
    <?php foreach ($users as $row) { ?>
        <tr>
            <td><a href="<?php echo '../delete_user/'.$row['id'].'/'.$row['district_id'].'/county_user'; ?>" title="Delete <?php echo $row['fname'] . ' ' . $row['lname']; ?>"><span style="color: #DD6A6A;">[x]</span></a></td>

            <td><a href="#user_<?php echo $row['id']; ?>"><?php echo $row['fname'] . ' ' . $row['lname']; ?></a></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['telephone']; ?></td>
            <td><?php echo $row['district']; ?></td>
            <td>
                <a href="#dmlt_district_<?php echo $row['id']; ?>" role="button"  data-toggle="modal">add  Sub-County</a>
                <div id="districts_dmlt_<?php echo $row['id']; ?>"> </div>
                <script type="text/javascript">
                $(function(){
                  $( "#districts_dmlt_<?php echo $row['id']; ?>" ).load( "<?php echo base_url();?>rtk_management/show_dmlt_districts/<?php echo $row['id']; ?>" );
                });
                </script>

                <div id="dmlt_district_<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                    <div class="modal-body">
                        <h2 id="myModalLabel"> Add  Subcounty to <?php echo $row['fname'] . ' ' . $row['lname']; ?></h2>
                        <hr />
                        <form id="add_dmlt_district_form" method="POST" action="<?php echo base_url() . 'rtk_management/dmlt_district_action'; ?>">
                            
                            <input name="dmlt_id" id="dmlt_id" type="hidden" value="<?php echo $row['id']; ?>"/>
                            <input name="action" id="action" type="hidden" value="add"/>
                            
                            <select name="dmlt_district" id="dmlt_district">
                                <option> -- Select District --</option>
                                <?php foreach ($districts as $dists) { ?>
                                    <option value="<?php echo $dists['id']; ?>"><?php echo $dists['district']; ?></option>
                                <?php } ?>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <input id="add_dmlt_district" type="submit" class="btn btn-primary" value="Save changes"/>
                        </form>
                    </div>

                </div>
            </td>
        </tr>
    <?php } ?>
</tbody>
</table>

<?php
/*
  echo "<pre>";
  print_r($users);
  echo "</pre>";
 */
?>
<script type="text/javascript">
    $(function() {
        $('#save_dmlt').click(function() {
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();
            var district = $('#district').val();
            var county = $('#county').val();
            var email = $('#email').val();

            $.post("<?php echo base_url() . 'rtk_management/create_DMLT'; ?>", {
                first_name: first_name,
                last_name: last_name,
                email: email,
                phone: phone,
                district: district,
                county: county
            }).done(function(data) {
                alert("Data Loaded: " + data);
                $('#Add_DMLT').modal('hide');
                window.location = "<?php echo base_url() . 'rtk_management/county_admin/users'; ?>";
            });
        });
        /*
         $('#add_dmlt_district').click(function() {
         var dmlt_id = $(this).closest('div: #dmlt_id').val();
         var dmlt_district = $(this).closest('div: #dmlt_district').val();
         alert(dmlt_id);
         alert(dmlt_district);
         
         //            var dmlt_id = $('#dmlt_id').val();
         //            var dmlt_district = $('#dmlt_district').val();
         
         $.post("<?php echo base_url() . 'rtk_management/dmlt_district_actions'; ?>", {
         action: 'add',
         dmlt_district: dmlt_district,
         dmlt_id: dmlt_id
         }).done(function(data) {
         alert("Data Loaded: " + data);
         $('#Add_DMLT').modal('hide');
         window.location = "<?php echo base_url() . 'rtk_management/county_admin/users'; ?>";
         });
         });
         
         
         */
    });
</script>

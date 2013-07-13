<?php
if (!$this -> session -> userdata('user_id')) {
	redirect("user_management/login");
}
if (!isset($link)) {
	$link = null;
}
if (!isset($quick_link)) {
	$quick_link = null;
}
$access_level = $this -> session -> userdata('user_indicator');
$drawing_rights = $this -> session -> userdata('drawing_rights');

$user_is_facility = false;
$user_is_moh = false;
$user_is_district=false;
$user_is_moh_user=false;
$user_is_facility_user = false;
$user_is_kemsa=false;
$user_is_super_admin=false;
$user_is_rtk_manager=FALSE;
if ($access_level == "facility" ||$access_level=="fac_user") {
	$user_is_facility = true;
}
if ($access_level == "moh") {
	$user_is_moh = true;
}
if ($access_level == "district") {
	$user_is_district = true;
}
if($access_level=="moh_user"){
	$user_is_moh_user=true;
}
if($access_level=="kemsa"){
	$user_is_kemsa=true;
}
if($access_level=="super_admin"){
	$user_is_super_admin=true;
}
if($access_level=="rtk_manager"){
	$user_is_rtk_manager=true;
}
?>
<?php //foreach($name_facility->Codes as $drug){echo $drug->facility_name;}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<link rel="icon" href="<?php echo base_url().'Images/coat_of_arms.png'?>" type="image/x-icon" />
<link href="<?php echo base_url().'CSS/style.css'?>" type="text/css" rel="stylesheet"/> 
<link href="<?php echo base_url().'CSS/jquery-ui.css'?>" type="text/css" rel="stylesheet"/> 
<script src="<?php echo base_url().'Scripts/jquery.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/jquery-ui.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/waypoints.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/waypoints-sticky.min.js'?>" type="text/javascript"></script>
  <?php
if (isset($script_urls)) {
	foreach ($script_urls as $script_url) {
		echo "<script src=\"" . $script_url . "\" type=\"text/javascript\"></script>";
	}
}
?>
<?php
if (isset($scripts)) {
	foreach ($scripts as $script) {
		echo "<script src=\"" . base_url() . "Scripts/" . $script . "\" type=\"text/javascript\"></script>";
	}
}
?>
<?php
if (isset($styles)) {
	foreach ($styles as $style) {
		echo "<link href=\"" . base_url() . "CSS/" . $style . "\" type=\"text/css\" rel=\"stylesheet\"/>";
	}
}
?>  
<style>
       
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
<script type="text/javascript">
function showTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
h=checkTime(h);
m=checkTime(m);
s=checkTime(s);
$("#clock").text(h+":"+m+":"+s);
t=setTimeout('showTime()',1000);
}
function checkTime(i)
{
if (i<10)
  {
  i="0" + i;
  }
return i;
}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#my_profile_link").click(function(){
			$("#logout_section").css("display","block");
		});
					///////////////////////////////////////
			$(function() {
        var oldp = $( "#oldpassword" ),
            newp = $( "#newpassword" ),
            password = $( "#password" ),
            allFields = $( [] ).add( oldp ).add( newp ).add( password ),
            tips = $( ".validateTips" );
 
         
        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }
 
        
 

 
        $( "#modalbox" ).click(function() {
       var url = "<?php echo base_url().'user_management/change_password' ?>"
          $.ajax({
          type: "POST",
          data: "ajax=1",
          url: url,
          beforeSend: function() {
            $("#id").html("");
          },
          success: function(msg) {
          
            $("#id").html(msg);
                    $( "#dialog-form" ).dialog({
            autoOpen: true,
            height: 310,
            width: 350,
            modal: true,
            buttons: {
                "Change Password": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
 
                    bValid = bValid && checkLength( password, "password", 6, 16 );
                    //bValid = bValid && checkLength( oldp, "password", 5, 16 );
                    bValid = bValid && checkLength( newp, "password", 6, 16 );
 
                    // From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
                    bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
                    bValid = bValid && checkRegexp( oldp, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
                     bValid = bValid && checkRegexp( newp, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
                    if ( bValid ) {
                       
                            //run script to change password here
                        $( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                     $("#id").html("");
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
           
          }
        });
        return false;
        
       
                $( "#dialog-form" ).dialog( "open" );
            });
    });
$('#top-panel').waypoint('sticky');
	});

</script>
</head>
 
<body onload="showTime()">
	


<div id="wrapper">
	<div id="top-panel" style="margin:0px;">

		<div class="logo_template">
			<a class="logo_template" href="<?php echo base_url();?>" ></a> 
</div>

				<div id="system_title">
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Ministry of Health</span>
					<span style="display: block; font-size: 12px;">Health Commodities Management Platform</span>
					
				</div>
			<?php if($banner_text=="New Order"):?>
				<div style="display: block; margin-left: 40%;font-family: Helvetica, Arial, sans-serif;">
					
			<span><b> Total Order Value </b><b id="t" >  0</b></span>
			<span style="display: block; font-size: 12px;"><b> Drawing Rights Available Balance  </b><b id="drawing">
				<?php echo $drawing_rights;?>
			</b></span>
		        
	</div>
	
	
	<?php endif;?>
	<?php $facility=$this -> session -> userdata('news');?>
 <div id="top_menu"> 

 	<?php
	//Code to loop through all the menus available to this user!
	//Fet the current domain
	$menus = $this -> session -> userdata('menu_items');
	$current = $this -> router -> class;
	$counter = 0;
?>
<nav id="navigate">
<ul>
 	
<?php
if($user_is_facility){
?>
<li class="<?php
	if ($current == "home_controller") {echo "active";}?>"><a data-clone="Home" href="<?php echo base_url();?>home_controller">Home </a></li>
 	<li><a data-clone="Orders" href="<?php echo base_url();?>order_management" class="<?php
	if ($quick_link == "order_listing") {echo "active";}?>"> Orders </a></li> 

<li><a data-clone="Issues" href="<?php echo base_url();?>Issues_main" class="<?php
	if ($current == "Issues_main") {echo "active";
	}
?>">Issues </a></li>	
<!--<a href="<?php echo base_url();?>order_management/all_deliveries/<?php echo $facility?>" class="top_menu_link<?php
	if ($quick_link == "dispatched_listing_v") {echo " top_menu_active ";
	}
	?>">Deliveries</a>-->
<li><a data-clone="Reports" href="<?php echo base_url();?>report_management/reports_Home"  class="<?php
	if ($current == "report_management") {echo "active";
	}
?>">Reports </a></li>
<li><a data-clone="Commodity List" href="<?php echo base_url();?>report_management/commodity_list" class="<?php
	if ($quick_link == "commodity_list") {echo "active";
	}
?>">Commodity List</a></li>
<?php if($access_level == "fac_user"){} else{?>
<li><a data-clone="Users" href="<?php echo base_url();?>user_management/users_manage"  class="<?php
	if ($quick_link == "user_facility_v") {echo "active";
	}
?>">Users</a></li>
 <?php
}
} ?>
<?php if($user_is_district){
	?>
	
	<ul>
		<li class="<?php
	if ($current == "home_controller") {echo "active";}?>"><a data-clone="Home" href="<?php echo base_url();?>home_controller">Home </a></li>
	<!--<li><a data-clone="Actions" href="<?php echo base_url();?>dp_facility_list/actions"  class="<?php
	if ($quick_link == "actions") {echo "active";
	}
?>">Actions</a></li>-->
	 	<li><a data-clone="District Orders" href="<?php echo base_url();?>order_approval/district_orders"  class="<?php
	if ($quick_link == "new_order") {echo "active";
	}
?>">District Orders</a></li>

	 	<li><a data-clone="Users" href="<?php echo base_url();?>user_management/dist_manage"  class="<?php
	if ($current == "user_management") {echo "active";}?>">Users</a></li>
	<!--<li><a data-clone="Reports" href="#"  class="<?php
	if ($quick_link == "new_order") {echo "active";
	}
?>">Reports</a></li>-->
	<li><a data-clone="Commodity List" href="<?php echo base_url();?>report_management/commodity_list" class="<?php
	if ($quick_link == "commodity_list") {echo "active";
	}
?>">Commodity List</a></li>
<!--	<li><a data-clone="Facility List" href="<?php echo base_url();?>dp_facility_list/get_facility_list"  class="<?php
	if ($quick_link == "facility_list") {echo "active";
	}
?>">Facility List</a></li>--></ul>


	<?php }
?>


<?php if($user_is_kemsa){
	?>
	<li><a data-clone="Orders" href="<?php echo site_url('order_management/kemsa_order_v');?>"  class="<?php
	if ($quick_link == "kemsa_order_v") {echo "active";
	}
?>">Orders</a></li>
	<?php
}
?>
<?php if($user_is_super_admin){
	?>
	<li><a data-clone="User" href="<?php echo site_url('user_management/create_user_super_admin');?>"  class="<?php
	if ($quick_link == "kemsa_order_v") {echo "active";
	}
?>">Users</a></li>
	<?php
}
?>
<?php if($user_is_rtk_manager){
	?>
	<li class="active"><a data-clone="Home" href="<?php echo base_url();?>home_controller">Home </a></li>
	<li><a data-clone="Facility Mapping" href="<?php echo site_url('rtk_management/rtk_mapping');?>"  class="<?php
	if ($quick_link == "kemsa_order_v") {echo "active";
	}
?>">Facility Mapping</a></li>

<li><a data-clone="CD4" href="<?php echo site_url('cd4_management');?>"  class="<?php
	if ($quick_link == "kemsa_order_v") {echo "active";
	}
?>">CD4</a></li>
	<?php
}
?>
<?php if($user_is_moh_user){
	?>

<li class="<?php
	if ($current == "home_controller") {echo "active";}?>"><a data-clone="Home" href="<?php echo base_url();?>home_controller">Home </a></li>

	<li>
		<a data-clone="Stock Level"  href="<?php echo site_url('stock_management/stock_level_moh');?>" class="<?php
	if ($quick_link == "load_stock") {echo "active";
	}
	?>">Stock Level</a></li>
	<li><a data-clone="View Orders"  href="<?php echo site_url('order_management/moh_order_v');?>" class="<?php
	if ($quick_link == "moh_order_v") {echo "active";
	}
	?>">View Orders</a></li>
	<li><a data-clone="Unconfirmed Orders"  href="<?php echo site_url('order_management/unconfirmed');?>" class="<?php
	if ($quick_link == "unconfirmed_orders") {echo "active";	}
	?>">Unconfirmed Orders</a></li>
	<li><a data-clone="Trends" href="<?php echo site_url('raw_data/trends');?>"   class="<?php
	if ($quick_link == "trends") {echo "active";
	}
	?>">Trends</a></li>
	

<?php
}
?>
<?php if($user_is_moh){
	?>
	
<li class="<?php
	if ($current == "home_controller") {echo "active";}?>"><a data-clone="Home" href="<?php echo base_url();?>home_controller">Home </a></li>
	
		
		<li><a data-clone="Users" href="<?php echo base_url();?>user_management/moh_manage" class="<?php
	if ($current == "user_management") {echo "active";}?>">Users</a></li>
	
	<li><a data-clone="Stock Level"  href="<?php echo site_url('stock_management/stock_level_moh');?>"   <?php
	if ($quick_link == "load_stock") {echo "top_menu_active";
	}
	?>">Stock</a></li>
	<li><a data-clone="Orders"   href="<?php echo site_url('order_management/moh_order_v');?>"  <?php
	if ($quick_link == "moh_order_v") {echo "top_menu_active";
	}
	?>>Orders</a></li>
	<li>
		<a data-clone="Trends" href="<?php echo site_url('raw_data/trends');?>" <?php
	if ($quick_link == "trends") {echo "active";
	}
	?>>Trends</a>
	</li>
    <li><a data-clone="Consumption"  href="<?php echo site_url('raw_data/getCounty');?>"   <?php
	if ($quick_link == "Consumption") {echo "active";
	}
	?>>Consumption</a>
	</li>
<?php
}
?>
</ul>
</nav>
</div>
  	
	<div style="font-size:15px; float:right; "><?php echo date('l, dS F Y');?>&nbsp;<div id="clock" style="font-size:15px; float:right; " ></div> </div>
<div class="banner_content" style="font-size:20px; float:right; margin-top: 40px;"><?php echo $this -> session -> userdata('full_name').": ".$banner_text;?>

	
	<div style="float:right">
		

		 <?php echo $this -> session -> userdata('names');?> <?php echo $this -> session -> userdata('inames');?>
	<a  class="link" href="<?php echo base_url();?>user_management/logout">Logout?</a>|<a href="#dialog-form" rel="fancybox" id="modalbox" class="link">Change Password</a>
		</div>
	
	</div>
	
	
</div>

<div id="inner_wrapper"> 
<!-- MOH USR-->

<div id="main_wrapper"> 
 
<?php $this -> load -> view($content_view);?>
<!-- end inner wrapper -->
</div>
  <!--End Wrapper div--></div>
    <div id="bottom_ribbon"><div id="footer"><?php $this -> load -> view("footer_v");?></div></div>
</body>

</html>

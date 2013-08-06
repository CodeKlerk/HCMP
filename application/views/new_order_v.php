<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/unit_size.js"></script>
<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media2/css/jquery.dataTables.css";
		</style>
<style>
.user{
	width:70px;
	background : none;
	border : none;
	text-align: center;
	}
	.user2{
	width:70px;
	
	text-align: center;
	}
	.col5{background:#D8D8D8;}
				 .form_settings { 
  margin: 15px 0 0 0;
  font-size: 14px;
  font-family: 'trebuchet MS', 'Lucida sans', Arial;
}

.form_settings p { 
  padding: 0 0 4px 0;
}
			 
.form_settings span { 
  float: left; 
  width: 20%; 
  text-align: left;
}
  
.form_settings input, .form_settings textarea , .form_settings select { 
  padding: 5px; 
  width: 20%; 
  font: 100% arial; 
  border: 1px solid #D5D5D5; 
  background: #FFF; 
  color: #47433F;
  border-radius: 7px 7px 7px 7px;
  -moz-border-radius: 7px 7px 7px 7px;
  -webkit-border: 7px 7px 7px 7px;  
}
	</style>
	
<script>

 
 	/*****************/
 var drawingRights=document.getElementById('drawing').innerHTML;
 var c_total=0;
 /*********************************************************************************************************************************************************/
//function get get_unit_quantity
 /*********************************************************************************************************************************************************/

        
	function checker(jay,chr){
		//get from which row we are getting the data from which the user is adding data
		var x= jay;
		var newTotal=0;		
	    var quantity=document.getElementsByName("quantity["+x+"]")[0].value;
	    //checking if the quantity is a number 	    
	var num = document.getElementsByName("quantity["+x+"]")[0].value.replace(/\,/g,'');
if(!isNaN(num)){
if(num.indexOf('.') > -1) {
alert("Decimals are not allowed.");
document.getElementsByName("quantity["+x+"]")[0].value = document.getElementsByName("quantity["+x+"]")[0].value.substring(0,document.getElementsByName("quantity["+x+"]")[0].value.length-1);
document.getElementsByName("quantity["+x+"]")[0].select();
return;
}
} else {
alert('Enter only numbers');
document.getElementsByName("quantity["+x+"]")[0].value= document.getElementsByName("quantity["+x+"]")[0].value.substring(0,document.getElementsByName("quantity["+x+"]")[0].value.length-1);
document.getElementsByName("quantity["+x+"]")[0].select();	
return;
}
if(num <0){
	alert('Negatives are not allowed');
document.getElementsByName("quantity["+x+"]")[0].value= document.getElementsByName("quantity["+x+"]")[0].value.substring(0,document.getElementsByName("quantity["+x+"]")[0].value.length-1);
document.getElementsByName("quantity["+x+"]")[0].select();	
return;	
}
		//delete any value in order total
		$('#t').empty(); 
		document.getElementsByName("cost["+x+"]")[0].value='';
		//get the data from the row the user is at
		var price= document.getElementsByName("price["+x+"]")[0].value;
       
        var draw=0;
        //alert(draw);
        var newTotal=0; 
        $('#drawing').empty();
        //find the total of that perticular item
        var total=price*quantity;
        //set the total in the textfield
        document.getElementsByName("cost["+x+"]")[0].value=total.toFixed(2);  
        
        var unit_cost=document.getElementsByName("unit_size["+x+"]")[0].value;
        var test=get_unit_quantity(unit_cost)
        document.getElementsByName("actual_quantity["+x+"]")[0].value=test*quantity;
        
 /**************************************************************************************************************/       
        //we need to calculate the total of the order, so we load all of the cost variables    
        //loop through them to get the values sum it to get the total
        $("input[name^=cost]").each(function() {
        	
        newTotal=parseFloat($(this).val())+parseFloat(newTotal);
     	draw=drawingRights-newTotal;
          
                    });
                    
 /**************************************************************************************************************/    
           c_total=newTotal;
  /***********************************************check to see if the user has used up all of their drawing rights *********************************/      
  

  
     
           /*if(draw < 0){ 
					 alert('You have used up all your drawing rights Please adjust your values.');
					 document.getElementsByName("quantity["+x+"]")[0].value = document.getElementsByName("quantity["+x+"]")[0].value.substring(0,document.getElementsByName("quantity["+x+"]")[0].value.length-1);
						return;
						}
						else{  
						
     	 	}*/
        
        $('#t').html(number_format(newTotal, 2, '.', ',')); 
        //calculate the users drawing rights balance based on the items they have ordered for.
        if(newTotal==0){
        	
     	 	$('#drawing').html(drawingRights);  
     	 	
     	 }else{
     	 	$('#drawing').html(number_format(draw, 2, '.', ','));
     	 	}
     	 	
     	 	json_obj={"url":"<?php echo site_url("order_management/update_facility_transaction_t2");?>",}
			 var baseUrl=json_obj.url;
			 var data_array=quantity;     
			 var data_array2=document.getElementsByName("comment["+jay+"]")[0].value;
			 var code=document.getElementsByName("kemsaCode["+jay+"]")[0].value;  
			 var chr=chr;
			 if(chr==true){
			 	
			 
			 update_transaction2(baseUrl,"data_array="+code+"|"+data_array+"|"+data_array2);   
			 }  
	}
	
	function update_comment(jay){
		json_obj={"url":"<?php echo site_url("order_management/update_facility_transaction_t2");?>",}
			 var baseUrl=json_obj.url;
			 var data_array=document.getElementsByName("comment["+jay+"]")[0].value;      
			 var code=document.getElementsByName("kemsaCode["+jay+"]")[0].value;
			 update_transaction2(baseUrl,"data_array="+code+"||"+data_array);    
	}
/***********creating the request that will update the facility transaction ******/
var c_id=1;
function update_transaction(baseUrl,data_array){
			/*
			 * ajax is used here to retrieve values from the server side and set them in dropdown list.
			 * the 'baseUrl' is the target ajax url, 'post' contains the a POST varible with data and
			 * 'identifier' is the id of the dropdown list to be populated by values from the server side
			 */
			
			$.ajax({
			  type: "POST",
			  url: baseUrl,
			  data: data_array,
			  success: function(msg){
			  	console.log(msg+c_id);
					c_id=c_id+1;
			  },
			  error: function(XMLHttpRequest, textStatus, errorThrown) {
			       if(textStatus == 'timeout') {}
			   }
			}).done(function( msg ) {
				
			});
		}
		
		function update_transaction2(baseUrl,data_array){
			/*
			 * ajax is used here to retrieve values from the server side and set them in dropdown list.
			 * the 'baseUrl' is the target ajax url, 'post' contains the a POST varible with data and
			 * 'identifier' is the id of the dropdown list to be populated by values from the server side
			 */
			
			$.ajax({
			  type: "POST",
			  url: baseUrl,
			  data: data_array,
			  success: function(msg){
			  	console.log(msg+c_id);
					c_id=c_id+1;
			  },
			  error: function(XMLHttpRequest, textStatus, errorThrown) {
			       if(textStatus == 'timeout') {}
			   }
			}).done(function( msg ) {
				
			});
		}
 
	$(function() {

		/**********/
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		//confirmation modal window
		$( "#dialog-form" ).dialog({
		    autoOpen: false,
			height: 600,
			width: 700,
			modal: true,
			buttons: {
				"Confirm": function() {
           $('#myform').submit();
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
			});
			//
			//add product modal window
			var new_count =count123;
			$( "#add-form" ).dialog({
		    autoOpen: false,
			height: 250,
			width: 1500,
			modal: true,
			buttons: {
				"Add": function() {	
						
/******************************parameters to update the transaction table*********************************/		
			
					var data_array=$('input:text[name=k_code]').val();
					json_obj={"url":"<?php echo site_url("order_management/update_facility_transaction_t");?>",}
			        var baseUrl=json_obj.url;
			        
			        update_transaction(baseUrl,"data_array="+data_array);
					var txz=true;
         $( "#main" ).dataTable().fnAddData( [ 
         '<input type="hidden" id="drugCode['+new_count+']" name="drugCode['+new_count+']" value="'+$('input:text[name=k_code]').val()+'" />'+
         '<input type="hidden" id="kemsaCode['+new_count+']" name="kemsaCode['+new_count+']" value="'+$('input:hidden[name=drug_id]').val()+'" />'+
         '<input type="hidden" id="drugName['+new_count+']" name="drugName['+new_count+']" value="'+$("#desc option:selected").text()+'" />'+ 
         '<input type="hidden" id="price['+new_count+']" name="price['+new_count+']" value="'+$('input:text[name=o_unit_cost]').val()+'" />'+
         '<input type="hidden" id="unit_size['+new_count+']" name="unit_size['+new_count+']" value="'+$('input:text[name=o_unit_size]').val()+'" />'+
							"" + $('input:text[name=cat_1]').val() + "" ,  
							"" + $("#desc option:selected").text() + "" , 
							"" + $('input:text[name=k_code]').val() + "" ,
							"" + $('input:text[name=o_unit_size]').val() + "" ,
							"" + $('input:text[name=o_unit_cost]').val() + "" ,
							'' +'<input class="user2" type="text" name="open['+new_count+']" id="open[]"   value="0"/>',
							'<input class="user2" type="text" name="issues['+new_count+']" id="issues[]"   value="0" />',
							 '<input class="user2" type="text" name="receipts['+new_count+']" id="receipts[]"  value="0" />' ,
							'<input class="user2" type="text" name="adjustments['+new_count+']"  value="0"   />' ,
							'<input class="user2" type="text" name="losses['+new_count+']" value="0"   />' ,
							'<input class="user2" type="text" name="closing['+new_count+']" value="0"   />',
							 '<input class="user2" type="text" name="days['+new_count+']" value="0"   />',
							'<input class="user2" type="text" name="quantity['+new_count+']" value="0"  onkeyup="checker('+new_count+','+txz+')"/>',
							'<input class="user" type="text" id="actual_quantity['+new_count+']" name="actual_quantity['+new_count+']" value="0" readonly="yes" />',
							'<input id="cost[]" class="user" type="text" name="cost['+new_count+']" value="0" readonly="yes" />',
							'<input type="text" name="comment['+new_count+']" value="N/A"/>'
						 ]); 
						
						$( this ).dialog( "close" );
						new_count=new_count+1;
					//	}
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				  
				
			}
			});
			
			/************combo box on change**8*********************************/
			$('#desc').change(function() {
				var code= $("#desc").val();
				var code_array=code.split("|");
				$('input:text[name=k_code]').val(code_array[0]);
				$('input:text[name=o_unit_size]').val(code_array[2]);
				$('input:text[name=o_unit_cost]').val(code_array[1]);
				$('input:text[name=cat_1]').val(code_array[3]);
				$('input:hidden[name=drug_id]').val(code_array[4]);
				
				//alert(code_array[4]);
				
  
});
			
			//button to activate the product add modal window
			
			$( "#Add" )
			.button()
			.click(function() {
				
/**********************************************************removing elements in the drug list****************************************************/	
   
      $("input[name^=drugCode]").each(function(index, value) {
       	
        	$("#desc option").each(function(index, option) {
        		
        	var c_checker=$(option).val();
        	var array_d=c_checker.split("|");
        	
            if($(value).val()==array_d[0]){
         	$(option).remove();
            }
          
                   });
          
                    });
			
				
			/* var t=$('#t').html();
			 var bal=drawingRights-t	
				if(bal<1){ 
					 alert('You cannot add another product to your order list as you have used up all your drawing rights');
						}
						else{*/
							
				$( "#add-form" ).dialog( "open" );
				//}
			});
			
			//button to post the order
			
			$( "#Make-Order" )
			.button()
			.click(function() {
				
				$('#user-order tbody').empty();
				$('#test-hapa tbody').empty();
				
				var cost = document.myform.elements["cost[]"];
                var t=$('#t').html();
                var t_new=  t.replace(',', 'new');
                var bal=drawingRights-c_total;
                
        if(t==0){
        	$( "#demo" ).append(' <div id="pop" title="System Message"><p>Please Enter Order Quantity</p></div>');
        	$("#pop").dialog({
			height: 140,
			modal: true
		});
        }
        else{
        	$('#test-hapa tbody').append(
     		'<tr>'+
			'<td><label for="name">Drawing Rights</label></td>'+
			'<td>'+
			'<input  type="text" readonly="yes"   value="'+number_format(drawingRights, 2, '.', ',')+' Ksh'+'" />'+
			'</td>'+
		'</tr>'+
		'<tr>'+
			'<td><label for="phone">Total Order Value</label></td>'+
			'<td>'+
			'<input type="text" readonly="yes"   value="'+t+' Ksh'+'"/>'+
			'</td>'+
		'</tr>'+
		'<tr>'+
			'<td><label for="pin">Balance</label></td>'+
			'<td>'+
			'<input type="text" readonly="yes"   value="'+number_format(bal, 2, '.', ',')+'Ksh'+'"/>'+
			'</td>'+
		'</tr>'
     		
     	)
  /*******************************************************printing out the pop out form***********************************/   	
        $("input[name^=cost]").each(function(i) {
        $( "#user-order tbody" ).append( "<tr>" +
							"<td>" +$(document.getElementsByName("drugCode["+i+"]")).val()+ "</td>" +
							"<td>" +$(document.getElementsByName("drugName["+i+"]")).val()+ "</td>" +
							"<td>" +$(document.getElementsByName("quantity["+i+"]")).val()+ "</td>" +	
							"<td>" +number_format($(document.getElementsByName("price["+i+"]")).val(), 2, '.', ',')+ "</td>" +	
							"<td>" +number_format($(document.getElementsByName("cost["+i+"]")).val(), 2, '.', ',')+ "</td>" +													
						"</tr>" ); 
                    });
         	  $( "#dialog-form" ).dialog( "open" ); 
  /*******************************************************printing out the pop out form***********************************/   	
         	  } 
         	  });
 
        $( "#dialog" ).dialog();
		/****accordion settings*****/
		$("#accordion").accordion({
			autoHeight : false,
			active: false,
			collapsible: true
		});
		/*********/
	});	
   
 /************************************document ready**********************************************************/
    $(document).ready(function() {
	
  $("input[name^=quantity]").each(function(index, value) {
  	var chr=false;
  	suggest_order_value(index);
    checker(index,chr);
    });
    
    	$('#main').dataTable( {
    		
					"bJQueryUI": true,
                   "bPaginate": false
				} );
    
});
    
</script>


<!-- pop out modal box -->

<div id="dialog-form" title="Please Confirm your Order">
	<table style="margin-left: 40%"  id='test-hapa'><tbody></tbody></table>
	<form>
	<table id="user-order" width="500px" class="data-table">
					<thead>
					<tr>
					    <th><b>KEMSA Code</b></th>
						<th><b>Description</b></th>
						<th style="width: 20px"><b>Order Quantity</b></th>
						<th style="width: 20px"><b>Unit Cost Ksh</b></th>	 
						<th style="width: 20px"><b>Total Ksh</b></th>	 	    
					</tr>
					</thead>
							<tbody>
							
						</tbody>
						</table>
	</form>
</div>
<!--end of pop out modal box -->

<!-- pop out box -->
<div id="add-form" title="Fill in the details below">
	<table class="data-table" width="100%">
					<thead>
					<tr>
						<th><b>KEMSA Code</b></th>
						<th><b>Description</b></th>
						<th><b>Order Unit Size</b></th>
						<th><b>Order Unit Cost Ksh</b></th>					   	    
					</tr>
					</thead>
					<tbody>
						<tr>
						<td><input type="text" name="k_code"  value="0" /></td>
						<td>
        <select id="desc" name="desc">
    <option>--Select Commodity Name--</option>
    <?php 
		foreach($drug_name as $category):
                             $cat=''.$category->Category_Name.'';
					echo  $cat;
						foreach($category->Category as $drug):
							
						     $drug_id=$drug->id;
							 $id= $drug->Kemsa_Code;							
							 $cat= $category->Category_Name;
							 $unit_size= $drug->Unit_Size;
							 $cost= $drug->Unit_Cost;
							 $county=$drug->Drug_Name;?>
					
						<option value="<?php echo $id.'|'.$cost.'|'.$unit_size.'|'.$cat.'|'. $drug_id;?>"><?php echo $county;?></option>				
		<?php endforeach;
		endforeach;?>
	</select></td>
						<td><input  type="text" name="o_unit_size"  value="0" /></td>
						<td><input type="text" name="o_unit_cost"  value="0" /></td>
						<td><input type="text" name="cat_1"  value="0" /></td>
						<td><input type="hidden"" name="drug_id"  value="0" /></td>
						</tr>
					</tbody>
					</table>
</div>
	
	<?php $attributes = array( 'name' => 'myform', 'id'=>'myform');
	 echo form_open('Order_Management/makeOrder',$attributes); ?>
	
	 <div id="notification">Enter Order Quantity and Comment</div>
	 <div id="notification">Quantified Quantity = (Consumption * 4/) - Closing Stock</div>
	  
<table width="100%">
	<tr>
		<td>
	<div class="form_settings" style="width: 50%">
     <p><span>Oder Form Number:</span> <input type="text" name="order_no"  /></p>
	</div>
	</td>
	<td>
	<div class="form_settings" style="width: 100%">
	  <p><span>Bed Capacity:</span><input type="text" name="bed_capacity"  />	 </p>
	  	</div>   
	  	</td>	
	  	<td>
	 <div class="form_settings" style="width: 100%">
	 <p><span>Number of Patients:</span><input type="text" name="workload" /></p>
	   </div>
	   </td>
	   </tr>
	</table>
		<div id="demo">
			<p>
				<table id="main">
					<thead>
					<tr>
						
						<th><b>Category</b></th>
						<th><b>Description</b></th>
						<th><b>KEMSA&nbsp;Code</b></th>
						<th><b>Order Unit Size</b></th>
						<th><b>Order Unit Cost</b></th>
						<th ><b>Opening Balance</b></th>
						<th ><b>Total Receipts</b></th>
					    <th><b>Total issues</b></th>
					    <th><b>Adjustments</b></th>
					    <th><b>Losses</b></th>
					    <th><b>Closing Stock</b></th>
					    <th><b>No days out of stock</b></th>
					    <th><b>Order Quantity</b></th>
					    <th><b>Actual Units</b></th>
					    <th><b>Order cost(Ksh)</b></th>	
					   <th><b>Comment(if any)</b></th>				    
					</tr>
					</thead>
					
							<tbody>
								<?php $count=0; $thr=true; 
								$j=count($facility_order);
								
								for($i=0;$i<$j;$i++){?>
						<tr>
							<td><?php echo $facility_order[$i]['category_name'];?></td>
							<?php echo form_hidden('drugCode['.$count.']', $facility_order[$i]['drug_code']);?>
							<?php echo form_hidden('kemsaCode['.$count.']', $facility_order[$i]['kemsa_code']);?>
							<?php echo form_hidden('drugName['.$count.']', $facility_order[$i]['drug_name']);?>
							<?php echo form_hidden('price['.$count.']'  ,$facility_order[$i]['unit_cost']);?>
							<?php echo form_hidden('unit_size['.$count.']'  ,$facility_order[$i]['unit_size']);?>
							<td><?php echo $facility_order[$i]['drug_name']?></td>
							<td><?php echo $facility_order[$i]['drug_code'];?></td>
							<td><?php echo $facility_order[$i]['unit_size']?> </td>
							<td><?php echo $facility_order[$i]['unit_cost']; ?> </td>
							<td><input id="open[]" readonly="readonly" class="user" type="text" <?php echo 'name="open['.$count.']"'; ?>  value="<?php echo $facility_order[$i]['opening_balance'];?>" /></td>
							<td><input id="receipts[]" class="user" readonly="readonly" type="text" <?php echo 'name="receipts['.$count.']"'; ?>  value="<?php echo $facility_order[$i]['total_receipts'];?>" /></td>
							<td><input id="issues[]" class="user" readonly="readonly" type="text" <?php echo 'name="issues['.$count.']"'; ?>  value="<?php echo $facility_order[$i]['total_issues'];?>" /></td>
							<td><input id="adjustments[]" class="user" readonly="readonly" type="text"  <?php echo 'name="adjustments['.$count.']"'; ?> value="<?php echo $facility_order[$i]['adj']?>"  /></td>
							<td><input id="losses[]" class="user" readonly="readonly" type="text"  <?php echo 'name="losses['.$count.']"'; ?> value="<?php echo $facility_order[$i]['losses'] ?>" /></td>
							<td><input id="closing[]" class="user" readonly="readonly" type="text"  <?php echo 'name="closing['.$count.']"'; ?> value="<?php echo $facility_order[$i]['closing_stock'];?>" /></td>
							<td><input id="days[]" class="user" readonly="readonly" type="text"  <?php echo 'name="days['.$count.']"'; ?> value="<?php echo $facility_order[$i]['days_out_of_stock'];?>" /></td>
							<td ><input id="quantity[]" class="user2" type="text" <?php echo 'name="quantity['.$count.']"';?> value="<?php $qty=$facility_order[$i]['qty'];
							if($qty>0){echo $qty;} else echo 0;?>" onkeyup="<?php echo 'checker('.$count.','.$thr.')';?>"/></td>
							<td><input class="user" style="border: none" type="text" id="actual_quantity[]" <?php echo 'name="actual_quantity['.$count.']"';?> value="0" readonly="yes" /></td>
							<td><?php echo '<input style="border: none" id="cost[]" type="text" class="user" name="cost['.$count.']" value="0" readonly="yes"   />';?></td>
							<td ><input type="text" id="comment[]" <?php echo 'name="comment['.$count.']"' ?> onkeyup="<?php echo 'update_comment('.$count.')';?>" value="N/A" /></td>
			       
						</tr>
						
						<?php 
					$count++;}	
					
					?>
				
						</tbody>
						
				</table>
			</p>
		</div>
		<?php  echo form_close()."<script>var count123=".($count)."</script>";
		?>
</div><!-- End demo -->
<input  class="button" id="Add"  value="Add A Product" >
<input class="button" id="Make-Order"  value="Place Order" >
</body>

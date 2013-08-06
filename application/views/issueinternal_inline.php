
<html>
<head><link rel="icon" href="http://localhost/HCMP/Images/coat_of_arms.png" type="image/x-icon" />
<link href="http://localhost/HCMP/CSS/jquery-ui.css" type="text/css" rel="stylesheet"/> 
<script src="http://localhost/HCMP/Scripts/jquery.js" type="text/javascript"></script> 
<script src="http://localhost/HCMP/Scripts/jquery-ui.js" type="text/javascript"></script> 
<script src="http://localhost/HCMP/Scripts/waypoints.js" type="text/javascript"></script> 
<script src="http://localhost/HCMP/Scripts/waypoints-sticky.min.js" type="text/javascript"></script>
<script src="http://localhost/HCMP/Scripts/validator.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
  <title></title>
<script> 
   
/* Define two custom functions (asc and desc) for string sorting */
      jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
        return ((x < y) ? -1 : ((x > y) ?  1 : 0));
      };
      
      jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
        return ((x < y) ?  1 : ((x > y) ? -1 : 0));
      };
      
      $(document).ready(function() {
        /* Build the DataTable with third column using our custom sort functions */
        $('#example').dataTable( {
          "bJQueryUI": true,
          
          "aaSorting": [ [0,'asc'], [1,'asc'] ],
          "aoColumnDefs": [
            { "sType": 'string-case', "aTargets": [ 2 ] }
          ]
        } );
      } );

json_obj = {
        "url" : "http://localhost/HCMP/Images/calendar.gif",
        };
  var baseUrl=json_obj.url;
  
  $(function() {
              
    $( "#datepicker" ).datepicker({
      showOn: "button",
      dateFormat: 'd M, yy', 
      buttonImage: baseUrl,
      buttonImageOnly: true
    });
    
        $('#qty').keyup(function() {
          var hidden=$('input:[name=avlb_hide]').val();
            var stock=$('input:text[name=avlb_Stock]').val();
          var issues=$('input:text[name=qty]').val();
          var remainder=hidden-issues;
          
          
          if (remainder<0) {
            $('input:text[name=qty]').val('');
            $('input:[name=avlb_Stock]').val(hidden);
            alert("Can not issue beyond available stock");
          }else{
            
            $('input:text[name=avlb_Stock]').val(remainder);
          }
          if (issues == 0) {
              $('input:text[name=qty]').val('');
              alert("Issued value must be above 0");
          }
          if(issues.indexOf('.') > -1) {
            alert("Decimals are not allowed.");
              }
          if (isNaN(issues)){
            $('input:text[name=qty]').val('');
            alert('Enter only numbers');
              }
          });
     var checker=0;
    $( "#IssueNow" ).dialog({
        autoOpen: true,
      height: 250,
      width:1250,
      modal: false,
      buttons: {
        "Issue": function() {
          
          if ($('input:text[name=s11N]').val()=="") {           
            alert("Please enter S11 No");
            return;
          }
          if ($("#desc option:selected").text()=="-Select Drug Name-") {            
            alert("Please Select Drug");
            return;
          }
          if ($("#Exp option:selected").text()=="-Exp-" || $("#Exp option:selected").text()=="--Exp--") {           
            alert("Please Specify a Batch Number to Load its Details");
            return;
          }
          if ($('input:text[name=qty]').val()=="") {            
            alert("Please Specify the Amount to Issue");
            return;
          }
          if ($("#Servicepoint option:selected").text()=="-Select-") {            
            alert("Please Specify the Service Point");
            return;
          }   
      

          $( "#example" ).dataTable().fnAddData(['<input class="user" type="text" name="S11[]"  value="'+ $('input:text[name=s11N]').val() +'"/>' + '',
            "" + $('input:[name=kemsac_1]').val() + "" ,
            "" + $("#desc option:selected").text() + "" ,
      "" + $("#batchNo option:selected").text() + ""+ 

         '<input type="hidden" name="kemsaCode['+checker+']" value="'+$('input:[name=kemsac]').val()+'" />'+
         '<input type="hidden" name="drugName['+checker+']" value="'+$("#desc option:selected").text()+'" />'+
         '<input type="hidden" name="batchNo['+checker+']" value="'+$("#batchNo option:selected").text()+'" />'+ 
         '<input type="hidden" name="Expiries['+checker+']" value="'+$("#Exp option:selected").val()+'" />',
        '' +'<input class="user" type="text" name="Expiries['+checker+']" readonly="readonly" value="'+ $("#Exp option:selected").val() +'"/>' + '' ,
    '' +'<input class="user" type="text" name="AvStck['+checker+']" readonly="readonly" value="'+ $('input:text[name=avlb_Stock]').val() +'"/>' + '' ,
    '' + '<input class="user" type="text" name="Qtyissued['+checker+']" value="'+ $('input:text[name=qty]').val() +'" />' + '' ,
    '' + '<input class="user" type="text" name="date_issue['+checker+']"  value="'+ $('input:text[name=datepicker]').val() +'" />' + '' ,
    '' + '<input class="user" type="text" name="Servicepoint"  value="'+$("#Servicepoint option:selected").text()+'" />' + '' ,
    '' + '<img class="del" src="http://localhost/HCMP/Images/close.png" />' ]);
    checker =checker+1;
    $( this ).dialog( "close" );
        $('#demo').show();
      },

      Cancel: function() {
          $( this ).dialog( "close" );
        }
      },

      close: function() {
        
        $('input:text[name=s11N]').val(''); 
        $('input:text[name=unit_size]').val('');
        $('input:[name=kemsac]').val('');
        $("#batchNo option:selected").text('');
        $("#Exp option:selected").text('');
        //$("#desc option:selected").val('1000');
        $('#desc')[0].selectedIndex = 0;
        $('#Servicepoint')[0].selectedIndex = 0;
        $('input:text[name=datepicker]').val('');
        $('input:text[name=avlb_Stock]').val('');
        $('input:text[name=qty]').val('');
      }
            
      });
       
      // Select all table cells to bind a click event
$('.del').live('click',function(){
    $(this).parent().parent().remove();
});
    

    $('#desc').change(function() {
            
          var code= $("#desc").val();
        var text=$("#desc option:selected").text();
        var code_array=code.split("|");
        var text_array=text.split("|");
        $('input:[name=kemsac]').val(code_array[0]);
        $('input:[name=kemsac_1]').val(code_array[2]);
        $('input:[name=unit_size]').val(code_array[1]); 
        //alert(code_array[1]);
        //alert(code);
        
      /*
       * when clicked, this object should populate district names to district dropdown list.
       * Initially it sets default values to the 2 drop down lists(districts and facilities) 
       * then ajax is used is to retrieve the district names using the 'dropdown()' method that has
       * 3 arguments(the ajax url, value POSTed and the id of the object to populated)
       */
      $("#batchNo").html("<option>--Batch--</option>");
      $("#Exp").html("<option>--Exp--</option>");
      //$("#Exp").html("<option>--Exp Dates--</option>");
      json_obj={"url":"http://localhost/HCMP/order_management/getBatch",}
      var baseUrl=json_obj.url;
      var id=code_array[0];
      dropdown(baseUrl,"desc="+id,"#batchNo")
    
      
  $('#batchNo').click(function(){

         var code= $("#desc").val();
         var batch= $("#batchNo option:selected").text();
     var text=$("#desc option:selected").text();
     var code_array=code.split("|");

       var batch_array=$('#batchNo').val();
     var batch_split=batch_array.split("|");
     var drug_total=0;

  var new_date=$.datepicker.formatDate('d M, yy', new Date(batch_split[0]));

      var drop='<option>'+new_date+'</option>'
      $('#Exp').html(drop);

  $("input[name^=kemsaCode]").each(function(index, value) {
  //alert(batch);
      if($(this).val()==(code_array[0]) && $(document.getElementsByName("batchNo["+index+"]")).val()==batch){ 

        drug_total +=parseInt($(document.getElementsByName("Qtyissued["+index+"]")).val());
      }
    });
      //alert(drug_total);
       if(drug_total>0){
          batch_split[1]= batch_split[1]-drug_total;
       }else{
         
       }
           
            $('#avlb_Stock').val(batch_split[1]);
      $('#avlb_hide').val(batch_split[1]);

    }); 
  });
          
    function dropdown(baseUrl,post,identifier){
      /*
       * ajax is used here to retrieve values from the server side and set them in dropdown list.
       * the 'baseUrl' is the target ajax url, 'post' contains the a POST varible with data and
       * 'identifier' is the id of the dropdown list to be populated by values from the server side
       */
      $.ajax({
        type: "POST",
        url: baseUrl,
        data: post,
        success: function(msg){
          
            //alert(msg);
          
            var values=msg.split("_");
            var dropdown;
            var txtbox;
            for (var i=0; i < values.length-1; i++) {
              var id_value=values[i].split("*")
              if(i==0){
                dropdown+="<option selected='selected' value="+id_value[2]+"|"+id_value[3]+">";
              }else{
                dropdown+="<option value="+id_value[2]+"|"+id_value[3]+">";
              }
              
            dropdown+=id_value[1];            
            dropdown+="</option>";
            
            
          };          
          $(identifier).html(dropdown);
          
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
             if(textStatus == 'timeout') {}
         }
      }).done(function( msg ) {
        //alert("am done");
      });
    }
}); 

   </script>  </head>
<body>



 
<div id="IssueNow" class="" scrolltop="0" scrollleft="0" style="width: auto; min-height: 0px; height: auto;">
<button onClick="crack();">add</button>              
</div> 
 
  <th><b>S11 No</b></th>
                        <th><b>Description ( Click to Select commodity )</b></th>
                        <th><b>Unit Size</b></th>
                        <th><b>Batch No</b></th>
                         
                        <th><b>Expiry Date</b></th>
                        <th><b>Available Stock</b></th>
                        <th><b>Issued Quantity</b></th> 
                        <th><b>Issue Date</b></th>  
                        <th><b>Service Point</b></th>
<form>
<div id="orig"> 
    <td>
    <input class="user" "text"="" name="s11N" id="s11N" value="">
    </td>
    <td> <select class="dropdownsize" id="desc" name="desc">
    <option >-Select Commodity -</option>
        <?php 
        foreach ($drugs as $drugs) {
            
            foreach ($drugs->Code as $d) {
            $drugname=$d->Drug_Name;
            $code=$d->id;
            $unit=$d->Unit_Size;
            $kemsa_code=$d->Kemsa_Code;
                
            ?>
            <option value="<?php echo $code."|".$unit."|".$kemsa_code;?>"><?php echo $drugname;?></option>
        <?php }
        ?>
        <?php }
                            ?>
    </select></td>
    <td><input class="user1" id="unit_size" name="unit_size" <="" td="">
    </td><td><select id="batchNo" name="batchNo">
    <option>-Batch-</option>
    </select></td>
    <td>
    <select id="Exp" name="Exp">
    <option>-Exp-</option>
    </select></td>
    <td><input class="user1" id="avlb_Stock" name="avlb_Stock" readonly></td>
    <td><input type="text" class="user" name="qty" id="qty" value=""></td>
    <td><input type="text" name="datepicker" class="date hasDatepicker" readonly value="Wed Jul,2013" id="datepicker"><!--<img class="ui-datepicker-trigger" src="http://localhost/HCMP/Images/calendar.gif" alt="..." title="...">-->
    </td>
    <td>   
                    <select id="Servicepoint" name="Servicepoint" class="user1">
                        <option>-Select-</option>
                        <option value="CCC">CCC</option>
                        <option value="Pharmacy">Pharmacy</option>
                        <option value="Lab">Lab</option>
                        <option value="Maternity">Maternity</option>
                        <option value="Injection Room">Injection Room</option>
                        <option value="Dressing room">Dressing room</option>
                        <option value="TB Clinic">TB Clinic</option>
                        <option value="MCH">MCH</option>
                        <option value="Diabetic Clinic">Diabetic Clinic</option>
                    </select>
                     </td> 
    
   
</div> 
 
                    
<div id="copy-correct"></div>
<input type="submit"/>
</form>
<script>
function crack () {
 
 
// correct way to approach where order is maintained
$('#copy-correct')
          .append($('#orig')
          .clone()
          .children('tr')
          .prepend('')
          .end());
};</script>
 

 
</body>
</html>
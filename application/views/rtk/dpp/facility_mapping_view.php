

<script src="<?php echo base_url() . 'Scripts/accordion.js' ?>" type="text/javascript"></script>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url(); ?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT> 
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>


<script src="http://localhost/moh_fortification/media/js/jquery.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification/media/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification/media/js/complete.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification/media/js/jquery.min.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification/media/js/jquery.dataTables.editable.js" type="text/javascript" ></script>
<script src="http://localhost/moh_fortification/media/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification/media/js/jquery-ui.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification/media/js/jquery.validate.js" type="text/javascript"></script>
<script src="http://localhost/moh_fortification//media/js/jquery.jeditable.js" type="text/javascript"></script>



<style type="text/css" title="currentStyle">

    @import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
</style>
<script type="text/javascript">
    function disp(monthyear) {

        alert('Yolo jamaa' + monthyear);
    }
    $(document).ready(function() {
        $('#userModal').hide();
        $('#example_main').dataTable({
            "bJQueryUI": true,
            "bPaginate": false,
            "aaSorting": [[3, "desc"]]
        }).makeEditable({
            aoColumns: [
                {
                },
                null
            ],
            sUpdateURL: function(value, settings)
            {
                return value; //Simulation of server-side response using a callback function
            }//Remove this line in your code
            ,
            aoTableActions: [
                {
                    sAction: "EditData",
                    sServerActionURL: "",
                    oFormOptions: {autoOpen: false, modal: true}
                }
            ],
            sUpdateURL: "",
                    oAddNewRowButtonOptions: {label: "Add...",
                icons: {primary: 'ui-icon-plus'}
            },
            oDeleteRowButtonOptions: {label: "Delete",
                icons: {primary: 'ui-icon-trash'}
            },
            sAddURL: "http://localhost/moh_fortification/addData",
            sAddHttpMethod: "GET", //Used only on google.code live example because google.code server do not support POST request
            // sDeleteURL: "#",
            // sDeleteHttpMethod: "", //Used only on google.code live example because google.code server do not support POST request
            sAddDeleteToolbarSelector: ".dataTables_length",
        });
        $.fn.slideFadeToggle = function(speed, easing, callback) {
            return this.animate({
                opacity: 'toggle',
                height: 'toggle'
            }, speed, easing, callback);
        };
        $('.accordion').accordion({
            defaultOpen: 'section1',
            cookieName: 'nav',
            speed: 'medium',
            animateOpen: function(elem, opts) {//replace the standard slideUp with custom function
                elem.next().slideFadeToggle(opts.speed);
            },
            animateClose: function(elem, opts) {//replace the standard slideDown with custom function
                elem.next().slideFadeToggle(opts.speed);
            }
        });

        //       $(".alert").fadeIn(400);
        $(".alert").delay(6000).slideUp(1000);


    });



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
        width: 80%;
        min-height:100%;
        height:600px;
        float: left;
        -webkit-box-shadow: 2px 2px 6px #888;
        box-shadow: 2px 2px 6px #888; 
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

    #accordion {
        width: 300px;
        margin: 50px auto;
        float:left;
        margin-left:0.45em;
    }
    .collapsible,
    .page_collapsible,
    .accordion {
        margin: 0;
        padding:5%;
        height:15px;
        border-top:#f0f0f0 1px solid;
        background: #cccccc;
        font:normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;
        text-decoration:none;
        text-transform:uppercase;
        background: #29527b; /* Old browsers */
        border-radius: 0.5em;
        color: #fff; }
    .accordion-open,
    .collapse-open {
        background: #289909; /* Old browsers */    
        color: #fff; }
    .accordion-open span,
    .collapse-open span {
        display:block;
        float:right;
        padding:10px; }
    .accordion-open span,
    .collapse-open span {
        background:url('<?php echo base_url() ?>Images/minus.jpg') center center no-repeat; }
    .accordion-close span,
    .collapse-close span {
        display:block;
        float:right;
        background:url('<?php echo base_url() ?>Images/plus.jpg') center center no-repeat;
        padding:10px; }
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
    .accordion h3.collapse-open {}
    .accordion h3.collapse-close {}
    .accordion h3.collapse-open span {}
    .accordion h3.collapse-close span {}   
</style>



<div class="leftpanel">

    <div class="dash_menu">





        <h3 class="accordion" >Statistics<span></span><h3>
                <div class="container">


                </div>


                </div>


                <div class="sidebar">
                    <a href="<?php echo site_url('rtk_management/rtk_orders'); ?>">&nbsp;</a>


                    <nav class="sidenav">
                        <ul>
                            <li class="orders_minibar"><a href="<?php echo site_url('rtk_management/rtk_orders'); ?>" style="
                                                          margin: 0;  padding: 5%;  height: 15px;  border-top: #f0f0f0 1px solid;  background: #cccccc;  font: normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;  text-decoration: none;  text-transform: uppercase;  background: #29527b;  border-radius: 0.5em;  color: #fff;
                                                          ">Orders</a></li>
                                                                  <!--<li class="orders_minibar"><a href="<?php echo site_url('rtk_management/rtk_orders'); ?>">Pending
                                                              <span style="
                                                              font-weight: 400;
                                                              font-size: 1.5em;
                                                              color: #F3EA0B;
                                                              float: right;
                                                              background: rgb(216, 40, 40);
                                                              padding: 4px;
                                                              border-radius: 28px;
                                                              border: solid 1px rgb(150, 98, 98);
                                                          ">30</span>
                                                          </a> </li>-->

                        </ul>
                    </nav>




                </div>


                </div>

                <div class="dash_main" id = "dash_main">
                    <a data-toggle="modal" href="#userModal" class="btn btn-primary btn-large" style="
                       padding: 4px;
                       "><i class="icon-plus-sign"> </i> Add Facility</a>
                    <div id="userModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="false" style="display: block;">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3 id="userModalLabel">Add Facility</h3>
                        </div>
                        <div class="modal-body">
                            <h4>Facility Name: </h4>
                            <p> <input type="text" name="facilityname" /></p>
                            <h4>Facility MFL Code: </h4>
                            <p> <input type="text" name="facilitycode" /></p>
                            <h4>Facility MFL Code: </h4>
                            <p> <input type="text" name="facilitycode" /></p>
                            <h4>Facility Type: </h4>
                            <p> <input type="text" name="facilitytype" /></p>
                            <h4>Facility Owner: </h4>
                            <p> <input type="text" name="facilityowner" /></p>



                            <h4>Popover in a modal</h4>
                            <p>This <a href="#" role="button" class="btn popover-test" data-content="And here's some amazing content. It's very engaging. right?" data-original-title="A Title">button</a> should trigger a popover on click.</p>

                            <h4>Tooltips in a modal</h4>
                            <p><a href="#" class="tooltip-test" data-original-title="Tooltip">This link</a> and <a href="#" class="tooltip-test" data-original-title="Tooltip">that link</a> should have tooltips on hover.</p>

                            <hr>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Save changes</button>
                        </div>
                    </div>

                    <table  style="margin-left: 0;" id="example_main" width="100%" >
                        <thead>
                            <tr>
                                <th><b>MFL Code</b></th>
                                <th><b>Facility Name</b></th>
                                <th><b>Owner</b></th>
                                <th><b>Reporting Status</b></th>
                                <th><b>Type</b></th>

                            </tr>
                        </thead>
                        <tbody id="facilities_home">
                            <?php echo $table_body; ?>

                        </tbody>            
                    </table>

                </div>
                </div>

                </div>




 <style type="text/css">
.extra{
	font-size: 133%; 
    padding: 15px;
    border: 1px #ECE8E8 solid;
    border-bottom: 8px solid #D4D48B;
    border-radius: 0px 6px 6px 10px;
}
.extra:hover{
	background: #FCFAFA;
	border: 1px #EBD3D3 solid;
	border-bottom: 8px solid #F32A72;
}
.extra>span,.extra>span>a:hover{
	font-size: 32px;text-shadow: 2px 2px #EBEBEB;
	text-decoration: none;
}
.progress{
	height: 8px;
}
 </style>




<div class="row">
<div class="span3">
<!--<ul class="nav nav-tabs nav-stacked">
                 <li class="active"><a href="#"></a></li>
                 <li><a href="#"></a></li>
                 <li><a href="#"></a></li>
               </ul>
               -->
               </div>
<div class="span3 extra">
<span><a href="<?php echo base_url().'rtk_management/allocation_zone/a'?>">ZONE A</a></span><br>
<!--<div class="progress progress-info"><div class="bar" style="width: 20%"></div></div>-->
</div>
<div class="span3 extra"><span><a href="<?php echo base_url().'rtk_management/allocation_zone/b'?>">ZONE B</a></span><br></div>
<div class="span3 extra"><span><a href="<?php echo base_url().'rtk_management/allocation_zone/c'?>">ZONE C</a></span><br></div>
<div class="span3 extra"><span><a href="<?php echo base_url().'rtk_management/allocation_zone/d'?>">ZONE D</a></span><br></div>

</div>
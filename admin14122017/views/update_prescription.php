<?php $data['page']=$page; $data['title']='Update Rx'; $this->load->view('layout/header',$data);?>
<!-- PAGE CONTENT WRAPPER -->
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?php echo base_url();?>">Home</a></li> 
    <?php if($page=='two'){ ?>
    <li><a href="<?php echo site_url('PrescriptionControler/show_prescription?pres_id='.$list->prescription_id.'&type=two&user_id='.$user_id);?>">Prescription Request history</a></li>
    <li><a href="<?php echo site_url('PrescriptionControler/show_prescription?pres_id='.$list->prescription_id.'&type=two&user_id='.$user_id);?>">Prescription</a></li>
         <?php } else{?>  
    <li><a href="<?php echo site_url('PrescriptionControler');?>">Prescription Request</a></li>
    <li><a href="<?php echo site_url('PrescriptionControler/show_prescription?pres_id='.$list->prescription_id.'&type=five');?>">Prescription</a></li>
           <?php }?> 

    <li class="active">Update Prescription</li>
</ul>
<!-- END BREADCRUMB -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!--form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<!?php echo site_url('PrescriptionControler/add_prescription?m_id='.$list->m_id.'&u_id='.$list->u_id.'&p_id='.$list->p_id.'&pres_id='.$list->pres_id); ?>"-->
                           <?php if($page=='two'){ ?>
                           <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo site_url('PrescriptionControler/update_prescription?med_id=').$list->id.'&pres_id='.$list->prescription_id.'&type='.$page .'&user_id='.$user_id; ?>"> 
                           <?php } else { ?>
                            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo site_url('PrescriptionControler/update_prescription?med_id=').$list->id.'&pres_id='.$list->prescription_id.'&type='.$page; ?>">
                            <?php } ?>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Update</strong> Rx</h3>
                                </div>
                                <div class="panel-body form-group-separated">
                                    <div class="container">
                            <?php if(isset($error)&& $error==1){?>
                                    <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                     <?php echo $message;?>
                                    </div>
                                    <?php } if(isset($success) && $success==1){?>
                                    <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                     <?php echo $message;?>
                                    </div>
                            <?php } ?>
                            
                            <!--div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label" style="margin-top:15px;">Refill Image
                                </label>
                                <div class="col-md-6 col-xs-12">                      
                                    <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                                   
                                   <?php $image=base_url('tablet_image/'.$list->medicine_image); ?>
                                    <img src="<?php echo $image;?>" width="60px" height="50px">
                                </div>
                            </div-->
                             <input type="hidden" name="img" value="<?php echo $list->medicine_image; ?>">

                            <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Drug Name</label>
                                        <div class="col-md-6 col-xs-12">         
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="medicine" class="form-control" id="medicine" value="<?php echo $list->medicine_name; ?>" required />
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                            <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Manufacturer</label>
                                        <div class="col-md-6 col-xs-12">         
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="company" id="tag" class="form-control" value="<?php echo $list->medicine_company; ?>" required />
                                            </div> 
                                        </div>
                            </div>

                            <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Dosage Form</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="type" class="form-control" value="<?php echo $list->medicine_type; ?>" required />
                                            </div>  
                                        </div>
                            </div>

                                    
                                    

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Day Supply</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                               <input type="text" name="newdays" class="form-control" id="days" onkeyup="my()" value="<?php echo $list->dose_days; ?>"
                                                required />
                                                <input type="hidden" name="olddays" class="form-control"  value="<?php echo $list->dose_days; ?>"> 
                                                <input type="hidden" name="endDate" value=<?php echo  $list->end_date; ?> id="endDate">
                                                <input type="hidden" name="previousendDate" value=<?php echo  $list->end_date; ?>>
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                                    <?php $intTextBox=1;
                                    $date=strtotime($list->timestamp);
                                    $cdate=date('Y-m-d',$date);
                                    foreach ($mtime as $t)  { 
                                        $date = new \DateTime($t->time);
                                        $hour = $date->format('H');
                                        $min  = $date->format('i');
                                        $type = $t->time_type;                                       
                                        ?>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Dose Time <?php echo $intTextBox++; ?></label>
                                        <div class="col-md-2 col-xs-4">                                        
                                            <select class="form-control select" data-size="5" name="hh[]" id="hh" required>
                                                <option value="<?php echo $hour;?>"><?php echo $hour;?></option>
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-xs-4">                                        
                                            <select class="form-control select" data-size="5" name="mm[]"  id="mm" required>
                                                <option value="<?php echo $min;?>"><?php echo $min;?></option>
                                                <option value="00">00</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-xs-4">            
                                            <select class="form-control select" name="tt[]">
                                                <option value="<?php echo $type;?>"><?php echo $type;?></option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id[]" value="<?php echo $t->id;?>">
                                     <?php } ?>




                                    <!--?php  
                                    $intTextBox=1;
                                    $date=strtotime($list->timestamp);
                                    $cdate=date('Y-m-d',$date);
                                    foreach ($mtime as $t)  { ?>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label"><b>Dose Time<php echo $intTextBox++; ?></b></label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="time[]" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="enter correct time like-HH:MM" class="form-control" value="<php echo $t->time; ?>" required />
                                                <input type="hidden" name="id[]" value="<php echo $t->id;?>">
                                                <input type="hidden" name="start_date" value="<php echo $t->dose_date;?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <php } ?-->

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Direction</label>
                                <div class="col-md-6 col-xs-12">         
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" name="prescription" class="form-control" value="<?php echo $list->prescription; ?>" required />
                                        <input type="hidden" name="start_date" value="<?php echo $t->dose_date;?>">
                                    </div> 
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Prescriber Name</label>
                                <div class="col-md-6 col-xs-12">         
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" name="pres_name" value="<?php echo $list->prescriber_name; ?>" class="form-control" required />
                                    </div> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Prescriber Phone Number</label>
                                <div class="col-md-6 col-xs-12">         
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" name="pres_number" value="<?php echo $list->prescriber_number; ?>" class="form-control" required />
                                    </div> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Prescriber Address</label>
                                <div class="col-md-6 col-xs-12">         
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" name="pres_add" value="<?php echo $list->prescriber_address; ?>" class="form-control" required />
                                    </div> 
                                </div>
                            </div> 

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Total Quantity</label>
                            <div class="col-md-3 col-xs-12">   
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="quantity" class="form-control" placeholder="Enter quantity" id="quantity" pattern="\d+" title="Only numbers allow" value="<?php echo $list->total_medicine; ?>" required readonly style="color:black;"/>

                                </div>                             
                            </div>
                            <div class="col-md-3 col-xs-12">  
                                <div class="input-group"> 
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="unit" class="form-control" placeholder="Enter Unit" value="<?php echo $list->unit; ?>" readonly style="color:black;" title="Unit can not change"/>
                                     <input type="hidden" name="remain" value="<?php echo $list->remain_medicine; ?>" id="remain">
                                </div>
                                                              
                            </div>
                        <span style="color:red">Note : Please fill quantity Like: 10 tablets, 100 ml, 10 gm etc.</span>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Date Filled</label>
                            <div class="col-md-6 col-xs-12">         
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" id="from" name="Date_filled" class="form-control" required value="<?php echo $list->Date_filled; ?>" />
                                </div> 
                            </div>
                        </div>

                        <!-- <div class="form-group"> 
                                <label class="col-md-3 col-xs-12 control-label">Total Quantity</label>
                                <div class="col-md-6 col-xs-12">   
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="number" name="quantity" class="form-control" id="quantity" value="<?php echo $list->total_medicine; ?>" required />
                                       
                                    </div>                               
                                </div>
                            </div>-->

                                    <div class="panel-footer">
                                    <input type="hidden" name="user_id" value="<?php echo $list->user_id; ?>">
                                    <input type="hidden" name="pharmasist_id" value="<?php echo $list->pharmacist_id;?>">
                                    <input type="hidden" name="prescription_id" value="<?php echo $list->prescription_id;?>">
                                    
                                    <input type="submit" name="update" value="Update Prescription" class="btn btn-success pull-right">
                            </div>
                            </form>                         
                        </div>
                    </div>  
                    </div>                  
                </div>
                <!-- END PAGE CONTENT WRAPPER --> 
                <?php $dif= $list->total_medicine-$list->remain_medicine; ?>

                <script type="text/javascript">

                    var type='<?php echo $list->remain_medicine; ?>';  
                    function my()
                    {  
                        var count='<?php print(count($mtime)); ?>';
                        //alert(count);   
                        var days=document.getElementById("days").value;
                        var multi=count*days;

                        var remain=multi-'<?php echo $dif; ?>';
                        //var rr=type+parseInt(remain);
                        document.getElementById("quantity").value=multi;
                        document.getElementById("remain").value=remain;
                        Days(days);
                    }

                    function Days(n)
                    {
                        var t = new Date('<?php echo $cdate;?>');
                        
                        var d=t.getDate();
                        //alert(d);
                        t.setDate(t.getDate() + parseInt(n));
                         var date = ((t.getDate() < 10) ?  '0'+t.getDate() : t.getDate())+"-"+(((t.getMonth() + 1) < 10 ) ? '0'+(t.getMonth()+1) : (t.getMonth()+1))+"-"+t.getFullYear();
                         document.getElementById("endDate").value=date;
                        //alert(date);
                    }
                </script> 
<?php $this->load->view('layout/footer');?> 
    
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/south-street/jquery-ui.css"> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script> 

<script>
$('#from').datepicker(
         { 
            minDate: 0,
            beforeShow: function() {
            $(this).datepicker('option', 'maxDate', $('#to').val());
          }
       });

</script>





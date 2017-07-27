

<?php  $data['page']='nine'; $data['title']='Add Renew Prescription'; $this->load->view('layout/header',$data);?>
<!-- PAGE CONTENT WRAPPER -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            
            <!--form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<!?php echo site_url('PrescriptionControler/add_prescription?m_id='.$list->m_id.'&u_id='.$list->u_id.'&p_id='.$list->p_id.'&pres_id='.$list->pres_id); ?>"-->
           <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo site_url('PrescriptionControler/add_renew_prescription?med_id=').$list->id.'&pres_id='.$list->prescription_id; ?>">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Add Renew</strong> Prescription</h3>
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
                    <label class="col-md-3 col-xs-12 control-label">Manufacturer Name</label>
                        <div class="col-md-6 col-xs-12">         
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="company" id="tag" class="form-control" value="<?php echo $list->medicine_company; ?>" required />
                            </div> 
                        </div>
            </div>

            <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Drug Type</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="type" class="form-control" value="<?php echo $list->medicine_type; ?>" required />
                            </div>  
                        </div>
            </div>

            <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label" style="margin-top:15px;">Refill Image
                        </label>
                        <div class="col-md-6 col-xs-12">                      
                            <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                            <input type="hidden" name="img" value="<?php echo $list->medicine_image; ?>">
                           <?php $image=base_url('tablet_image/'.$list->medicine_image); ?>
                            <img src="<?php echo $image;?>" width="60px" height="50px">
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Number of Dose Days</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="newdays" class="form-control" id="days" onkeyup="addDays()" required />

                            <input type="hidden" name="olddays" class="form-control"  value="<?php echo $list->dose_days; ?>"> 

                            <input type="hidden" name="previousendDate" value=<?php echo  $list->end_date; ?>>
                            <input type="hidden" name="endDate" id="endDate">
                            </div>                                            
                            
                        </div>
                    </div>
                    <?php  
                    $intTextBox=1;
                    $date=strtotime($list->timestamp);
                    $cdate=date('Y-m-d',$date);

                    foreach ($mtime as $t)  { ?>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label"><b>Dose Time<?php echo $intTextBox++; ?></b></label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="time[]" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="enter correct time like-HH:MM" class="form-control" value="<?php echo $t->time; ?>" required />
                                <input type="hidden" name="id[]" value="<?php echo $t->id;?>">
                            </div>
                        </div>
                    </div>
                    
                    <?php } ?>

		<div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Dose Direction</label>
                <div class="col-md-6 col-xs-12">         
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="prescription" class="form-control" value="<?php echo $list->prescription; ?>" required />
                    </div> 
                </div>
        </div>  
        <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Total Quantity</label>
            <div class="col-md-3 col-xs-12">   
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                    <input type="text" name="quantity" class="form-control" placeholder="Enter quantity" id="quantity" pattern="\d+" title="Only numbers allow" required />
                </div>                             
            </div>
            <div class="col-md-3 col-xs-12">  
                <div class="input-group"> 
                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                    <input type="text" name="unit" class="form-control" placeholder="Enter Unit" value="<?php echo $list->unit; ?>" required />
                     <input type="hidden" name="remain" value="<?php echo $list->remain_medicine; ?>" id="remain">
                </div>
                                              
            </div>
        <span style="color:red">Note : Please fill quantity Like: 10 tablets, 100 ml, 10 gm etc.</span>
        </div>

        <!-- <div class="form-group"> 
                <label class="col-md-3 col-xs-12 control-label">Total Quantity</label>
                <div class="col-md-6 col-xs-12">   
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="number" name="quantity" class="form-control" id="quantity" value="<!?php echo $list->total_medicine; ?>" required />
                       
                    </div>                               
                </div>
            </div>-->
        <div class="panel-footer">
        <input type="hidden" name="user_id" value="<?php echo $list->user_id; ?>">
        <input type="hidden" name="pharmasist_id" value="<?php echo $list->pharmacist_id;?>">
        <input type="hidden" name="prescription_id" value="<?php echo $list->prescription_id;?>">
        <button class="btn btn-default">Clear Form</button>  
        <input type="submit" name="update" value="Update Prescription" class="btn btn-primary pull-right">
            </div>
            </form>                         
        </div>
    </div>  
    </div>                  
</div>
<!-- END PAGE CONTENT WRAPPER --> 
<?php $dif= $list->total_medicine-$list->remain_medicine; ?>

    <script type="text/javascript">


    function addDays()
    {
        var n=document.getElementById("days").value; 
        var t = new Date();
        t.setDate(t.getDate() + parseInt(n));
         var date = ((t.getDate() < 10) ?  '0'+t.getDate() : t.getDate())+"-"+(((t.getMonth() + 1) < 10 ) ? '0'+(t.getMonth()+1) : (t.getMonth()+1))+"-"+t.getFullYear();
         document.getElementById("endDate").value=date;
        //alert(date);
    }  

          /* var type='<!?php echo $list->remain_medicine; ?>';  
            function my()
            {  
                var count='<!?php print(count($mtime)); ?>';
                //alert(count);   
                var days=document.getElementById("days").value;
                var multi=count*days;

                var remain=multi-'<!?php echo $dif; ?>';
                //var rr=type+parseInt(remain);
                document.getElementById("quantity").value=multi;
                document.getElementById("remain").value=remain;
                Days(days);
            }

            function Days(n)
            {
                var t = new Date('<!?php echo $cdate;?>');
                
                var d=t.getDate();
                //alert(d);
                t.setDate(t.getDate() + parseInt(n));
                 var date = ((t.getDate() < 10) ?  '0'+t.getDate() : t.getDate())+"/"+(((t.getMonth() + 1) < 10 ) ? '0'+(t.getMonth()+1) : (t.getMonth()+1))+"/"+t.getFullYear();
                 document.getElementById("endDate").value=date;
                //alert(date);
            }*/
    </script> 
<?php $this->load->view('layout/footer');?> 






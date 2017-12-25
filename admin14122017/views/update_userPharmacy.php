<?php $data['page']='two'; $data['title']='Add/Update User Pharmacy'; $this->load->view('layout/header',$data);?>

<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Add/Update </strong>Pharmacy</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>

                            <!-- erro display here -->

                            <?php if(isset($error)&& $error==1) { ?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $message;?>
                            </div>
                             <?php } if(isset($success)&& $success==1){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } ?>

                            <!-- erro display end here -->
                                <?php
                                if($userlist!='')
                                { ?>
                                
                            <form action="<?php echo site_url('/user/userPharmacy?id='.$user_id);?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="panel-body form-group-separated">
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Pharmacy Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="pharmacy_name" class="form-control" value="<?php echo $userlist->pharmacy_name;?>"/>
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">city</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="city" class="form-control" value="<?php echo $userlist->city;?>"/>
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Cross Street</label>
                                        <div class="col-md-6 col-xs-12">       
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="street" class="form-control" value="<?php echo $userlist->cross_street;?>"/>
                                            </div>                                           
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Contact Number</label>
                                        <div class="col-md-6 col-xs-12">       
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="contactno" class="form-control" value="<?php echo $userlist->contactNo;?>"/>
                                            </div>                                           
                                        </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                    <input type="hidden" name="id" value="<?php echo $userlist->id;?>">
                                    <input type="reset" class="btn btn-danger" value="Form Reset" style="width:250px;">
                                    <input type="submit" name="update" value="Update" class="btn btn-success pull-right" style="width:250px;">
                                </div>
                              </div>
                            </form>
                            <?php  } else  { ?>                                


                            <form action="<?php echo site_url('/user/userPharmacy?id='.$user_id);?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="panel-body form-group-separated">
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Enter Pharmacy Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="pharmacy_name" class="form-control"/>
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Enter city</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="city" class="form-control"/>
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Enter Cross Street</label>
                                        <div class="col-md-6 col-xs-12">       
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="street" class="form-control"/>
                                            </div>                                           
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Contact Number</label>
                                        <div class="col-md-6 col-xs-12">       
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="contactno" class="form-control"/>
                                            </div>                                           
                                        </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                    <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                                    <input type="reset" class="btn btn-danger" value="Form Reset" style="width:250px;">
                                    <input type="submit" name="add" value="Add Pharmacy" class="btn btn-success pull-right" style="width:250px;">
                                </div>
                              </div>
                            </form>
                            <?php  } ?>                          
                        </div>
                    </div>                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
 
<?php $this->load->view('layout/footer');?> 
    






<!--?php if(isset($error)){echo $message;die();}?--> 
<?php $data['page']='four'; $data['title']='Add Pharmacy'; $this->load->view('layout/header',$data);?>
<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Add</strong>&nbsp;Pharmacy</h3>
                            <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="container">
                                <form method="post" action="<?php echo site_url('pharmacy/insert_pharmacy');?>" class="form-horizontal" enctype="multipart/form-data">
                                <div class="panel-body form-group-separated">
                                    
                            <?php if(isset($error)&& $error==1) { ?>
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } if(isset($success)&& $success==1){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php }?>

							        <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Enter Pharmacy Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="pharmacy_name" class="form-control" required /> 
                                            </div>             
                                        <span><?php echo form_error('name');?></span>                              
                                         </div>
                                    </div>

									<div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Pharmacy Address</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="address" class="form-control" required />
                                            </div>                                            
                                                <span><?php echo form_error('address');?></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">City/Town Name</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="city" class="form-control" required />
                                            </div>                                            
                                                <span><?php echo form_error('address');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Zipcode</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="zipcode" class="form-control" required />
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label"> Full Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="name" class="form-control" pattern="[a-zA-Z\s]+" maxlength="35" required /> 
                                            </div>             
                                        <span><?php echo form_error('name');?></span>                              
                                         </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label"> Father Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="father_name" class="form-control" pattern="[a-zA-Z\s\^.]+" maxlength="35" required /> 
                                            </div>             
                                        <span><?php echo form_error('name');?></span>                              
                                         </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Highest Educational Qualification</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="qualification" class="form-control" required />
                                            </div>                                            
                                                <span><?php echo form_error('address');?></span>
                                        </div>
                                    </div>


									<div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Enter Mobile Number</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="mobile_no" class="form-control" pattern="\d{10}" maxlength="10" title="Please enter exactly 10 digits" required />
                                            </div>                                            
                                                <span><?php echo form_error('mobile_no');?></span>
                                            </div>
                                    </div>

                                  
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Email Id</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="email" name="email" class="form-control" required />
                                            </div>                                            
                                        </div>
                                    </div>


                                    <div class="panel-footer">
                                    <input type="reset" class="btn btn-success" value="Form Reset" style="max-width:300px; margin:5px 0; width:100%;">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success pull-right" style="max-width:300px; margin:2px 0; width:100%;">
                                    </div>
                             </div>
                            </form>                         
                        </div>
                    </div>                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
 
<?php $this->load->view('layout/footer');?> 
    






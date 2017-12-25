
<?php $data['page']='two'; $data['title']='Add User'; $this->load->view('layout/header',$data);?>
<!-- PAGE CONTENT WRAPPER -->

                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Add</strong>&nbsp;User</h3>

                            <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                        <div class="container">  
                                    
                            <?php if(isset($error)&& $error==1) { ?>
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } if(isset($error)&& $error==2){?>
                            <div class="alert alert-dnager">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } if(isset($error)&& $error==3){?>
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php }if(isset($success)&& $success==2){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php }?>
                            <form method="post" action="<?php echo site_url('user/add_user');?>" class="form-horizontal" enctype="multipart/form-data" name="frm">
                                <div class="panel-body form-group-separated">

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">First Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="first_name" class="form-control" pattern="[a-zA-Z\s]+" title="Only alphabets are allowed"> 
                                            </div>             
                                       <span style="color:red; font-size:12px;"><?php echo form_error('first_name');?>                              
                                         </div>
                                    </div>


				            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Last Name</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="last_name" class="form-control" pattern="[a-zA-Z\s]+" title="Only alphabets are allowed"/>
                                            </div>                                            
                                            <span style="color:red; font-size:12px;"><?php echo form_error('last_name');?></span>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">E-mail</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>                                            
                                                <span  style="color:red; font-size:12px;"><?php echo form_error('email');?></span>
                                        </div>
                                    </div>
                                    

                                    <div class="form-group">                                        
                                        <label class="col-md-3 col-xs-12 control-label">Password</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password" name="password" class="form-control" minlength="8"/>
                                            </div>            
                                                <span style="color:red; font-size:12px;"><?php echo form_error('password');?></span>
                                        </div>
                                    </div>


                                    <div class="form-group">            
                                        <label class="col-md-3 col-xs-12 control-label">Confirm Password</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password" name="confirm_password" class="form-control"/>
                                                 </div>            
                                                <span style="color:red; font-size:12px;"><?php echo form_error('confirm_password');?></span>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Mobile Number</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="mobile_no" class="form-control" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits"/>
                                            </div>                                            
                                                <span style="color:red; font-size:12px;"><?php echo form_error('mobile_no');?></span>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Gender</label>
                                        <div class="col-md-6 col-xs-12">                     
                                           <select required name="gender" class="form-control">
                                              <option value="">Select</option>
                                              <option value="male">Male</option>
                                              <option value="female">Female</option>
                                            </select>
                                        </div>
                                            
                                    </div>


                                    <!--div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Zipcode</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="address" class="form-control"/>
                                            </div>                                            
                                                <span style="color:red; font-size:12px;"><!?php echo form_error('address');?></span>
                                        </div>
                                    </div-->


                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Image</label>
                                        <div class="col-md-6 col-xs-12">                      
                                            <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                                        </div>
                                    </div>

                                    <div class="panel-footer" style="margin-top:20px;">
                                    <div class="row">
                                    <div class="col-md-6">
                                        <input type="reset" class="btn btn-success" value="Form Reset" style="margin:5px 0; max-width:300px; width:100%;">
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-success pull-right" style="max-width:300px; margin:2px 0; width:100%;">
                                    </div>
                                    
                                </div>
                                   
                                </div>
                            </div>
                            </form>                         
                        </div>
                    </div>
                </div>                    
             </div>
                <!-- END PAGE CONTENT WRAPPER -->  
 
<?php $this->load->view('layout/footer');?> 
    






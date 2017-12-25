<?php $data['page']='two'; $data['title']='Update User Record'; $this->load->view('layout/header',$data);?>
<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Update</strong>&nbsp;User</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                       <!-- error display here -->
                        <div class="container">
                            <?php if(isset($error)&& $error==1) { ?>
                            <div class="alert alert-success" style="max-width:300px; width:100%;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $message;?>
                            </div>
                             <?php } if(isset($error)&& $error==2){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $message;?>
                            </div>
                            <?php } if(isset($success)&& $success==1){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } if(isset($success)&& $success==2){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } ?>
                            <!-- erro display end here -->
                                <form action="<?php echo site_url('/user/user_update?id='.$userlist->id);?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="panel-body form-group-separated">
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">First Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="first_name" class="form-control" value="<?php echo $userlist->first_name;?>" pattern="[a-zA-Z\s]+" title="Only alphabets are allowed" required/>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Last Name</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="last_name" class="form-control" value="<?php echo $userlist->last_name;?>" pattern="[a-zA-Z\s]+" title="Only alphabets are allowed" required />
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">E-mail</label>
                                        <div class="col-md-6 col-xs-12">       
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="email" name="email" class="form-control" value="<?php echo $userlist->email;?>" required readonly style="
                                                color:black"/>
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Mobile Number</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="mobile_no" class="form-control" value="<?php echo $userlist->phone;?>" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" required/>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Gender</label>
                                        <div class="col-md-6 col-xs-12">                     
                                            <select required class="form-control" name="gender">
                                                <option value="">Select</option>
                                                <option value="male"<?php if($userlist->gender=='male') echo 'selected="selected"';?>>Male</option>
                                                <option value="female" <?php if($userlist->gender=='female') echo'selected="selected"';?>>Female</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Address</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="address" class="form-control" value="<?php echo $userlist->address;?>"/>
                                            </div>                                            
                                            
                                        </div>
                                    </div>
                                    <!--div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Zipcode</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="zipcode" class="form-control" value="<!?php echo $userlist->zipcode;?>" required/>
                                                
                                            </div>                                            
                                            
                                        </div>
                                    </div-->
                                    <input type="hidden" name="id" value="<?php echo $userlist->id;?>" required/>
                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Photo</label>
                                        <div class="col-md-6 col-xs-12">                      
                                            <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file" accept="image/jpeg"/>
                                        </div>
                                    </div>
                                    <div class="panel-footer" style="margin-top:20px;">
                                    <div class="row">
                                     <input type="reset" class="btn btn-success" value="Form Reset" style="max-width:300px; width:100%;">
                                    <input type="submit" name="update" value="Update" class="btn btn-success pull-right" style="margin:3px 0; max-width:300px; width:100%;">
                                </div>
                              </div>
                            </form>                         
                        </div>
                    </div>
                </div>                    
            </div>
                <!-- END PAGE CONTENT WRAPPER -->  
 
<?php $this->load->view('layout/footer');?> 
    






<!--?php if(isset($error)){echo $message;die();}?--> 
<?php $data['page']='three'; $data['title']='Pharmacist Update'; $this->load->view('layout/header',$data);?>
<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Update</strong>&nbsp;Pharmacist</h3>
                            <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="container">
                                <form method="post" action="<?php echo site_url('Pharmacist/update_pharmacist?id='.$pharma->id);?>" class="form-horizontal" enctype="multipart/form-data">
                                <div class="panel-body form-group-separated">
                                    
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
                            <?php }?>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Full Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="hidden" name="id" value="<?php echo $pharma->id; ?>">
                                                <input type="text" name="name" class="form-control" value="<?php echo $pharma->name; ?>" required /> 
                                            </div>                                           
                                         </div>
                                    </div>

                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">License Number</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="licenseNumber" value="<?php echo $pharma->licenseNumber; ?>" class="form-control" required /> 
                                            </div>                                      
                                         </div>
                                    </div>


									<div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Mobile Number</label>
                                        <div class="col-md-6 col-xs-12">                     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="phone" class="form-control" value="<?php echo $pharma->phone; ?>" pattern="\d{10}" title="enter exactly 10 digit"/>
                                            </div>                                            
                                            </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Address</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="address" class="form-control" value="<?php echo $pharma->address; ?>" required/>
                                            </div>                                            
                                                <span><?php echo form_error('address');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Email Id</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="email" name="email" class="form-control" value="<?php echo $pharma->email; ?>" style="color:black;" readonly/>
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                    <div class="row">
                                    <input type="reset" class="btn btn-success" value="Form Reset" style="max-width:300px; width:100%;">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success pull-right" style="max-width:300px; width:100%; margin:3px 0">
                                    </div>
                            </div>
                            </form> 
                            </div>                        
                        </div>
                    </div>                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
 
<?php $this->load->view('layout/footer');?> 
    






 
<?php $this->load->view('layout/header');?>
<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Add</strong>Medicine</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="panel-body">
                                 <?php if(isset($error)&& $error==1){?>
                                    <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                     <?php echo $message;?>
                                    </div>
                                    <?php }if(isset($success)&& $success==1){?>
                                    <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                     <?php echo $message;?>
                                    </div>
                                    <?php }?>
                                <div class="panel-body form-group-separated">
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Medicine Name</label>
                                        <div class="col-md-6 col-xs-12">     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name=
                                                "name"/>
                                            </div>
                                           <span style="color:red; font-size:16px;"><?php echo form_error('name');?></span>
                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Price</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="number" name="price" class="form-control" pattern="\d[1-9]" maxlength="10"/>
                                            </div>
                                            <span style="color:red; font-size:16px;"><?php echo form_error('price');?></span>  
                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Status</label>
                                        <div class="col-md-6 col-xs-12">                     
                                           <select required name="status" class="form-control">
                                              <option value="">Select</option>
                                              <option value="Ready">Ready</option>
                                              <option value="Inactive">Inactive</option>
                                              <option value="verification_soon">verification_soon</option>
                                            </select>
                                        </div>
                                            
                                    </div>

                                    

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Remain</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="number" class="form-control" name="remain" title="Enter only digit" />
                                            </div>                
                                            <span style="color:red; font-size:16px;"><?php echo form_error('remain');?></span> 
                                        </div>
                                    </div>
                                    

                                    <div class="form-group">                                  
                                        <label class="col-md-3 col-xs-12 control-label">Side Effect</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name="side_effect"/>
                                            </div> 
                                            <span style="color:red; font-size:16px;"><?php echo form_error('side_effect'); ?></span>    
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Tablet Image</label>
                                        <div class="col-md-6 col-xs-12">                      
                                            <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                                        </div>
                                    </div>
                                    
                                <div class="panel-footer">
                                    <input type="reset" value="Reset" class="btn btn-primary">
                                    <input type="submit" name="submit" value="Add" class="btn btn-primary pull-right">
                                </div>

                            </div>
                            </form>                         
                        </div>
                    </div>                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
 
<?php $this->load->view('layout/footer');?> 
    






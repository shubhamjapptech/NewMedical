<?php  $data['page']='six'; $data['title']='Admin Profile'; $this->load->view('layout/header',$data);?>
<div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Profile</strong></h3>
                            <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="container-fluid">
                                <form method="post" action="<?php echo site_url('admin/admin_profile'); ?>" class="form-horizontal" enctype="multipart/form-data">
                                <div class="panel-body form-group-separated">
                                    
                            <?php if(isset($error)&& $error==1) { ?>
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } if(isset($error)&& $error==2) { ?>
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php } if(isset($error)&& $error==3) { ?>
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
                                        <label class="col-md-3 col-xs-12 control-label">Name</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="hidden" name="status" value="<?php echo $admin->status;?>">
                                                <input type="hidden" name="id" value="<?php echo $admin->id;?>">
                                                <input type="text" name="name" value="<?php echo $admin->name;?>" class="form-control"/>
                                            </div>            
                                                <span style="color:red; font-size:16px;"><?php echo form_error('old_password');?></span>
                                        </div>
                                </div>


                                    <div class="form-group">                                   
                                        <label class="col-md-3 col-xs-12 control-label">Email</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <span class="fa fa-envelope" ></span></span>
                                                <input type="email" name="email" value="<?php echo $admin->email; ?>" style="color:black;" class="form-control" readonly/>
                                            </div>            
                                                <span style="color:red; font-size:16px;"><?php echo form_error('password');?></span>
                                        </div>
                                    </div>


                                    <div class="form-group">            
                                        <label class="col-md-3 col-xs-12 control-label">Mobile Number</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-mobile"></span></span>
                                                <input type="text" name="mobile" value="<?php echo $admin->mobile; ?>" class="form-control" required/>
                                                 </div>            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Profile Image</label>
                                        <div class="col-md-6 col-xs-12">                      
                                            <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                                            <img src="<?php echo base_url('image/'.$admin->image);?>" style="width:80px; height: 80px;">
                                            <input type="hidden" name="admin_img" value="<?php echo $admin->image; ?>">
                                        </div>
                                    </div>
                                <div class="panel-footer">
                                    <div class="row">
                                    <input type="reset" class="btn btn-success" value="Form Reset" style="width:100%; max-width:300px;">                                   
                                    <input type="submit" name="submit" value="Update" class="btn btn-success pull-right" style="width:100%; max-width:300px; margin-top:5px">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>                         
                    </div>
                </div>                    
            </div>

<?php $this->load->view('layout/footer');?> 
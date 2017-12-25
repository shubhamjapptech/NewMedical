<?php $data['page']='two'; $this->load->view('layout/header',$data);?>
<div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Update</strong> Family Member</h3>
                            <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                             <div class="container">   
                                <form method="post" action="<?php echo site_url('family_member/update_member?id='.$id);?>" class="form-horizontal" enctype="multipart/form-data">
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
                                        <label class="col-md-3 col-xs-12 control-label">Enter First Name</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                                <input type="text" name="first_name" value="<?php echo $member_list->first_name; ?>" class="form-control" pattern="[a-zA-Z\s]+" title="Only alphabets are allowed" required/>
                                            </div>            
                                                <span style="color:red; font-size:16px;"><?php echo form_error('first_name');?></span>
                                        </div>
                                </div>


                                    <div class="form-group">                                   
                                        <label class="col-md-3 col-xs-12 control-label">Enter Last_name</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <span class="fa fa-unlock-alt"></span></span>
                                                <input type="text" name="last_name" value="<?php echo $member_list->last_name; ?>" class="form-control" pattern="[a-zA-Z\s]+" title="Only alphabets are allowed" required/>
                                            </div>            
                                                <span style="color:red; font-size:16px;"><?php echo form_error('last_name');?></span>
                                        </div>
                                    </div>


                                    <div class="form-group">            
                                        <label class="col-md-3 col-xs-12 control-label">Enter Date Of Birth</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                                <input type="text" name="dob" class="form-control datepicker" value="<?php echo $member_list->dob; ?>" required />
                                                 </div>            
                                                <span style="color:red; font-size:16px;"><?php echo form_error('dob');?></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label" style="margin-top:15px;">Image
                                        </label>
                                        <div class="col-md-6 col-xs-12">                      
                                            <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                                            <input type="hidden" name="img" value="<?php echo $member_list->image;?>">
                                            <img src="<?php echo base_url('family_member_image/').$member_list->image;?>" width="80px" height="80px">
                                        </div>
                                    </div>


                                <div class="panel-footer">
                                     <div class="row">
                                        <input type="reset" class="btn btn-success" value="Form Reset" style="width:100%; max-width:300px;">
                                        <input type="submit" name="submit" value="Update" class="btn btn-success pull-right" style="width:100%; max-width:300px; margin:2px 0">
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>                         
                    </div>
                </div>                    
            </div>

<?php $this->load->view('layout/footer');?> 
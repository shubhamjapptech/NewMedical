<?php $this->load->view('layout/header');?>                                  
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">    
                <div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span>Update User Record</h2>
                </div>  
                <form action="<?php echo site_url();?><?php if(isset($userlist)) {echo "/user/user_update";} else {"/user/add_user";}?>" method="post">
                    <table class="table" style="color:solid black; font-size:18px;">  
                        <tr>
                            <td class="col-md-4">First Name</td>
                            <td><input type="text" name="fname" class="col-form-control col-md-7" value="<?php if(isset($userlist)) { echo $userlist->first_name;}?>"></td>
                        </tr>
                        <tr>
                            <td class="col-md-4">Last Name</td>
                            <td><input type="text" name="lname" class="col-md-7 col-form-control" value="<?php if(isset($userlist)) { echo $userlist->last_name;}?>"></td>
                        </tr>
                        <tr>
                            <td class="col-md-3">Mobile Number</td>
                            <td><input type="text" name="mobile" class="col-md-7 col-form-control"
                            value="<?php if(isset($userlist)) { echo $userlist->phone;}?>"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" name="email" class="col-md-7 col-form-control" value="<?php if(isset($userlist)) { echo $userlist->email;}?>"></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td class="col-md-3 ">
                                <select name="g" class="col-md-7 col-form-control">
                                    <option>Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-5">Address</td>
                            <td><input type="text" name="add" class="col-md-7 col-form-control" value="<?php if(isset($userlist)) { echo $userlist->address;}?>"></td>
                        </tr>
                        <tr>
                            <td class="col-md-5">Select Photo</td>
                            <td><input type="file" name="image" class="col-md-7 btn-block"></td>
                        </tr>
                        <tr>
                            <input type="hidden" name="id" value="<?php if(isset($userlist)) { echo $userlist->id;}?>" class="">
                            <td></td>
                            <td class="col-md-5">
                                <input type="submit" name="update" value="Update" class="btn btn-info btn-block" style="width:150px;">
                            </td>
                        </tr>

                          
                    </table>  
                </div>
                <!-- END PAGE CONTAINER -->
<?php $this->load->view('layout/footer');?> 







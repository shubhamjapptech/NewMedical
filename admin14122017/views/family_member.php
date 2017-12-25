<?php $data['page']='two'; $this->load->view('layout/header',$data);?>
<div class="page-content-wrap">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Family</strong> Member</h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                                  <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/xls.png' width="24"/> XLS</a></li>
                                            
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'png',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/png.png' width="24"/> PNG</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'pdf',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                </div>
                                
                            <div class="panel-body">
                                <div class="table-responsive">
                            

                                    
                                      <table id="customers2" class="table datatable"> 
                                        <thead>
                                          <tr>
                                              <th>Sr.No</th>
                                              <th>First Name</th>
                                              <th>Last Name</th>
                                              <th>Date of birth</th>
                                              <th>Created_at</th>
                                              <th>Image</th>
                                              <th>Edit</th>
                                              <th>Delet</th>
                                          </tr>
                                        </thead>  

                            <?php if(isset($error)&& $error==1) { ?>
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <center><?php echo $message;?></center>
                            </div>
                            <?php } if(isset($success)&& $success==1){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <center><?php echo $message;?></center>
                            </div>
                            <?php } if(isset($member_list)){
                                    $i=1;  
                                          foreach($member_list as $list) {?>
                                            <tr>
                                                  <td><?php echo $i++;?></td>
                                                  <td><?php echo $list->first_name;?></td>
                                                  <td><?php echo $list->last_name;?></td>
                                                  <td><?php echo $list->dob;?></td>
                                                  <td><?php echo $list->timestamp;?></td>         
                                                  <td>
                                                    <img src="<?php echo base_url('family_member_image/').$list->image;?>" width="60px" height="60px">
                                                  </td>
                                                  <td>
                                                       <a href="<?php echo site_url('family_member/update_member?id='.$list->id);?>">
                                                       <i class="fa fa-pencil fa-fw"><strong>Edit</strong></i></a>
                                                    </td>
                                                     <td>
                                                         <a href="<?php echo site_url('family_member/delete_member?f_id='.$list->id.'&u_id='.$u_id);?>">
                                                          <i class="fa fa-trash-o fa-fw">
                                                          <strong>Delete</strong></i>
                                                         </a>
                                                    </td>
                                          <?php }}
                                            ?>
                                            
                                            </table>                                                                     
                                    </div>
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->
                        </div>
                    </div>
                </div>


<?php $this->load->view('layout/second_footer');?>
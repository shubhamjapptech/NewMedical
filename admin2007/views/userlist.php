<?php $data['page']='two'; $data['title']='User List'; $this->load->view('layout/header',$data);?>
          
            <!-- PAGE CONTENT WRAPPER -->

                <div class="page-content-wrap">

                  <div class="row">

                        <div class="col-md-12">

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h3 class="panel-title"><strong>Registred</strong> User</h3>
                                                                         
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



                                    <?php if(isset($sucess)==1){ ?>

                                    <div class="alert alert-success">

                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                    <?php echo $message;?>

                                    </div>        

                                    <?php } else if(isset($error)==1) { ?>

                                    <div class="alert alert-danger">

                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                    <?php echo $message;?>

                                    </div>

                                    <?php }?>     

                                </div>                                

                                <div class="panel-body">

                                    <div class="table-responsive">
                                     <div style="overflow:scroll; height:600px;">
                                     <table id="customers2" class="table datatable">

                                        <thead>

                                            <tr>

                                        <th>Sr.No</th>

                                            <th>First Name</th>

                                            <th>Last Name</th>

                                            <th>Mobile No.</th>

                                            <th>Email</th>

                                            <th>Address</th>

                                            <!-- <th>ZipCode</th> -->

                                            <th>Image</th>
                                            <th>Pharmacy Name</th>
                                            <th>City</th>
                                            <th>Cross Street</th>
                                            <th>Pharmacy Mobile</th>
                                            <th>Creat_At</th>

                                            <th style="min-width:50px; text-align:center">Edit</th>

                                            <th style="min-width:50px; text-align:center">Edit Pharmacy</th>


                                            <th style="min-width:50px; text-align:center">Delete</th>

                                        </tr>

                                        </thead>

                                        <tbody>

                                        <?php

                                          $i=1;  

                                        foreach($userlist as $list) { ?>

                                            <tr>

                                                <td style="text-align:center"><?php echo $i++;?></td>
                                                
                                                <td><?php echo $list->first_name;?></td>

                                                <td><?php echo $list->last_name;?></td>

                                                <td><?php echo $list->phone;?></td>

                                                <td><?php echo $list->email;?></td>

                                                <td><?php echo $list->address;?></td>

                                                <!--td><!?php echo $list->zipcode;?></td-->

                                                <td>
                                                <?php if($list->image_type==0)
                                                {
                                                    echo "<img src=".base_url()."image/".$list->image." width='60px' height='60px'>";    
                                                }
                                                else
                                                {
                                                    echo "<img src=".$list->image." width='60px' height='60px'>"; 
                                                }
                                                ?>
                                                    
                                                </td>
                                                <td>
                                                    <?php
                                                    foreach($user_pharmacy as $pharma)
                                                    { if($pharma->user_id==$list->id)
                                                    { echo $pharma->pharmacy_name;} } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    foreach($user_pharmacy as $pharma)
                                                    { if($pharma->user_id==$list->id)
                                                    { echo $pharma->city;} } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    foreach($user_pharmacy as $pharma)
                                                    { if($pharma->user_id==$list->id)
                                                    { echo $pharma->cross_street;} } ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    foreach($user_pharmacy as $pharma)
                                                    { if($pharma->user_id==$list->id)
                                                    { echo $pharma->contactNo;} } ?>
                                                </td>    
                                                                                     
                                                <td><?php $t=$list->timestamp;
												         $s=explode(" ",$t);
    													 $e=implode(" / ",$s);
														 echo $e; ?>
                                                </td>

                                                <td>
                                                    <a href="<?php echo site_url('user?id='.$list->id);?>">
                                                    <i class="fa fa-pencil fa-fw">
                                                    <strong>Edit</strong>
                                                    </i></a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url('user/userPharmacy?id='.$list->id);?>">
                                                    <i class="fa fa-pencil fa-fw">
                                                    <strong>Edit Pharmacy</strong>
                                                    </i></a>
                                                </td>

                                                    <td>

                                                     <a href="<?php echo site_url('user/delete_user?id='.$list->id);?>">

                                                      <i class="fa fa-trash-o fa-fw">

                                                      <strong>Delete</strong></i>

                                                     </a>

                                                 </td>

                                          </tr>

                                        <?php } ?>

                                        </tbody>

                                    </table> 
                                    </div>                                   

                                    </div>

                                </div>

                            </div>

                            <!-- END DATATABLE EXPORT -->

                        </div>

                    </div>

                </div>         



                <!-- END PAGE CONTENT WRAPPER -->

<?php $this->load->view('layout/second_footer');?> 
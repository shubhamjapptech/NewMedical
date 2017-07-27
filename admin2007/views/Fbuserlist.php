<?php $data['page']='two'; $this->load->view('layout/header',$data);?>
          
            <!-- PAGE CONTENT WRAPPER -->

                <div class="page-content-wrap">

                  <div class="row">

                        <div class="col-md-12">

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h3 class="panel-title"><strong>Facebook Login</strong>User</h3>
                                                                         
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



                                    <?php if(isset($success)==1){ ?>

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
                                           <th>Facebook Id</th>
                                            <th>Creat_At</th>
                                            <th style="min-width:50px; text-align:center">Delete</th>
                                        </tr>

                                        </thead>

                                        <tbody>

                                        <?php

                                          $i=1;  

                                        foreach($userlist as $list) { ?>

                                            <tr>

                                                <td style="text-align:center"><?php echo $i++;?></td>
                                                <td><?php echo $list->fb_id;?></td>                                               
                                                <td><?php $t=$list->timestamp;
												         $s=explode(" ",$t);
														 $e=implode(" / ",$s);
														 echo $e; ?>   
                                                </td>
                                                <td>

                                                     <a href="<?php echo site_url('user/delete_fbuser?id='.$list->id);?>">

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
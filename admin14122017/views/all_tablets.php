
<?php $this->load->view('layout/header');?>
<div class="page-content-wrap">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>All</strong>Medicine</h3>
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
                                            <th>tablet_name</th>
                                            <th>tablet_prise</th>
                                            <th>status</th>
                                            <th>remain</th>
                                            <th>side_effect</th>
                                            <th>tablet_image</th>
                                            <th class="col-md-1">timestamp</th>
                                            <th>Edit</th>
                                            <th>Delet</th>
                                           </tr>
                                        </thead>             
                                      <?php if(isset($error) && $error==1) {?>
                                       <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message; ?>
                                        </div>
                                       <?php } if(isset($err) && $err==2) {?> 
                                       <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
                                        </div>
                                       <?php } if(isset($success) && $success==1) {?> 
                                       <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
                                        </div>
                                        <?php } ?>
                                        <?php if(isset($err) && $err==1) {?> 
                                       <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
                                        </div>
                                         <?php } if(isset($tablets) && $tablets!='') { 
                                          $i=1;  
                                          foreach($tablets as $list) {?>
                                            <tr>
                                                  <td><?php echo $i++;?></td>
                                                  <td><?php echo $list->tablet_name;?></td>
                                                  <td><?php echo $list->tablet_prise;?></td>
                                                    <td><?php echo $list->status;?></td>
                                                    <td><?php echo $list->remain;?></td>
                                                    <td><?php echo $list->side_effect;?></td>
                                                    <td><?php echo "<img src=".base_url()."tablet_image/".$list->tablet_image." width='60px' height='60px'>";?>
                                                    </td>
                                                  <td><?php echo $list->created_at;?></td>
                                                  <td>
                                       <a href="<?php echo site_url('tablet/medicine_update?t_id='.$list->id.'&p_id='.$list->pharmacist_id);?>">
                                       <i class="fa fa-pencil fa-fw"><strong>Edit</strong></i></a>
                                             </td>
                                             <td>
                                                 <a href="<?php echo site_url('tablet/medicine_delete?t_id='.$list->id.'&p_id='.$list->pharmacist_id);?>">
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

<?php $data['page']='seven'; $data['title']='Pharmacist All Prescription'; $this->load->view('layout/header',$data);?>
<style type="text/css">
    td,th{
        text-align:center;
    }
</style>
<div class="page-content-wrap">

                  <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>All Prescription</strong></h3>
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
                                                <th>#</th>
                                                <th>Medication</th>
                                                <th>Manufacturer</th>
                                                <th>Type</th>
                                                <th>Directions</th>
                                                <th>Quantity</th>
                                                <th>Remaining Quantity</th>
                                                <th>Refills</th>     <!-- New -->
                                                <th>Refills Remaining</th>
                                                <!-- <th>Status</th> -->
                                                <th>Prescriber</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Update Prescription</th>
                                                <th>Delet Prescription</th>
                                            </tr>
                                        </thead>             
                                    	<?php if(isset($error) && $error==1) {?>
					                             <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message; ?>
                                        </div>
                                       <?php } if(isset($success) && $success==1) {?> 
                                       <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
                                        </div>
                                        <?php } if(isset($success) && $success==2) {?> 
                                       <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
                                        </div>
                                        <?php } if(isset($prescription1) && $prescription1!='') { 
					                                $i=1;  
                                        	foreach($prescription1 as $list) {?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $list->medicine_company;?></td>
                                                    <td><?php echo $list->medicine_name;?></td>
                                                    <td><?php echo $list->medicine_type;?></td>
                                                    <td><?php echo $list->prescription;?></td>
                                                    <td><?php echo $list->total_medicine; ?></td>
                                                    <td><?php echo $list->remain_medicine; ?></td>
                                                    <td><?php echo $list->total_refill;  ?></td>
                                                    <td><?php echo $list->refill_remain; ?></td>
                                                    <td><?php echo $list->prescriber_name.'<br>';
                                                              echo $list->prescriber_address.'<br>';
                                                              echo $list->prescriber_number;
                                                            ?>
                                                    </td>
                                                    <td><?php echo date('m-d-Y',strtotime($list->timestamp));?>
                                                    </td>
                                                    <td><?php echo date('m-d-Y',strtotime($list->end_date));?></td>
                                                    
                                                    <!--td-->
                                                    <!--?php foreach ($prescription as $time) { 
                                                           echo "<strong>".$time->time;
                                                           echo "/</strong>";      
                                                       } ?> </td-->
                                                    
                                                    <!--td><!?php echo $list->status;?></td-->
                                      <td style="color: blue;"> 
                                        <?php 
                                            $today=date('d-m-Y');            
                                            if(strtotime($list->end_date)>=strtotime($today))
                                            {  ?>

                                            <a href="<?php echo site_url('PrescriptionControler/update_prescription?med_id='.$list->id.'&pres_id='.$list->prescription_id.'&type=seven&user_id='.$list->user_id);?>">
                                            <i class="fa fa-pencil fa-fw"><strong>Edit Prescription</strong></i></a>
                                            <?php } else { echo "<center><strong>Date Expired</strong><center>";}?>
                                      </td>
                                      
                                        <td>
                                         <a href="<?php echo site_url('PrescriptionControler/delete_prescription1?id='.$list->id.'&pres_id='.$list->prescription_id.'&p_id='.$list->pharmacist_id);?>">
                                                      <i class="fa fa-trash-o fa-fw">
                                                      <strong>Delete</strong></i>
                                         </a>
                                        </td>

                                            <?php }} ?>
                                            </table>
                                        		
                                                                       
                                    </div>
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->
                        </div>
                    </div>
                </div>


<?php $this->load->view('layout/second_footer');?>
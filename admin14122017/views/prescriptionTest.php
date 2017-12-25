
<?php $this->load->view('layout/header');?>
<style>
.myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
<div class="page-content-wrap">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Prescription</strong>Request</h3>
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
                                        <?php } ?>
                                <div class="panel-body">
                                    <div class="table-responsive">  
                                    <div style="overflow:scroll; height:660px;">
                                        <table id="customers2" class="table datatable"> 
                                        <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>Pharmacy Name</th>
                                                <th>Member Name/User Name</th>
                                                <th>Status</th>
                                                <th>Refill Image</th>
                                                <th>Insurance Image</th>
                                                <th>Bar Code</th>
                                                <th>Requist Date-Time</th>
                                                <?php if($this->session->userdata('status')=='admin'){ ?>
                                                <th>Assign Pharmacist</th>
                                                <th style="text-align:center">Assigned Pharmacist Name</th>
                                                <?php } ?>
                                                <th>Add Prescription</th>
                                                <th>Show Prescription</th>
                                           </tr>
                                        </thead>             
                                         <?php  if(isset($image) && $image!='') { 
                                                    $i=1;  
                                            foreach($image as $list) {?>
                                                <tr>
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $list->pharmacy_name;?></td>
                                                    <td><?php echo $list->first_name.'&nbsp;&nbsp;'.$list->last_name; ?></td>
                                                    <td><?php echo $list->status;?></td>
                                                  



											<td>               
											 <img id="apptech<?php echo $i;?>" src="<?php echo base_url('insuranceImage/').$list->insurance_image; ?>" alt="Trolltunga, Norway" width="60" height="60">
											<!-- The Modal -->
											<div id="apptech_i<?php echo $i;?>" class="modal">
											  <span onclick="toggle_visibility('apptech_i<?php echo $i;?>');" class="close" data-dismiss="modal">&times;</span>
											  <img class="modal-content" id="app_ii<?php echo $i;?>">
											  <div id="caption"></div>
											</div>

											<script>
											var modal = document.getElementById('apptech_i<?php echo $i; ?>');
											var img = document.getElementById('apptech<?php echo $i; ?>');
											var modalImg = document.getElementById("app_ii<?php echo $i; ?>");
											var captionText = document.getElementById("caption");
											img.onclick = function(){
												modal.style.display = "block";
												modalImg.src = this.src;
												captionText.innerHTML = this.alt;
											}

											// Get the <span> element that closes the modal
											var span = document.getElementsByClassName("close")[0];

											</script>
											<script type="text/javascript">
											<!--
												function toggle_visibility(id) {
												   var e = document.getElementById(id);
												   if(e.style.display == 'block')
													  e.style.display = 'none';
												   else
													  e.style.display = 'block';
												}
											//-->
											</script>
											</td>






                                                    <td><?php echo "<img src=".base_url()."precriptionImage/".$list->prescription_image." width='60px' height='60px'>";?>
                                                    </td>
                                                    <!--td>
                                                    <!?php echo "<img src=".base_url()."insuranceImage/".$list->insurance_image." width='60px' height='60px'>";?>
                                                    </td-->
                                                    <td><?php echo $list->prescription_scan ?></td>
                                                   <td><?php echo $list->time_stamp;?></td>

                                                   <?php if($this->session->userdata('status')=='admin'){ ?>

                                                   <td>
                                                   <?php if($list->pharmacist_id==0){?>
                                                    <a href="<?php echo site_url('PrescriptionControler/assign_pharmacist?pres_id='.$list->id.'&ph_name='.$list->pharmacy_name.'&rf_img='.$list->prescription_image); ?>" style="text-decoration:none;"><input type="button" value="Assign Pharmacist" class="btn btn-block" value="Assign Pharmacist" style="background-color:#f37022; color:white; "></a>
                                                    <?php } else{ ?>

                                                    <a href="<?php echo site_url('PrescriptionControler/change_pharmacist?pres_id='.$list->id.'&ph_id='.$list->pharmacist_id.'&ph_name='.$list->pharmacy_name.'&rf_img='.$list->prescription_image); ?>" style="text-decoration:none;"><input type="button" value="Change Pharmacist" class="btn btn-block" style="background-color:#f37022; color:white;"></a>

                                                    <?php }?>

                                                    </td>
                                                    <td>
                                                    <?php 
                                                      foreach ($pharmaname as $key)
                                                      {
                                                      if($list->pharmacist_id==$key->id)
                                                      {
                                                        echo "<strong>".$key->name."</strong>";
                                                       }
                                                      }
                                                    }?>
                                                    </td>
                                        <td>                                                     
                                       <a href="<?php echo site_url('PrescriptionControler/add_prescription?m_id='.$list->member_id.'&u_id='.$list->user_id.'&p_id='.$this->session->userdata('id').'&pres_id='.$list->id)?>">
                                       <i class="fa fa-pencil fa-fw"><strong>Add Prescription</strong></i></a>
                                      </td> 
                                             <td>
                                               <a href="<?php echo site_url('PrescriptionControler/show_prescription?pres_id='.$list->id)?>">
                                                <i class="fa fa-pencil fa-fw"><strong>Show Prescription</strong></i></a>
                                             </td>

                                            <?php }}
                                            ?>
											</tr>
										
                                            
                                            </table>
                                        </div>                          
                                    </div>
                                </div>
								
                            </div>
                            <!-- END DATATABLE EXPORT -->
                        </div>
                    </div>
                </div>


<?php $this->load->view('layout/second_footer');?>
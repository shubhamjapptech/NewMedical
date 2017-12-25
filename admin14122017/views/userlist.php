<?php $data['page']='two'; $data['title']='User List'; $this->load->view('layout/header',$data);?>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assest/css/datatable/jquery.dataTables.min.css') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">   
<style>     
.dt-button
{
    font-size: 13px !important;
    background: brown !important;
    color: white !important;
}
</style>       
            <!-- PAGE CONTENT WRAPPER -->

                <div class="page-content-wrap">

                  <div class="row">

                        <div class="col-md-12">

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h3 class="panel-title"><strong>Registered</strong> Users</h3>
                                                                         
                                    <!--div class="btn-group pull-right">

                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>

                                        <ul class="dropdown-menu">

                                                  <li class="divider"></li>

                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/xls.png' width="24"/> XLS</a></li>

                                            

                                            <li class="divider"></li>

                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'png',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/png.png' width="24"/> PNG</a></li>

                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'pdf',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/pdf.png' width="24"/> PDF</a></li>

                                        </ul>

                                    </div--> 



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
                                     <table id="customers2" class="display table">

                                        <thead>

                                            <tr>

                                            <th>#</th>

                                            <th>First Name</th>

                                            <th>Last Name</th>

                                            <th>Phone Number</th>

                                            <th>Email</th>

                                            <th>Address</th>

                                            <!-- <th>ZipCode</th> -->

                                            <th>Profile Image</th>

                                            <th>Pharmacy</th>
                                            <!--th>City</th>
                                            <th>Cross Street</th-->
                                            <th style="min-width:80px; text-align:center">Rx History</th>
                                            
                                            
                                            <th style="min-width:100px; text-align:center">Medication List</th>

                                            <th style="min-width:50px; text-align:center">Edit Account</th>

                                            <th style="min-width:50px; text-align:center">Edit Pharmacy</th>

                                            <th>Signup Date/Time</th>

                                            <th style="min-width:50px; text-align:center">Delete</th>

                                        </tr>

                                        </thead>

                                        <tbody>

                                        <?php

                                          $i=1;  

                                        foreach($userlist as $list) { 
                                            $user_name = $list->first_name.'&nbsp;&nbsp;'.$list->last_name;
                                            ?>

                                            <tr>

                                                <td><?php echo $i++;?></td>
                                                
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
                                                        { echo $pharma->pharmacy_name."<br>";
                                                          echo $pharma->city."<br>";
                                                          echo $pharma->cross_street."<br>";
                                                          echo $pharma->contactNo;
                                                        } 
                                                    } ?>
                                                </td>
                                                <!--td>
                                                    <php
                                                    foreach($user_pharmacy as $pharma)
                                                    { if($pharma->user_id==$list->id)
                                                    { echo $pharma->city;} } ?>
                                                </td>
                                                <td>
                                                    <php
                                                    foreach($user_pharmacy as $pharma)
                                                    { if($pharma->user_id==$list->id)
                                                    { echo $pharma->cross_street;} } ?>
                                                </td>

                                                <td>
                                                    <php
                                                    foreach($user_pharmacy as $pharma)
                                                    { if($pharma->user_id==$list->id)
                                                    { echo $pharma->contactNo;} } ?>
                                                </td-->    
                                                                                     

                                                <td>
                                                    <div style="text-align: center;">
                                                        <a target="blank" href="<?php echo site_url('User/UserPrescription?id='.$list->id);?>">
                                                        <i class="fa fa-medkit" style="font-size:28px;"></i></a>
                                                    </div>
                                                </td>

                                                <td style="text-align: center;">
                                                <a target="blank" href="<?php echo site_url('PrescriptionControler/UserMedicine?id='.$list->id.'&type=two');?>">
                                                    <i class="fa fa-list-alt" aria-hidden="true" style="    font-size: 20px;"></i>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="<?php echo site_url('user?id='.$list->id);?>">
                                                    <i class="fa fa-pencil-square-o" style="font-size:28px;">
                                                    
                                                    </i></a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url('user/userPharmacy?id='.$list->id);?>">
                                                    <i class="fa fa-pencil fa-fw">
                                                    <strong>Edit Pharmacy</strong>
                                                    </i></a>
                                                </td>

                                                <td><?php echo date('m-d-Y / h:m A',strtotime($list->timestamp)); ?>
                                                </td>

                                                <td>
                                                    <a href="<?php echo site_url('user/delete_user?id='.$list->id);?>">
                                                    <i class="fa fa-trash-o" style="font-size:28px;"></i>
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assest/js/plugins/tableexport/dataTables.buttons.min.js');?>"></script>
<script src="<?php echo base_url('assest/js/plugins/tableexport/jszip.min.js');?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="<?php echo base_url('assest/js/plugins/tableexport/vfs_fonts.js');?>"></script>
<script src="<?php echo base_url('assest/js/plugins/tableexport/buttons.html5.min.js');?>"></script>
<script>
    $(document).ready(function() {
    $('#customers2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5'
            // 'copyHtml5',
            //'pdfHtml5'            
        ]
    });
    $(".buttons-html5").children(":first").text("Export in Excel");
});
</script>
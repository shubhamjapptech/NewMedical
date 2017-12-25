<?php  $data['page']='four'; $data['title']='Pharmacy List'; $this->load->view('layout/header',$data);?>
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
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Pharmacy List</strong></h3>
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
                                    
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <?php if(isset($sucess) && $sucess==1){ ?>
                                    <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo $message;?>
                                    </div>        
                                    <?php } if(isset($error) && $error==1) { ?>
                                    <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo $message;?>
                                    </div>
                                    <?php }?>  

                                    <table id="customers2" class="display table">
                                    <!--table id="customers2" class="table datatable"-->
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Pharmacy Owner</th>
                                                <!--th>Father Name</th-->
                                                <th>Pharmacy Name</th>
                                                <th>Pharmacy Address</th>
                                                <th>City</th>
                                                <th>Zipcode</th>
                                                <!--th>Qualification</th-->
                                                <th>Phone Number</th>
                                                <th>Email Address</th>
                                                <th style="min-width:70px;text-align:center">Edit Account</th>
                                                <th style="min-width:50px;text-align:center">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                     <?php if(isset($pharmacylist)){
                                      $i=1;
                                        foreach($pharmacylist as $list) { ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $list->name;?></td>
                                                <!--td><php echo $list->father_name;?></td-->
                                                <td><?php echo $list->pharmacy_name;?></td>
                                                <td><?php echo $list->pharmacy_address;?></td>
                                                <td><?php echo $list->city; ?></td>
                                                <td><?php echo $list->zipcode; ?></td>
                                                <!--td><php echo $list->qualification;?></td-->
                                                <td><?php echo $list->mobile_no;?></td>
                                                <td><?php echo $list->email_id;?></td>
                                                <td>
                                                    <a href="<?php echo site_url('pharmacy/pharmacy_update?id='.$list->id);?>">
                                                    <i class="fa fa-pencil-square-o" style="font-size:28px; text-align:center;">
                                                    </i></a>
                                                    </td>
                                                <td style="text-align:center;">
                                                     <a href="<?php echo site_url('pharmacy/delete_pharmacy?id='.$list->id);?>">
                                                      <i class="fa fa-trash-o" style="font-size:28px;"></i>
                                                     </a>
                                                 </td>
                                            </tr>
                                        <?php }} ?>
                                        </tbody>
                                    </table>                                    
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
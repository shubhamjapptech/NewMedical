<?php  
   $data['page']='nine'; $data['title']='Refill Request'; $this->load->view('layout/header',$data);?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assest/css/datatable/jquery.dataTables.min.css') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">   
<style>     
.dt-button
{
    font-size: 13px !important;
    background: brown !important;
    color: white !important;
}
td,th{
   text-align:center;
   }
</style>

<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">
                  <strong>Refill </strong>Request</h3>
               <!--div class="btn-group pull-right">
                  <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bars">
                  </i> Export Data
                  </button>
                  <ul class="dropdown-menu">
                     <li class="divider">
                     </li>
                     <li>
                        <a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});">
                        <img src='<?php echo base_url();?>/assest/img/icons/xls.png' width="24"/> XLS
                        </a>
                     </li>
                     <li class="divider">
                     </li>
                     <li>
                        <a href="#" onClick ="$('#customers2').tableExport({type:'png',escape:'false'});">
                        <img src='<?php echo base_url();?>/assest/img/icons/png.png' width="24"/> PNG
                        </a>
                     </li>
                     <li>
                        <a href="#" onClick ="$('#customers2').tableExport({type:'pdf',escape:'false'});">
                        <img src='<?php echo base_url();?>/assest/img/icons/pdf.png' width="24"/> PDF
                        </a>
                     </li>
                  </ul>
               </div-->
            </div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table id="customers2" class="display table">
                  <!--table id="customers2" class="table datatable"-->
                     <thead>
                        <tr>
                           <th>#</th>
                           <th style="min-width:150px; text-align:center;">Patient Name</th>
                           <th>Drug Name</th>
                           <th>Manufacturer</th>
                           <th>Directions</th>
                           <th>Quantity</th>
                           <th>Refills Remaining</th>
                           <th>End Date</th>
                           <th>Date and Time Requested</th>
                           <!--?php if($this->session->userdata('status')=='admin'){ ?-->
                           <!-- <th>Assign Pharmacist</th> 
                              <th style="text-align:center;">Assigned Pharmacist Name</th-->
                           <!--?php } ?>-->
                           <th>Update Prescription</th>
                           <!-- <th>Delet Prescription</th> -->
                        </tr>
                     </thead>
                     <?php if(isset($error) && $error==1) {?>
                     <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
                        </a>
                        <?php echo $message; ?>
                     </div>
                     <?php } if(isset($success) && $success==1) {?> 
                     <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
                        </a>
                        <?php echo $message;?>
                     </div>
                     <?php } if(isset($success) && $success==2) {?> 
                     <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
                        </a>
                        <?php echo $message;?>
                     </div>
                     <?php } if(isset($prescription1) && $prescription1!='') { 
                        $i=1;  
                        foreach($prescription1 as $list) {?>
                     <tr>
                        <td>
                           <?php echo $i++;?>
                        </td>
                        <td>
                           <?php if($this->session->userdata('status')=='admin'){ ?>
                           <strong>
                           <a href="<?php echo site_url('User/UserPrescription?id='.$list->user_id);?>" style="color:blue !important;">
                           <?php echo $list->first_name.' '.$list->last_name; ?>
                           </a>
                           </strong>
                           <?php } 
                              else { echo $list->first_name.' '.$list->last_name; } ?>
                        </td>
                        <td>
                           <?php echo $list->medicine_name;?>
                        </td>
                        <td>
                           <?php echo $list->medicine_company;?>
                        </td>
                        <td>
                           <?php echo $list->prescription;?>
                        </td>
                        <td>
                           <?php echo $list->total_medicine; ?>
                        </td>
                        <td>
                           <?php echo $list->remain_medicine; ?>
                        </td>
                        <!--td><php echo $list->medicine_type;?></td-->
                        <td>
                           <?php echo date('m-d-Y',strtotime($list->end_date));?>
                        </td>
                        <td>
                           <?php echo date('m-d-Y / h:i',strtotime($list->timestamp));?>
                        </td>
                        <!--?php if($this->session->userdata('status')=='admin'){ ?>
                           <td>
                           <a href="<php echo site_url('PrescriptionControler/change_pharmacist?pres_id='.$list->prescription_id.'&ph_id='.$list->pharmacist_id.'&ph_name='.$list->pharmacy_name.'&type=1&med_id='.$list->id); ?>" style="text-decoration:none;"><input type="button" value="Change Pharmacist" class="btn btn-success">
                           </a>
                           </td>
                           <td>
                           <php 
                           foreach ($pharmaname as $key)
                           { if($list->pharmacist_id==$key->id)
                           {
                           echo "<strong>".$key->name."</strong>";
                           }
                           }}?>
                           </td-->
                        <td>
                           <!--a href="<!?php echo site_url('PrescriptionControler/add_renew_prescription?u_id='.$list->user_id.'&pres_id='.$list->prescription_id.'&med_name='.$list->medicine_name);?>"-->
                           <a href="<?php echo site_url('PrescriptionControler/add_renew_prescription?med_id='.$list->id.'&pres_id='.$list->prescription_id);?>">
                           <i class="fa fa-pencil fa-fw">
                           <strong>Update Prescription
                           </strong>
                           </i>
                           </a>
                        </td>
                        <!--<td>
                           <a href="<!?php echo site_url('PrescriptionControler/delete_prescription?id='.$list->id.'&pres_id='.$list->prescription_id.'&med_name='.$list->medicine_name);?>">
                           <i class="fa fa-trash-o fa-fw">
                           <strong>Delete</strong></i>
                           </a>
                           </td-->
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
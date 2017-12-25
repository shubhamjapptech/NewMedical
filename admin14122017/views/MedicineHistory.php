
<?php  $data['page']='two'; $data['title']='Medication History'; $this->load->view('layout/header',$data);?>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assest/css/datatable/jquery.dataTables.min.css') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<style type="text/css">
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
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?php echo base_url();?>">Home</a></li> 
    <?php if($page=='two'){ ?>
    <li><a href="<?php echo site_url('User/userlist');?>">User List</a></li>
         <?php } else{?>  
    <li><a href="<?php echo site_url('PrescriptionControler');?>">Prescription Request</a></li>
           <?php }?>      
    <li><a href="<?php echo site_url('PrescriptionControler/UserMedicine?id='.$user_id.'&type=two');?>">  Medication List</a></li>        
    <li class="active">Medication History</li>
</ul>
<!-- END BREADCRUMB -->
<div class="page-content-wrap">

                  <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Medication</strong> History</h3>
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
                                    	<table id="customers2" class="display table">
                                        <!--table id="customers2" class="table datatable"--> 
                                    	<thead>
                                         	<tr>
                                                <th>#</th>
                                                <th>Medication</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Remaining Quantity</th>
                                                <th>Directions</th> 
                                                <th>Dose Time </th>
                                                <th>Dose Date</th>                        
                                                <th>Taken</th>
                                            </tr>
                                        </thead>             
                                    	<?php if(isset($error) && $error==1) {?>
					                   <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message; ?>
                                        </div>
                                       <?php } if(isset($medicineTime) && $medicineTime!='') 
                                                { 
					                                $i=1;  
                                        	   foreach($medicineTime as $list) { 
                                                if($list->status=='taken'){$status='Yes';} else{$status='No';}
                                                ?>
                                        		<tr <?php if($list->status=='taken'){ ?> style="background-color:rgba(104, 228, 154, 0.93);"<?php }?>>
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $MedDetails->medicine_name;?></td>
                                                    <td><?php echo $MedDetails->medicine_type;?></td>
                                                    <td><?php echo $MedDetails->total_medicine; ?></td>
                                                    <td><?php echo $MedDetails->remain_medicine; ?></td>
                                                    <td><?php echo $MedDetails->prescription;?></td>
                                                    <td><?php echo $list->time.' '.$list->time_type;?></td>
                                                    <td><?php echo date('m-d-Y',strtotime($list->dose_date)); ?>
                                                    </td>                                                   
                                                    <td><?php echo $status;?></td>
                                                </tr>
                                               
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
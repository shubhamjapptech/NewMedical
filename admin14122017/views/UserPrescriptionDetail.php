<?php $data['page']='two'; $data['title']='Prescription Request History'; $this->load->view('layout/header',$data);?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assest/css/datatable/jquery.dataTables.min.css') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<style>
.dt-button{          /* Css for excel button */
font-size: 13px !important;
background: brown !important;
color: white !important;

}
.mimage{          /* Css for model image */
    padding-bottom: 20px;
    cursor: pointer;
    width:100%;
    height:100%;
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
    color:white;
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

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?php echo base_url();?>">Dashboard</a></li>                    
    <li class="active">Prescription Request History</li>
</ul>
<div class="page-content-wrap">
   <div class="row">
      <!-- Panel for User Details Start -->
    <div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
               <h3 class="panel-title"><strong>User Details</strong></h3>
        </div>

        <div class="col-md-10">            
            <div class="panel-body" style="padding:10px;">
            <div class="row">               
                <div class="form-group">                                
                    <label class="col-md-2 col-xs-6 col-sm-6 control-label"><th>Patient Name :</th></label>
                    <div class="col-md-4 col-xs-6 col-sm-6 detail"><?php echo $user_details->first_name.' '.$user_details->last_name;?></div>       

                    <label class="col-md-2 col-sm-6 col-xs-6 control-label">Email Address :</label>                    
                    <div class="col-md-4 col-sm-6 col-xs-6 detail" ><?php echo $user_details->email;?></div>      
                </div>
            </div>
            <div class="row">
                 <div class="form-group">  
                    <label class="col-md-2 col-sm-6 col-xs-6 control-label">Patient Address :</label>
                    <div class="col-md-4 col-sm-6 col-xs-6 detail"><?php echo $user_details->address;?></div>       

                    <label class="col-md-2 col-sm-6 col-xs-6 control-label">Phone Number :</label>                    
                    <div class="col-md-4 col-sm-6 col-xs-6 detail"><?php echo $user_details->phone;?></div>          
                </div>
            </div>
            </div>
         </div>

        <div class="col-md-2 col-xs-12">
        <div class="row">
            <label class="col-md-12 col-xs-6 control-label">Patient Image</label>
        </div>
        <div class="row">
        <div class="panel-body col-md-12 col-xs-6" style="padding:10px; margin-top:-10px;">
            <?php if($user_details->image_type==0)
            {
                echo "<img src=".base_url()."image/".$user_details->image." width='70px' height='70px'>";    
            }
            else
            {
                echo "<img src=".$user_details->image." width='70px' height='70px'>"; 
            }
            ?>
            </div>
        </div>
        </div>
        </div>
        
    </div>
    
      <!-- Panel for User Details Start End-->




      <!-- Panel for Prescription Details Start -->
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"><strong>Prescription</strong> Request History 
               </h3>
               </div>
               <!--div class="btn-group pull-right">
                  <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                  <ul class="dropdown-menu">
                     <li class="divider"></li>
                     <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/xls.png' width="24"/> XLS</a></li>
                     <li class="divider"></li>
                     <li><a href="#" onClick ="$('#customers2').tableExport({type:'png',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/png.png' width="24"/> PNG</a></li>
                     <li><a href="#" onClick ="$('#customers2').tableExport({type:'pdf',escape:'false'});"><img src='<?php echo base_url();?>/assest/img/icons/pdf.png' width="24"/> PDF</a></li>
                  </ul>
               </div>
            </div-->
            <div class="panel-body">

               <div class="table-responsive">
                  <div style="overflow:scroll; height:400px;">
                  <div id="over">
                    <table id="customers2" class="display table">
                    <!--table id="customers2" class="table table datatable"-->                
                        <thead>
                           <tr>
                              <th>#</th>
                              <th style="min-width:150px; text-align:center;">Patient Name</th>
                              <th style="min-width:100px; text-align:center;">Patient Email</th>
                              <th>Pharmacy Name</th>
                              <!-- <th style="min-width:80px;">Status</th> -->
                              <th style="min-width:240px; text-align:center">Prescription Images</th>
                              <!--th style="min-width:150px; text-align:center">Insurance Image</th>
                                 <th style="min-width:100px;">Bar Code</th-->
                              <th>Request Date/Time</th>
                              <?php if($this->session->userdata('status')=='admin'){ ?>
                              <th style="text-align:center">Assigned RPh</th>
                              <?php } ?>
                              <th style="min-width:70px; text-align:center;">Show Rx</th>
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
                        <?php }?>
                        <?php  if(isset($image) && $image!='') { 
                           $i=1;  
                           foreach($image as $list) {?>
                        <tr <?php if($list->pharmacist_id==0){ ?> style="background-color:#eaeae9;"<?php } ?>>
                           <td><?php echo $i++;?></td>
                           <td><strong><?php echo $list->first_name.'&nbsp;&nbsp;'.$list->last_name; ?></strong></td>
                           <td><?php echo $list->email; ?></td>
                           <td><?php echo $list->pharmacy_name;
                                  echo $list->city."<br>";
                                  echo $list->cross_street."<br>";
                                  echo $list->contactNo; ?></td>
                           
                           <!--td><!?php echo $list->status;?></td-->
                           <?php $images = get_prescriptionImage($list->id);?>
                           <td>
                            <?php foreach ($images as $presImage) { ?>
                              <a href="#" id="link1" data-toggle="modal" data-target="#qbimageModal">
                                <img onclick="changeIt(this)" src="<?php echo base_url('precriptionImage/'.$presImage->image);?>" width="60" height="60" style="cursor:pointer; padding:5px; border:1px solid;"></a>
                            <?php } ?>
                          </td>
                           
                  <td><?php echo date('m-d-Y / h:i',strtotime($list->time_stamp)); ?> </td>
                  <?php if($this->session->userdata('status')=='admin'){ ?>
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
                    <a href="<?php echo site_url('PrescriptionControler/show_prescription?pres_id='.$list->id.'&type=two&user_id='.$user_details->id);?>"><strong>Show Rx</strong></a>
                  </td>
                  <?php }}
                     ?>
                  </tr>   
                  </table>
               </div>
            </div>
            </div>
         </div>
      </div>
      <!-- END DATATABLE EXPORT -->
   </div>
   <!-- Panel for Prescription Details Start -->
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
                <!--Prescription Image Model-->
<div class="modal fade" id="qbimageModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background-color:rgba(0, 0, 0, 0.78);">
    <div class="modal-dialog-md">
    <div class="modal-header" style="background:black !important; color:white;border-bottom:0px !important; cursor:pointer;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>      
      </div>
      <div class="modal-content">
        <div class="modal-body" id='' style="max-width:100%;height:auto; background-color:black;">
          <div class='col-sm-12' id="showImg">

           </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialo-->

  <script>
  function changeIt(img)
  {
    var name = img.src;  
    //alert(name);
    document.getElementById("showImg").innerHTML="<center><img class='img-responsive mimage' src='"+name+"'/></center>";
  }
  </script>
                <!-- Image in large view End  -->

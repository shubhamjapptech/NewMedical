
<?php $data['page']='five'; $data['title']='Prescription Verification';
 $this->load->view('layout/header',$data);?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
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
<!--?php print_r($image); die(); ?-->
<div class="page-content-wrap main">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><strong>Prescription</strong> Verification</h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
          <div id="over" style="overflow:scroll; height:550px;"> 
            <table id="example" class="display" cellspacing="0" width="100%">
              <thead style="background: rgb(243,112,34);color: white;">
                <tr>
                  <tr>
                    <th>#</th>
                    <th style="min-width:150px; text-align:center;">Patient Name</th>
                    <th style="min-width:100px; text-align:center;">Patient Email </th>
                    <th>Pharmacy</th>
                    <!-- <th style="min-width:80px;">Status</th> -->
                    <th style="min-width:240px; text-align:center">Prescription Images</th>
                    <!--th style="min-width:150px; text-align:center">Insurance Image</th>
                    <th style="min-width:100px;">Bar Code</th-->
                    <th>Request Date/Time</th>
                    <?php if($this->session->userdata('status')=='admin'){ ?>
                    <th>Assign RPh</th>
                    <th style="text-align:center">Assigned RPh</th>
                    <?php } ?>
                    <th style="min-width:80px; text-align:center;">Add Rx</th>
                  <th style="min-width:80px; text-align:center;">Show Rx</th>
                </tr>
              </thead>
                           <!-- Success or Error message show Here -->
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
                <!-- Success or Error message show Here -->
              <tbody>
            <?php  if(isset($image) && $image!='') 
            {  $i=1;  
          foreach($image as $list) {
          ?>
            <tr>
                <td><?php echo $i++;?></td>                
                <td>
                <?php if($this->session->userdata('status')=='admin'){ ?>
                <strong>
                <a target="blank" href="<?php echo site_url('User/UserPrescription?id='.$list->user_id);?>" style="color:blue !important;">
                <?php echo $list->first_name.' '.$list->last_name; ?></a>
                </strong>
                <?php } 
                else { echo $list->first_name.' '.$list->last_name; } ?>
                </td>

                <td><?php echo $list->email; ?></td>

                <td>
                <?php
                $pharmacy_name ='';
                if($list->pharmacy_id!=0)
                {     
                  $pharmacy = get_userPharmacy($list->pharmacy_id);
                  $pharmacy_name =$pharmacy->pharmacy_name;
                  echo $pharmacy_name."<br>";
                  echo $pharmacy->city."<br>";
                  echo $pharmacy->cross_street."<br>";
                  echo $pharmacy->contactNo; 
                }
                ?>                        
                </td>
              
              <!--td><!?php echo $list->status;?></td-->
              <?php $images = get_prescriptionImage($list->id);?>

<td>
  <?php foreach ($images as $presImage) { ?>
    <a href="#" id="link1" data-toggle="modal" data-target="#qbimageModal">
      <img onclick="changeIt(this)" src="<?php echo base_url('precriptionImage/'.$presImage->image);?>" width="60" height="60" style="cursor:pointer; padding:5px; border:1px solid;">
  <?php } ?>
</td>


                <td><?php echo date('m-d-Y / h:i A',strtotime($list->time_stamp));?></td>
                <?php if($this->session->userdata('status')=='admin'){ ?>
                <td>
                <?php if($list->pharmacist_id==0){?>
                <a href="<?php echo site_url('PrescriptionControler/assign_pharmacist?pres_id='.$list->id.'&ph_name='.$pharmacy_name); ?>" style="text-decoration:none;">
                <input type="button" class="btn btn-success" value="Assign RPh" style="background-color:#f37022; color:white; "></a>
                <?php } else{ ?>

                <a href="<?php echo site_url('PrescriptionControler/change_pharmacist?pres_id='.$list->id.'&ph_id='.$list->pharmacist_id.'&ph_name='.$pharmacy_name); ?>" style="text-decoration:none;">
                <input type="button" value="Change RPh" class="btn btn-success"></a>
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
                }}?>
                
                </td>
                <td>  
                <?php if($list->pharmacist_id!=0 && $list->pharmacist_id!=$this->session->userdata('id'))
                { echo "<center><b>RPh Assigned</b></center>"; }
                else {?> 

                <a target="blank" href="<?php echo site_url('PrescriptionControler/add_prescription?u_id='.$list->user_id.'&p_id='.$this->session->userdata('id').'&pres_id='.$list->id)?>">
                <strong>Add-Rx</strong></a>
                <?php } ?>
                </td> 
                <td>
                <a target="blank" href="<?php echo site_url('PrescriptionControler/show_prescription?pres_id='.$list->id.'&type=five')?>">
                <strong>Show-Rx</strong></a>
                </td>
                </tr>
                <?php }}
                ?>
                </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
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
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            // 'copyHtml5',
            //'pdfHtml5'            
        ]
    } );
    $(".buttons-html5").children(":first").text("Export in Excel");
} );
</script>

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

<!-- Image in large view End  -->


  <script>
  function changeIt(img)
  {
    var name = img.src;  
    //alert(name);
    document.getElementById("showImg").innerHTML="<center><img class='img-responsive mimage' src='"+name+"'/></center>";
  }
  </script>

   

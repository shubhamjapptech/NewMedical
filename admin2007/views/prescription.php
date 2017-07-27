
<?php $data['page']='five'; $data['title']='Prescription List'; $this->load->view('layout/header',$data);?>
<style>
#over{
  display: block;
  flex-wrap: wrap;
  height:550px;
  overflow:scroll;
  }

  .myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

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

                                <div class="panel-body">

                                    <div class="table-responsive"> 
                                

                                       <div id="over">
                                    
                                        <table id="customers2" class="table table datatable"> 
                                        <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>Pharmacy Name</th>
                                                <th style="min-width:150px; text-align:center;">User Name</th>
                                                <th style="min-width:100px; text-align:center;">Email</th>
                                                <!-- <th style="min-width:80px;">Status</th> -->
                                                <th style="min-width:240px; text-align:center">Refill Image</th>
                                                <!--th style="min-width:150px; text-align:center">Insurance Image</th>
                                                <th style="min-width:100px;">Bar Code</th-->
                                                <th>Requist Date/Time</th>
                                                <?php if($this->session->userdata('status')=='admin'){ ?>
                                                <th>Assign Pharmacist</th>
                                                <th style="text-align:center">Assigned Pharmacist Name</th>
                                                <?php } ?>
                                                <th style="min-width:70px; text-align:center;">Add Prescription</th>
                                              <th style="min-width:70px; text-align:center;">Show Prescription</th>
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
                                                <tr <?php if($list->pharmacist_id==0){ ?> style="background-color:#e6dcc9;"<?php } ?>>
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $list->pharmacy_name;?></td>
                                                    <td><?php echo $list->first_name.'&nbsp;&nbsp;'.$list->last_name; ?></td>
                                                    <td><?php echo $list->email; ?></td>
                                                  <!--td><!?php echo $list->status;?></td-->
                                                  
<!--td> 

 <!?php foreach ($pres_image as $key) {

if($key->prescription_id==$list->id)
{
?>           
 <img id="myImg<!?php echo $key->id;?>" src="<!?php echo base_url('precriptionImage/').$key->image; ?>" alt="Trolltunga, Norway" width="60" height="60" style="cursor: pointer;">
<The Modal >
<div id="myModal<!?php echo $key->id;?>" class="modal">
  <span onclick="toggle_visibility('myModal<!?php echo $key->id;?>');" class="close" data-dismiss="modal">&times;</span>
  <img class="modal-content" id="img01<!?php echo $key->id;?>">
  <div id="caption"></div>
</div>

<script>
var modal = document.getElementById('myModal<!?php echo $key->id; ?>');

// Get the image and insert it inside the modal - use its "alt" text as a caption

var img = document.getElementById('myImg<!?php echo $key->id; ?>');
var modalImg = document.getElementById("img01<!?php echo $key->id; ?>");
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

    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>

<!?php }} ?> 
</td-->


<td>
<?php foreach ($pres_image as $key) 
{
if($key->prescription_id==$list->id)
{
?>           
  <img id="refill<?php echo $key->id; ?>" data-toggle="modal" data-target="#rf<?php echo $key->id; ?>" src="<?php echo base_url('precriptionImage/'.$key->image);?>" width="60" height="60" style="cursor:pointer; margin-left: 40px;">
    <div id="rf<?php echo $key->id; ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body" style="background: rgba(0, 0, 0, 0.92);opacity: 1.1;text-align: center;">
            <img id="refill<?php echo $key->id; ?>" src="<?php echo base_url('precriptionImage/'.$key->image);?>" style="cursor: pointer; width:100%; height:100%;">
          </div>
          <div class="modal-footer" style="background: rgba(0, 0, 0, 0.92);opacity: 1.1;border:none;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php }} ?> 
</td>










                                     <!-- <td> <!?php foreach ($pres_image as $key) {
                                    if($key->prescription_id==$list->id)
                                    {?>
                                    <img class="nature<!?php echo $i; ?>" src="<!?php echo base_url('precriptionImage/').$key->image; ?>" width="80" height="80" style="cursor:pointer;">                                              
                                <!?php } } ?> 
                                      <p>
                                      <button onclick="myShow.previous()"><</button>
                                      <button onclick="myShow.next()">></button>
                                      </p>
                                      <script src="https://www.w3schools.com/lib/w3.js"></script>   
                                      <script>
                                        myShow = w3.slideshow(".nature<!?php echo $i; ?>", 0);
                                      </script>                                                        
                                    </td>-->



                                                    
<!--td>
  <img id="insurance<php echo $i; ?>" data-toggle="modal" data-target="#ins<php echo $i; ?>" src="<php echo base_url('insuranceImage/'.$list->insurance_image);?>" width="60" height="60" style="cursor:pointer; margin-left: 40px;">
    <div id="ins<php echo $i; ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <!--div class="modal-content">
          <div class="modal-body" style="background: rgba(0, 0, 0, 0.92);opacity: 1.1;text-align: center;">
            <img id="insurance<php echo $i; ?>" src="<php echo base_url('insuranceImage/'.$list->insurance_image);?>" style="cursor: pointer; width:100%; height:100%;">
          </div>
          <div class="modal-footer" style="background: rgba(0, 0, 0, 0.92);opacity: 1.1;border:none;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</td>
                                                  
                                                  <td><php echo $list->prescription_scan ?></td-->
                                                   <td><?php $t=$list->time_stamp;
												            $s=explode(" ",$t);
                                                            $create=implode(" / ",$s);
													         echo $create;  ?></td>

                                                   <?php if($this->session->userdata('status')=='admin'){ ?>

                                                   <td>
                                                   <?php if($list->pharmacist_id==0){?>
                                                    <a href="<?php echo site_url('PrescriptionControler/assign_pharmacist?pres_id='.$list->id.'&ph_name='.$list->pharmacy_name); ?>" style="text-decoration:none;"><input type="button" value="Assign Pharmacist" class="btn btn-block" value="Assign Pharmacist" style="background-color:#f37022; color:white; "></a>
                                                    <?php } else{ ?>

                                                    <a href="<?php echo site_url('PrescriptionControler/change_pharmacist?pres_id='.$list->id.'&ph_id='.$list->pharmacist_id.'&ph_name='.$list->pharmacy_name); ?>" style="text-decoration:none;"><input type="button" value="Change Pharmacist" class="btn btn-success"></a>

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
                                        <?php if($list->pharmacist_id!=0 && $list->pharmacist_id!=$this->session->userdata('id'))
                                        { echo "<center><b>Pharmacist Assigned</b></center>"; }
                                        else {?> 

                                         <a href="<?php echo site_url('PrescriptionControler/add_prescription?u_id='.$list->user_id.'&p_id='.$this->session->userdata('id').'&pres_id='.$list->id)?>">
                                        <i class="fa fa-pencil fa-fw"><strong>Add Prescription</strong></i></a>
                                        <?php } ?>
                                    </td> 
                                             <td>
                                               <a href="<?php echo site_url('PrescriptionControler/show_prescription?pres_id='.$list->id)?>">
                                                <i class="fa fa-pencil fa-fw"><strong>Show Prescription</strong></i></a>
                                             </td>

                                            <?php }}
                                            ?>
                                            
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



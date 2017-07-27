<?php  
   $page='five'; if(isset($_GET['type'])){ $page='nine';} $data['page']=$page;
   $data['title']='Assign Phamacist'; $this->load->view('layout/header',$data);
?>

<style>
   .myImg {
   border-radius: 5px;
   cursor: pointer;
   transition: 0.3s;
   }
   .myImg:hover 
   {           opacity: 0.7;
   }
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
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         <!-- START DATATABLE EXPORT -->
         <div class="table-responsive">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><strong>Assigned Pharmasist</strong></h3>
                  <table class="table datatable">
                     <thead>
                        <tr>
                           <th>Sr.No.</th>
                           <th>Assigned Pharmasist Name</th>
                           <th>Pharmacy Name</th>
                           <!-- <th>Refill Image</th> -->
                        </tr>
                     </thead>
                     <tbody style="background-color: rgba(30, 193, 210, 0.29); font-weight:bold; font-size:13px;">
                        <tr>
                           <td>1</td>
                           <td><?php if(isset($change)){ echo $change->name;} ?></td>
                           <td><?php echo $ph_name; ?></td>
                           <!--td>
                              <<img id="myImg" src="<!?php echo base_url('precriptionImage/').$rf_image; ?>" alt="<!?php echo $ph_name; ?>" width="60" height="60" style="cursor:pointer;"> -->
                              <!-- The Modal -->
                              <!--div id="myModal" class="modal">
                                 <span onclick="toggle_visibility('myModal');" class="close" data-dismiss="modal">&times;</span>
                                 <img class="modal-content" id="img01">
                                 <div id="caption"></div>
                              </div>
                              <script>
                                 var modal = document.getElementById('myModal');
                                 // Get the image and insert it inside the modal - use its "alt" text as a caption
                                 var img = document.getElementById('myImg');
                                 var modalImg = document.getElementById("img01");
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
                           </td>
                           <td><!?php echo "<img src=".base_url()."precriptionImage/".$rf_image." width='60px' height='60px'>";?>
                              </td-->
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"><strong>Pharmasist List</strong></h3>
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
             <?php if(isset($sucess)==1){ ?>
                  <div class="alert alert-success">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close" style="position: static;">&times;</a>
                     <?php echo $message;?>
                  </div>
                  <?php } if(isset($error)==1) { ?>
                  <div class="alert alert-danger">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close" style="position: static;">&times;</a>
                     <?php echo $message;?>
                  </div>
                  <?php }?> 
            <div class="panel-body">
               <div class="table-responsive">                 
                  <div style="overflow:scroll; height:380px;">
                     <table id="customers2" class="table datatable">
                        <thead>
                           <tr>
                              <th>Sr.No.</th>
                              <th>Pharmasist Name</th>
                              <th>Phone Number</th>
                              <th>Address</th>
                              <th>Email</th>
                              <th>Assign</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                           foreach($pharmalist as $list) { ?>                   
                        <tr>
                           <td><?php echo $i++;?></td>
                           <td><?php echo $list->name;?></td>
                           <td><?php echo $list->phone;?></td>
                           <td><?php echo $list->address;?></td>
                           <td><?php echo $list->email;?></td>
                           <td>
                              <a href="<?php echo site_url('PrescriptionControler/assigned?ph_id='.$list->id.'&pres_id='.$pres_id.'&ph_name='.$ph_name); ?>" style="text-decoration:none;"><input type="button" value="Assign Pharmacist" class="btn btn-block" value="Assign Pharmacist" style="background-color:#f37022; color:white; ">
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

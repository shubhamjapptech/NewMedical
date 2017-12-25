<?php $data['page']='five'; $data['title']='Add Rx';  $this->load->view('layout/header',$data);?>
<style>
.modal-backdrop.in{
        opacity: 1 !important;
}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <?php if($this->session->userdata('status')=='admin'){ ?>
        <li><a href="<?php echo base_url();?>">Home</a></li> <?php }?>
    <li><a href="<?php echo site_url('PrescriptionControler');?>">Prescription Verification</a></li>
    <li class="active">Add Rx</li>
</ul>
<!-- PAGE CONTENT WRAPPER -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<div class="page-content-wrap">
    <!-- Panel for User Details Start -->
    <div class="col-md-12">
   <div class="panel panel-default">
      <div class="panel-heading">
         <h3 class="panel-title"><strong>Prescription Images</strong></h3>
      </div>
      <div class="panel-body" style="padding:10px;">
         <div class="form-group">
            <?php foreach ($images as $key) { ?> 
            <img id="refill<?php echo $key->id; ?>" data-toggle="modal" data-target="#rf<?php echo $key->id; ?>" src="<?php echo base_url('precriptionImage/'.$key->image);?>" width="90" height="100" style="cursor:pointer; margin-left: 40px; padding:5px; border:1px solid;">
            <div id="rf<?php echo $key->id; ?>" class="modal fade" role="dialog">
               <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                     <div class="modal-body" style="background: rgba(0, 0, 0, 0.92);opacity: 1.1;text-align: center;">
                        <img id="refill<?php echo $key->id; ?>" src="<?php echo base_url('precriptionImage/'.$key->image);?>" style="cursor: pointer; width:90%; height:90%;">
                     </div>
                     <div class="modal-footer" style="background: rgba(0, 0, 0, 0.92);opacity: 1.1;border:none;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?> 
         </div>
      </div>
   </div>
   
      <!-- Panel for User Details Start End-->

    <div class="row">
        <div class="col-md-12">
           <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo site_url('PrescriptionControler/add_prescription?u_id='.$u_id.'&p_id='.$p_id.'&pres_id='.$pres_id); ?>">
              <div class="panel panel-default">
                 <div class="panel-heading">
                    <h3 class="panel-title"><strong>Add</strong> Rx</h3>
                 </div>
                 <div class="panel-body form-group-separated">
                    <div class="container">
                       <?php if(isset($error)&& $error==1){?>
                       <div class="alert alert-danger">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <?php echo $message;?>
                       </div>
                       <?php } if(isset($success) && $success==1){?>
                       <div class="alert alert-success">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <?php echo $message;?>
                       </div>
                       <?php } ?>
                       <!--div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Refill Image</label>
                          <div class="col-md-6 col-xs-12">                      
                              <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                          </div>
                          </div-->
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Drug Name</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="medicine" class="form-control" id="medicine" required />
                             </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Manufacturer</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="company" id="tag" class="form-control" required />
                             </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Dosage Form</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="type" class="form-control" placeholder="Like:Capsule,Tablet etc." required />
                             </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Day Supply</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="days" pattern="\d+" class="form-control" id="days" onkeyup="addDays()" title="only numbers allow" required />
                                <input type="hidden" name="endDate" id="endDate">
                             </div>
                          </div>
                       </div>
                       <!--div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Dose Time 1</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" name="time[]" pattern="^(1?[0-9]|2[0-9]):[0-5][0-9]$" title="enter correct time like-HH:MM" class="form-control" required />
                              </div>
                          </div>
                          </div-->
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Dose Time 1</label>
                          <div class="col-md-2 col-xs-4">
                             <select class="form-control select" data-size="5" name="hh[]" id="hh" required>
                                <option value="">HH</option>
                                <option value="00">0</option>
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                             </select>
                          </div>
                          <div class="col-md-2 col-xs-4">
                             <select class="form-control select" data-size="5" name="mm[]"  id="mm" required>
                                <option value="">MM</option>
                                <option value="00">00</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                             </select>
                          </div>
                          <div class="col-md-2 col-xs-4">
                             <select class="form-control select" name="tt[]">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                             </select>
                          </div>
                       </div>
                       <div class="form-group">
                          <div id="content"></div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Dose Time</label>
                          <div class="col-md-6 col-xs-12">   
                             <input type="button" name="time" class="btn btn-success" onclick="addElement();" value="Add More Time" required>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Directions</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="prescription" class="form-control" required />
                             </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Total Quantity</label>
                          <div class="col-md-3 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="quantity" class="form-control" placeholder="Enter quantity" id="quantity" pattern="\d+" title="Only numbers allow" required />
                             </div>
                          </div>
                          <div class="col-md-3 col-xs-12">
                             <div class="input-group"> 
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="unit" class="form-control" placeholder="Enter Unit" required />
                             </div>
                          </div>
                          <span style="color:red">Note : Please fill quantity Like: tablets, ml, gm etc.</span>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Prescriber Name</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="pres_name" class="form-control" required />
                             </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Prescriber Phone Number</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="pres_number" class="form-control" required />
                             </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Prescriber Address</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="pres_add" class="form-control" required />
                             </div>
                          </div>
                       </div>
                       
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Refills</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="number" name="refill" class="form-control" required />
                             </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Date Filled</label>
                          <div class="col-md-6 col-xs-12">
                             <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" id="from" name="Date_filled" class="form-control" required />
                             </div>
                          </div>
                       </div>
                       <div class="panel-footer">
                          <input type="hidden" name="user_id" value="<?php echo $u_id; ?>">
                          <input type="hidden" name="pharmasist_id" value="<?php echo $p_id;?>">
                          <input type="hidden" name="prescription_id" value="<?php echo $pres_id;?>">
                          <button class="btn btn-default">Clear Form</button>  
                          <input type="submit" name="submit" value="Add Prescription" class="btn btn-primary pull-right">
                       </div>
           </form>
       </div>
   </div>  
</div>                  

                <!-- END PAGE CONTENT WRAPPER --> 
                
<script type="text/javascript">                                    
    var intTextBox = 1; 
    function addElement() 
    {
        intTextBox++;
        var objNewDiv = document.createElement('div');
        document.getElementById('content').appendChild(objNewDiv);
        objNewDiv.setAttribute('id', 'div_' + intTextBox);
        objNewDiv.innerHTML ='<div class="form-group"><label class="col-md-3 col-xs-12 control-label" style="margin-left:7px;">Dose Time'+intTextBox+'</label><div class="col-md-2 col-xs-4"><select class="form-control select" data-size="5" name="hh[]" required><option value="00">0</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option></select></div><div class="col-md-2 col-xs-4"><select class="form-control select" data-size="5" name="mm[]" required><option value="00">00</option><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option></select></div><div class="col-md-2 col-xs-3"><select class="form-control select" name="tt[]"><option value="AM">AM</option><option value="PM">PM</option></select></div><input type="button" class="btn btn-danger" onclick="removeElement();" value="X" style="margin-top: 10px;"></div>';
    }

    function removeElement()
    {
        if(1 < intTextBox) {
            document.getElementById('content').removeChild(document.getElementById('div_' + intTextBox));
            intTextBox--;
        } 
        else{
            alert("Only 1 Dose Time Left");
        }
    }

     /* function my()
     {  
        //alert(intTextBox);   
        var type=document.getElementById("remain").value;  
        var days=document.getElementById("days").value;
        var multi=intTextBox*days;
        document.getElementById("quantity").value=multi;
        document.getElementById("remain").value=multi;
        addDays(days);
    }*/ 
    function addDays()
    {
        var n=document.getElementById("days").value; 
        var t = new Date();
        t.setDate(t.getDate() + parseInt(n));
         var date = ((t.getDate() < 10) ?  '0'+t.getDate() : t.getDate())+"-"+(((t.getMonth() + 1) < 10 ) ? '0'+(t.getMonth()+1) : (t.getMonth()+1))+"-"+t.getFullYear();
         document.getElementById("endDate").value=date;
        //alert(date);
    }                                   

</script> 

 
<?php $this->load->view('layout/footer');?> 
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/south-street/jquery-ui.css"> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script> 

<script>
$('#from').datepicker(
 { 
    minDate: 0,
    beforeShow: function() {
    $(this).datepicker();
  }
});
</script>






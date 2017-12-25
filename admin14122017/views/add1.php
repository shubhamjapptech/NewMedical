<?php
$this->load->view('layout/header');?>
<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" method="POST" action="<?php echo site_url('PrescriptionControler/add_prescription?m_id='.$m_id.'&p_id='.$p_id.'&pres_id='.$pres_id); ?>">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Add</strong>Prescription</h3>
                                </div>
                                <div class="panel-body form-group-separated">
                                    <div class="container">
                            <?php if(isset($error)&& $error==1){?>
                                    <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                     <?php echo $message;?>
                                    </div>
                                    <?php }if(isset($success)&& $success==1){?>
                                    <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                     <?php echo $message;?>
                                    </div>
                            <?php } ?>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Medicine</label>
                                        <div class="col-md-6 col-xs-12"> 
                                           <select required name="medicine" class="form-control ">
                                              <option value="">Select Medicine</option>
                                              <?php if($med==1){ foreach($medicine as $md) { ?>
                                                <option value="<?php echo $md->id;?>"> <?php echo $md->tablet_name;?>
                                                 </option>
                                                <?php }}else{?>
                                                    <option value=""><?php echo $md_message;?>
                                                    <?php }?>
                                            </select>
                                        </div>                                            
                                    </div>

                                    <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Medicine Timing: Time 1

                                             </label>
                                    <div>
                                            <input type="button" id="more_fields" onclick="add_fields();" value="Add More Time" class="btn btn-primary" >
                                    </div>
                                    <div id="room_fileds">
                                     <div class="col-md-6 col-xs-12">  

                                        <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span>
                                        </span>
                                            <input type="text" name="time[]" class="form-control" />
                                        </div>
                                    </div>
                                    </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">
                                        Medicine Timing:
                                        </label>
                                        <div id="field_div">
                                        <input type="button" value="Add Time" class="btn btn-primary" onclick="add_field();">
                                        </div>
                                    
                                    </div>

                                    <script>
                                        function add_field()
                                        {
                                          var total_text=document.getElementsByClassName("input_text");
                                          total_text=total_text.length+1;
                                          document.getElementById("field_div").innerHTML=document.getElementById("field_div").innerHTML+
                                          "<p id='input_text"+total_text+"_wrapper'><div class='form-group'><label class='col-md-3 col-xs-12 control-label' style='margin-left:8px;'>Time"+total_text+"</label><div class='col-md-6 col-xs-12'><input type='text' name='time[]' class='input_text' id='input_text"+total_text+"' placeholder='Enter Text'><input type='button' value='Remove' onclick=remove_field('input_text"+total_text+"');></div></p>";
                                        }
                                        function remove_field(id)
                                        {
                                          document.getElementById(id+"_wrapper").innerHTML="";
                                        }
                                    </script>

                                    




                                    <script type="text/javascript">
                                    var Time = 1;
                                    function add_fields() {
                                        Time++;
                                        var total_text=document.getElementsByClassName("form-control");
                                        var objTo = document.getElementById('room_fileds')
                                        var divtest = document.createElement("div");
                                        divtest.innerHTML = '<div class="form-group"><label class="col-md-3 col-xs-12 control-label" style="margin-left:8px;">Time'+Time+'</label><div class="col-md-6 col-xs-12"><div class="input-group"><span class="input-group-addon"><span class="fa fa-pencil"></span></span><input type="text" name="time[]" class="form-control" id="" style="max-width:527px;" required /></div><input type="button" value="Remove" onclick=remove_field(););></div></div>';       
                                        objTo.appendChild(divtest)
                                        }


                                        function remove_field(id)
                                        {
                                          document.getElementById(id+"_wrapper").innerHTML="";
                                        }
                                    </script>  


									<div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Prescription</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="prescription" class="form-control" required />
                                            </div>                                            
                                            
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Total Days</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="days" class="form-control" onfocus="my();" required />
                                            </div>                                            
                                            
                                        </div>
                                    </div> 
                                    <script type="text/javascript">
                                        function my()
                                        {

                                        }
                                    </script>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Quantity</label>
                                        <div class="col-md-6 col-xs-12">   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="number" name="quantity" class="form-control" required />
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                    <input type="hidden" name="member_id" value="<?php echo $m_id;?>">
                                    <input type="hidden" name="pharmasist_id" value="<?php echo $p_id;?>">
                                    <input type="hidden" name="prescription_id" value="<?php echo $pres_id;?>">
                                    <button class="btn btn-default">Clear Form</button>  
                                    <input type="submit" name="submit" value="Add Prescription" class="btn btn-primary pull-right">
                            </div>
                            </form>                         
                        </div>
                    </div>  
                    </div>                  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
 
<?php $this->load->view('layout/footer');?> 
    






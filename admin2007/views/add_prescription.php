<?php  $data['page']='five'; $data['title']='Add Prescription'; $this->load->view('layout/header',$data);?>
<!-- PAGE CONTENT WRAPPER -->
                <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css">
                <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo site_url('PrescriptionControler/add_prescription?u_id='.$u_id.'&p_id='.$p_id.'&pres_id='.$pres_id); ?>">

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
                                    <?php } if(isset($success) && $success==1){?>
                                    <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                     <?php echo $message;?>
                                    </div>
                            <?php } ?>
                            

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
                                <label class="col-md-3 col-xs-12 control-label">Manufacturer Name</label>
                                    <div class="col-md-6 col-xs-12">         
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="text" name="company" id="tag" class="form-control" required />
                                        </div> 
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Drug Type</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" name="type" class="form-control" placeholder="Like:Capsule,Tablet etc." required />
                                    </div>  
                                </div>
                            </div>

                            <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Refill Image
                                        </label>
                                        <div class="col-md-6 col-xs-12">                      
                                            <input type="file" class="fileinput btn-primary" name="image" id="filename" title="Browse file"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Number of Dose Days</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="days" pattern="\d+" class="form-control" id="days" onkeyup="addDays()" title="only numbers allow" required />
                                                <input type="hidden" name="endDate" id="endDate">
                                            </div>                                            
                                            
                                        </div>
                                    </div>

                                   <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Dose Time 1</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" name="time[]" pattern="^(1?[0-9]|2[0-9]):[0-5][0-9]$" title="enter correct time like-HH:MM" class="form-control" required />
                                            </div>
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
                                    <label class="col-md-3 col-xs-12 control-label">Dose Direction</label>
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
                                        objNewDiv.innerHTML ='<div class="form-group"><label class="col-md-3 col-xs-12 control-label" style="margin-left:8px;">Dose Time'+intTextBox+'</label><div class="col-md-6 col-xs-12"><div class="input-group"><span class="input-group-addon"><span class="fa fa-pencil"></span></span><input type="text" name="time[]" pattern="^(1?[0-9]|2[0-9]):[0-5][0-9]$" title="enter correct time like-HH:MM" class="form-control" style="max-width:495px;" required /><span class="input-group-addon" style="background-color:#E04B4A;border:3px;"><input type="button" class="btn btn-danger" onclick="removeElement();" value="X"></span></div></div></div>';
                                        }

                                        function removeElement()
                                         {
                                        if(1 < intTextBox) {
                                            document.getElementById('content').removeChild(document.getElementById('div_' + intTextBox));
                                            intTextBox--;
                                        } else {
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
    






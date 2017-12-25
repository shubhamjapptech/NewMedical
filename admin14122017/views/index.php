<?php $data['page']='one'; $this->load->view('layout/header',$data);?>  
    <div class="page-content-wrap">

        <div class="row">
            <div class="col-md-6">
                 <div class="panel panel-default">
                    <div class="table-responsive">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Registred User</b></h3>
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
                                    <table id="customers2" class="table datatable">
                                        <thead>
                                            <tr>
                                            <th class="col-xs-1">Sr.No</th>
                                            <th class="col-xs-2">First Name</th>
                                            <th class="col-xs-2">Last Name</th>
                                            <th class="col-xs-1">Mobile No.</th>
                                            <th class="col-xs-2">Email</th>
                                            <th class="col-xs-2">ZipCode</th>
                                            <th class="col-md-2">Creat_At</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                          $i=1;  
                                        foreach($userlist as $list) { ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $list->first_name;?></td>
                                                <td><?php echo $list->last_name;?></td>
                                                <td><?php echo $list->phone;?></td>
                                                <td><?php echo $list->email;?></td>
                                                <td><?php echo $list->zipcode;?></td>
                                                <td><?php echo $list->timestamp;?></td>
                                          </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>                                    
                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->
                        </div>
                    </div>    
                     <!-- Pharmasist List -->         
            
                     <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="table-responsive">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Pharmasist</strong></h3>
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
                                    <table id="customers2" class="table datatable">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Sr.No.</th>
                                                <th class="col-md-2">Pharmasist Name</th>
                                                <th class="col-md-1">Phone Number</th>
                                                <th class="col-md-2">Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                          $i=1;  
                                         foreach($pharmalist as $list) { ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $list->name;?></td>
                                                <td><?php echo $list->phone;?></td>
                                                <td><?php echo $list->address;?></td>
                                          </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>                                    
                                    
                                </div>
                            </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->
                        </div>
                    </div>

 <div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Remove <strong>Data</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to remove this row?</p>                    
                        <p>Press Yes if you sure.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button class="btn btn-success btn-lg mb-control-yes">Yes</button>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTAINER -->

<?php $this->load->view('layout/second_footer');?>  







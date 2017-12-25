<?php $data['page']='one'; $data['title']='DashBoard'; $this->load->view('layout/header',$data);  ?>
                
                <div class="page-content-wrap" style="background: darkgray;">

                <div class="row">                        
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(243,112,34);">
                                    <h3 class="panel-title" style="color:white;"><strong>Screen Event Action Chart</h3>
                                </div>
                                <div class="panel-body" style="margin-left:3%">                                    
                                    <iframe width="99%" height="314" overflow-x="auto" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=837117019&amp;format=interactive"></iframe>
                                                                                    
                                </div>
                                 <span style="float: right;margin-right:5%; margin-bottom:2%">
                                <a href="<?php echo site_url('Admin/eventAction'); ?>">See full Details</a>
                                </span>  
                            </div> 
                        </div>
                </div>
                 <div class="row">

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(243,112,34);">
                                    <h3 class="panel-title" style="color:white;"><strong>This Week Screen Session chart</h3>
                                </div>
                                <div class="panel-body" style="margin-left:3%;">                                    
                                    <iframe width="99%" height="314" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=423776240&amp;format=interactive"></iframe>
                                </div>
                                <span style="float: right;margin-right:5%;margin-bottom:3%">
                                   <a href="<?php echo site_url('Admin/screenSession');?>">See full Details</a>
                                </span>
                            </div>                            
                        </div>
                </div>

                      
                    
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(243,112,34);">
                                    <h3 class="panel-title" style="color:white;"><strong>This Year Screen Session chart</h3>
                                </div>
                                <div class="panel-body">                                    
                                    <iframe width="100%" height="313" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=1838454282&amp;format=interactive"></iframe>
                                </div>
                            </div>                                                        
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(243,112,34);">
                                    <h3 class="panel-title" style="color:white;"><strong>This year App session country</h3>
                                </div>
                                <div class="panel-body">                                    
                                    <iframe width="100%" height="313" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=582573844&amp;format=interactive"></iframe>
                                </div>
                            </div>                            
                        </div>


                        
                        <!--div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">This Week Screen Session Table</h3>
                                </div>
                                <div class="panel-body">                                    
                                    <iframe width="603" height="292.5" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=1318599880&amp;format=interactive"></iframe>
                                </div>
                            </div>                            
                        </div-->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(243,112,34);">
                                    <h3 class="panel-title" style="color:white;"><strong>This week App user</h3>
                                </div>
                                <div class="panel-body">                                    
                                    <iframe width="100%" height="300" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=240977260&amp;format=interactive"></iframe>
                                </div>

                            </div>                            
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(243,112,34);">
                                    <h3 class="panel-title" style="color:white;"><strong>This week App Session</h3>
                                </div>
                                <div class="panel-body">                                    
                                     <iframe width="100%" height="300" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=2047358512&amp;format=interactive"></iframe>
                                </div>
                            </div>                            
                        </div>
                    </div>                

                </div>
                <!-- END PAGE CONTENT WRAPPER -->      
        
        <?php $this->load->view('layout/footer'); ?>        
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/rickshaw/d3.v3.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/rickshaw/rickshaw.min.js">
        </script>     
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/demo_charts_rickshaw.js"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->   


        <!-- Modal for Screen event Start-->
        <div id="screenEvent" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">This week Screen Events</h4>
              </div>
              <div class="modal-body">
                <iframe width="525" height="285.5" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=931409302&amp;format=interactive"></iframe>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Modal for Screen event end-->



        <!-- Modal for Screen Session Start-->
        <div id="screenSession" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal1">&times;</button>
                <h4 class="modal-title">This week Screen Session</h4>
              </div>
              <div class="modal-body">
                <iframe width="602.5" height="317" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=1318599880&amp;format=interactive"></iframe>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Modal for Screen Session end-->





















    </body>
</html>









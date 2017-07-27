<?php $data['page']='one'; $this->load->view('layout/header',$data);  ?>
                
            <div class="page-content-wrap" style="background: darkgray;">

                <div class="row">                        
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(8, 11, 105);">
                                    <h3 class="panel-title" style="color:rgb(243,112,34);"><strong>This week Screen Event Action Chart</h3>
                                </div>
                                <div class="panel-body" style="margin-left:3%">                                    
                                    <iframe width="99%" height="314" overflow-x="auto" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=837117019&amp;format=interactive"></iframe>                                  
                                </div>
                            </div> 
                        </div>
                </div>
                 <div class="row">

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background:rgb(8, 11, 105);">
                                    <h3 class="panel-title" style="color:rgb(243,112,34);"><strong>Screen Event Action Table</h3>
                                </div>
                                <div class="panel-body" style="margin-left:3%;">                                    
                                     <iframe width="948.5" height="276" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/1L1tHgQfk3dGVtgiqA5qxOm6gEM2oi_C4V2_dzb6XI5o/pubchart?oid=931409302&amp;format=interactive"></iframe>
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


    </body>
</html>









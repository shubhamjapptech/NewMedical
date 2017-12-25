 </div>            

            <!-- END PAGE CONTENT -->

        </div>

        <!-- END PAGE CONTAINER -->    



        <!-- MESSAGE BOX-->

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

        <!-- END MESSAGE BOX-->        

        

        <!-- MESSAGE BOX-->

        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">

            <div class="mb-container">

                <div class="mb-middle">

                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>

                    <div class="mb-content">

                        <p>Are you sure you want to log out?</p>                    

                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>

                    </div>

                    <div class="mb-footer">

                        <div class="pull-right">

                            <a href="<?php echo base_url();?>index.php/admin/logout" class="btn btn-success btn-lg">Yes</a>

                            <button class="btn btn-default btn-lg mb-control-close">No</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- END MESSAGE BOX-->



        <!-- START PRELOADS -->

        <audio id="audio-alert" src="<?php echo base_url(); ?>assest/audio/alert.mp3" preload="auto"></audio>

        <audio id="audio-fail" src="<?php echo base_url(); ?>assest/audio/fail.mp3" preload="auto"></audio>

        <!-- END PRELOADS -->                      



    <!-- START SCRIPTS -->

        <!-- START PLUGINS -->

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/jquery/jquery.min.js"></script> 

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/jquery/jquery-ui.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/bootstrap/bootstrap.min.js"></script>        

        <!-- END PLUGINS -->

        

        <!-- START THIS PAGE PLUGINS-->        

        <script type='text/javascript' src='<?php echo base_url();?>assest/js/plugins/icheck/icheck.min.js'></script>

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

        

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/datatables/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/tableexport/tableExport.js"></script>

       

    <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/tableexport/jquery.base64.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/tableexport/html2canvas.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/tableexport/jspdf/libs/sprintf.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/tableexport/jspdf/jspdf.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/tableexport/jspdf/libs/base64.js"></script>        

        <!-- END THIS PAGE PLUGINS-->  


        <!-- START TEMPLATE -->

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/settings.js"></script>

        

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins.js"></script>        

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/actions.js"></script>        

        <!-- END TEMPLATE -->

    <!-- END SCRIPTS -->                 

    </body>

</html>
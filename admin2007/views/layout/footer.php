			</div>            
            <!-- END PAGE CONTENT -->
        </div>

        <!-- END PAGE CONTAINER -->

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
        <!--Autocomplete script-->      
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script>
 $(document).ready(function(){
    $("#tag").keyup(function(){ 
        $("#tag").autocomplete({
        source:"http://app.repillrx.com/medical/index.php/PrescriptionControler/search_company/?"
        });
    });
    
    $("#medicine").autocomplete({
        source:"http://app.repillrx.com/medical/index.php/PrescriptionControler/search_medicine/?"
    });     
 });
</script> -->
<!--Auto Complete Script end-->


        <!-- START PRELOADS -->

        <audio id="audio-alert" src="<?php echo base_url();?>assest/audio/alert.mp3" preload="auto"></audio>

        <audio id="audio-fail" src="<?php echo base_url();?>assest/audio/fail.mp3" preload="auto"></audio>

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

		

		

		<script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/bootstrap/bootstrap-datepicker.js"></script>                

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/bootstrap/bootstrap-file-input.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/bootstrap/bootstrap-select.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

        <!-- END THIS PAGE PLUGINS-->  

        

        <!-- START TEMPLATE -->

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/settings.js"></script>

        

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins.js"></script>        

        <script type="text/javascript" src="<?php echo base_url();?>assest/js/actions.js"></script>        

        <!-- END TEMPLATE -->

    <!-- END SCRIPTS -->                 

    </body>
</html>



















        
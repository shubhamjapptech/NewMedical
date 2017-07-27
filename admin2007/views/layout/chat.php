<?php $data['page']='seven';
$this->load->view('layout/chatheader',$data); ?>
    <link rel="shortcut icon" href="https://quickblox.com/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assest/chat/libs/stickerpipe/css/stickerpipe.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assest/chat/css/style.css'); ?>">
</head>
<body>
    <div class="container" style="border:2px solid black; margin-top:100px;">
    <div id="main_block">

        <div class="panel panel-primary">
          <div class="panel-body">
            <div class="row">

            <div class="col-md-4">
                <div class="list-header" style="background-color:rgb(243,112,34)!important;">
                  <h4 class="list-header-title"><strong>Chat</strong></h4>
                </div>
                <div class="list-group pre-scrollable nice-scroll" id="dialogs-list">

                  <!-- list of chat dialogs will be here -->

                </div>
              </div>
              
              <div id="mcs_container" class="col-md-8">
                <div class="container del-style">
                  <div class="content list-group pre-scrollable nice-scroll" id="messages-list">
                   <!-- list of chat messages will be here -->
                  </div>
                </div>

                <div><img src="<?php base_url('assest/chat/images/ajax-loader.gif'); ?>" class="load-msg"></div>
                <form class="form-inline" role="form" method="POST" action="" onsubmit="return submit_handler(this)">
                  <div class="input-group">
                    <span class="input-group-btn input-group-btn_change_load">
  	                  <input id="load-img" type="file">
  	                <button type="button" id="attach_btn" class="btn btn-default" onclick="$('#load-img').click();">
  		              <i class="icon-photo"></i>
  	                </button>
                    </span>
                    <span class="input-group-btn input-group-btn_change_load">
  	                <button type="button" id="stickers_btn" class="btn btn-default" onclick="" style="display:none;">
  		              <i class="icon-sticker"></i>
  	                </button>
                    </span>

                    <span class="input-group-btn" style="width: 100%;">
  	                 <input type="text" class="form-control" id="message_text" placeholder="Enter message">
                    </span>

                    <span class="input-group-btn">
  	                   <button  type="submit" id="send_btn" class="btn btn-success" onclick="clickSendMessage()">Send</button>
                    </span>
                    </div>
                  <img src="<?php base_url('assest/chat/images/ajax-loader.gif');?>" id="progress">
                </form>
              </div>
              

              </div>
            </div>
          </div>
        </div>

    </div>

    <!-- Modal (login to chat)-->
    <div id="loginForm" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Repill Chat</h3>
          </div>
          <div class="modal-body">
            <button type="button" value="Quick" id="user1" class="btn btn-primary btn-lg btn-block">Sign in Repill</button>
            <!-- <button type="button" value="Blox" id="user2" class="btn btn-success btn-lg btn-block">Sign in with Blox</button> -->
            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal (new dialog)-->
    <div id="add_new_dialog" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Choose users to create a dialog with</h3>
          </div>
          <div class="modal-body">
            <div class="list-group pre-scrollable for-scroll">
              <div id="users_list" class="clearfix"></div>
            </div>
            <div class="img-place"><img src="images/ajax-loader.gif" id="load-users"></div>
              <input type="text" class="form-control" id="dlg_name" placeholder="Enter dialog name">
            <button id="add-dialog" type="button" value="Confirm" id="" class="btn btn-success btn-lg btn-block" onclick="createNewDialog()">Create dialog</button>
            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal (update dialog)-->
    <div id="update_dialog" class="modal fade row" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Dialog info</h3>
          </div>
          <div class="modal-body">
            <div class="col-md-12 col-sm-12 col-xs-12 new-info">
              <h5 class="col-md-12 col-sm-12 col-xs-12">Name:</h5>
              <input type="text" class="form-control" id="dialog-name-input">
            </div>
            <h5 class="col-md-12 col-sm-12 col-xs-12 push">Add more user (select to add):</h5>
            <div class="list-group pre-scrollable occupants" id="push_usersList">
              <div id="add_new_occupant" class="clearfix"></div>
            </div>
            <h5 class="col-md-12 col-sm-12 col-xs-12 dialog-type-info"></h5>
            <h5 class="col-md-12 col-sm-12 col-xs-12" id="all_occupants"></h5>
            <button id="update_dialog_button" type="button" value="Confirm" id="" class="btn btn-success btn-ms btn-block"
              onclick="onDialogUpdate()">Update</button>
            <button id="delete_dialog_button" type="button" value="Confirm" id="for_width" class="btn btn-danger btn-ms btn-block"
              onclick="onDialogDelete()">Delete dialog</button>
          </div>
        </div>
      </div>
    </div>

    </div>
  </div>
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

  <!-- Footer-->

      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <!-- <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/jquery/jquery.min.js"></script> -->
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->

        
        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='<?php echo base_url();?>assest/js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>    
    
        <!-- END THIS PAGE PLUGINS--> 
       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/settings.js"></script>       
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/plugins.js"></script>        
        <script type="text/javascript" src="<?php echo base_url();?>assest/js/actions.js"></script>

        <!-- END TEMPLATE -->

    <!-- END SCRIPTS -->                 

  <!-- Footer End -->
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.0/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.1/jquery.timeago.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url('assest/chat/quickblox.min.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/libs/stickerpipe/js/stickerpipe.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/js/config.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/js/connection.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/js/messages.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/js/stickerpipe.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/js/ui_helpers.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/js/dialogs.js');?>"></script>
    <script src="<?php echo base_url('assest/chat/js/users.js');?>"></script>
</body>
</html>



<script>
var QBApp = {
    appId: 51783,
    authKey: 'LOGryCnBU6rODVe',
    authSecret: 'y7KFHxDSuW4pGJU'
};

var config = {
    chatProtocol: {
        active: 1
    },
    streamManagement: {
        enable: true
    },
    debug: {
        mode: 1,
        file: null
    },
    stickerpipe: {
        elId: 'stickers_btn',
        // apiKey: '847b82c49db21ecec88c510e377b452c',
        apiKey: 'vybhsMQtwAP4PMZtsGRs',
        enableEmojiTab: false,
        enableHistoryTab: true,
        enableStoreTab: true,

        userId: null,

        priceB: '0.99 $',
        priceC: '1.99 $'
    }
};

var QBUser1 = {
        id: 22363083,
        name: 'shubham',
        login: 'shubhamj',
        pass: '9889520019'
    },
    QBUser2 = {
        id: 22407764,
        name: 'govinpatida',
        login: 'govind1235@gmail.com',
        pass: 'govind1235'
    };

QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret, config);

$('.j-version').text('v.' + QB.version + '.' + QB.buildNumber);

</script>


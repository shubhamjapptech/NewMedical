<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title><?php if(isset($title)){ echo $title;} else {echo 'Medical Repile';} ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="SHORTCUT ICON" href="//repillrx.com/wp-content/uploads/2016/11/favicon.ico" type="image/png" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>assest/css/theme-default.css">
        <!-- EOF CSS INCLUDE -->        
        <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
              ga('create', 'UA-101885859-1', 'auto');
              ga('send', 'pageview');
        </script>

        <script src="http://www.google-analytics.com/ga.js" type="text/javascript">
        </script>
        <script type=”text/javascript”>
            var pageTracker = _gat._getTracker("UA-101885859-1");
            pageTracker._trackPageview($page);
        </script>


                                
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
             <?php if($this->session->userdata('status')=='admin'){ ?>
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="<?php echo base_url('index.php/admin/login');?>">Admin</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <?php 
                                $image= $this->session->userdata('img');
                                $name = $this->session->userdata('name');
                            ?>
                            <img src="<?php echo base_url('image/'.$image);?>" alt="<?php echo $name; ?>"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo base_url('image/'.$image); ?>" alt="<?php echo $name; ?>"/>
                          </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $name; ?></div>
                            </div>
                         </div>                                                                     
                    </li>
                    <li class="xn-title">Navigation</li>
                    <li class="<?php if(isset($page) && $page=='one'){ echo 'active';}?>">
                        <a href="<?php echo base_url('index.php/admin/login');?>"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
                    </li>                    
                    <li class="xn-openable <?php if(isset($page) && $page=='two'){ echo 'active';}?>">
                        <a href="#"><span class="fa fa-user"></span> <span class="xn-text">Users</span><label class="badge" id="rowcount1" style="background-color:green !important; margin-left: 10px; border-radius:90% !important"></label></a>
                        <ul>
                            <li><a href="<?php echo site_url('user/insert_user');?>"><span class="fa fa-pencil"></span>Add Users</a></li>
							<li><a href="<?php echo site_url('user/userlist');?>" onclick="javascript:pageTracker._trackPageview('Userlist');"><span class="fa fa-sort-alpha-desc"></span>Get UserList</a></li>
                            <!--li><a href="<!?php echo site_url('user/Fbuserlist');?>"><span class="fa fa-sort-alpha-desc"></span>Fb UserList</a></li-->
                        </ul>
                    </li>
                                    
                    
                    <li class="xn-openable <?php if(isset($page) && $page=='three'){ echo 'active';}?>">
                        <a href="tables.php"><span class="fa fa-table"></span> <span class="xn-text">Pharmacist</span></a>
                        <ul>                            
                           <li><a href="<?php echo site_url('pharmasist/add_pharmasist');?>"><span class="fa fa-pencil"></span>Add Pharmacist</a></li>
						   <li><a href="<?php echo site_url('pharmasist/get_pharmasist');?>"><span class="fa fa-sort-alpha-desc"></span>Get Pharmacist list</a></li>
                        </ul>
                    </li> 

                    <li class="xn-openable <?php if(isset($page) && $page=='four'){ echo 'active';}?>">
                        <a href="<?php echo site_url('pharmacy/get_pharmacy');?>"><span class="fa fa-table"></span> <span class="xn-text">Pharmacy</span></a>
                        <ul>                            
                           <li><a href="<?php echo site_url('pharmacy/add_pharmacy');?>"><span class="fa fa-pencil"></span>Add Pharmacy</a></li>
                           <li><a href="<?php echo site_url('pharmacy/get_pharmacy');?>"><span class="fa fa-sort-alpha-desc"></span>Pharmacy List</a></li>
                        </ul>
                    </li> 
                    
                    <li class="xn-envlop <?php if(isset($page) && $page=='five'){ echo 'active';}?>">
                        <a href="<?php echo site_url('PrescriptionControler');?>"><span class="fa fa-pencil"></span><span class="xn-text">Prescription Request</span><label class="badge" id="rowcount" style="background-color:green !important; margin-left: 10px; border-radius:90% !important"></label></a>
                    </li> 

                    <li class="xn-envlop <?php if(isset($page) && $page=='nine'){ echo 'active';}?>">
                        <a href="<?php echo site_url('PrescriptionControler/renew_prescription');?>"><span class="fa fa-table"></span><span class="xn-text">Renew Request </span><label class="badge" id="rowcount" style="background-color:green !important; margin-left: 10px; border-radius:90% !important"></label></a>
                    </li> 



                    <li class="xn-envlop <?php if(isset($page) && $page=='seven'){ echo 'active';}?>">
                        <a href="<?php echo site_url('user/chat');?>"><span class="fa fa-comments-o" aria-hidden="true"></span><span class="xn-text">Chat</span></a>
                    </li> 
                    <li class="xn-envlop <?php if(isset($page) && $page=='six'){ echo 'active';}?>">
                        <a href="<?php echo site_url('admin/change_password');?>"><span class="fa fa-unlock-alt"></span><span class="xn-text">Change Password</span></a>
                    </li> 
                    <li class="xn-envlop <?php if(isset($page) && $page=='eight'){ echo 'active';}?>">
                        <a href="<?php echo site_url('admin/admin_profile');?>"><span class="fa fa-user"></span><span class="xn-text">Admin Profile</span></a>
                    </li>  

                    <!--li class="xn-envlop <!?php if(isset($page) && $page=='analytics'){ echo 'active';}?>">
                        <a href="<!?php echo site_url('Example');?>"><span class="fa fa-user"></span><span class="xn-text">Analytics</span></a>
                    </li-->                                                                               
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
             <?php } else{ ?>
            <!--if pharmasist login-->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="<?php echo base_url('index.php/admin/login');?>" style="font-size:21px !important;">Pharmacist Panel</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="<?php echo base_url();?>assest/assets/images/users/avatar.jpg" alt="John Doe"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo base_url();?>assest/assets/images/users/avatar.jpg" alt="John Doe"/>
                          </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $this->session->userdata('name');?></div>
                            </div>
                         </div>                                                                     
                    </li>

                    <li class="xn-title">Navigation</li>                   
                    <li class="xn-envlop <?php if(isset($page) && $page=='five'){ echo 'active';}?>">
                        <a href="<?php echo site_url('PrescriptionControler');?>"><span class="fa fa-pencil"></span><span class="xn-text">Prescription Request</span></a>
                    </li> 

                    <li class="xn-envlop <?php if(isset($page) && $page=='nine'){ echo 'active';}?>">
                        <a href="<?php echo site_url('PrescriptionControler/renew_prescription');?>"><span class="fa fa-table"></span><span class="xn-text">Renew Request </span><label class="badge" id="rocount" style="background-color:green !important; margin-left: 10px; border-radius:90% !important"></label></a>
                    </li>



                    <li class="xn-envlop <?php if(isset($page) && $page=='seven'){ echo 'active';}?>">
                        <a href="<?php echo site_url('PrescriptionControler/allprescription?p_id='.$this->session->userdata('id'));?>"><span class="fa fa-table"></span><span class="xn-text">All Prescription</span></a>
                    </li>
                    <!--li class="xn-envlop">
                        <a href="<!?php echo site_url('tablet?p_id='.$this->session->userdata('id'));?>"><span class="fa fa-table"></span><span class="xn-text">All Medicine</span></a>
                    </li>
                    <li class="xn-envlop">
                        <a href="<!?php echo site_url('tablet/add_medicine?id='.$this->session->userdata('id'));?>"><span class="fa fa-pencil"></span><span class="xn-text">Add Medicine</span></a>
                    </li-->
                    <li class="xn-envlop">
                        <a href="<?php echo site_url('admin/change_password');?>"><span class="fa fa-unlock-alt"></span><span class="xn-text">Change Password</span></a>
                    </li>                                                             
                </ul>
                <!-- END X-NAVIGATION -->
            </div>               
            <!-- PAGE CONTENT -->
            <?php } ?>

            
            <!-- PAGE CONTENT -->


            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->                 
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout">
                        <span style="position: relative;  right: 32px;" class="fa fa-sign-out">LogOut</span></span></a>                        
                    </li>  
                    <!-- END SIGN OUT -->     
                </ul>
             
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <!--ul class="breadcrumb">
                    <li><a href="#">Home</a></li>                    
                    <li class="active">Dashboard</li>
                </ul-->
                <!-- END BREADCRUMB -->                       
        <!-- PAGE CONTENT WRAPPER -->
 <?php if($this->session->userdata('status')=='admin'){ ?>       
<script>
function popupremove()
{
    $('#myModal').modal('hide');
    $.ajax({
            url: "http://52.41.221.184/medical/index.php/PrescriptionControler/popupremove",
            success: function (popup) 
            {
                //console.log(popup);
            }
        });
}
setInterval(function() {
        checkprescription();// Do something every 5 seconds
        checkuser();
        checkpopup();
}, 4000);
function checkprescription()
{
    $.ajax({
        url: "http://52.41.221.184/medical/index.php/PrescriptionControler/checkprescription",
        success: function (data) {
            //console.log(data);
            if(data!=0)
            {
                $("#rowcount").html(data);
            }
        }
    });
};

function checkuser() {
            $.ajax({
                url: "http://52.41.221.184/medical/index.php/user/checkuser",
                success: function (list) {
                    //console.log(list);
                    if(list!=0){
                    $("#rowcount1").html(list);
                    }
                }
        });
    };

function checkpopup()
{
    $.ajax({
           dataType: "json",
            url: "http://52.41.221.184/medical/index.php/PrescriptionControler/checkpopup",
            success: function (popup) 
            {
                //console.log(popup);
                if(popup.name)
                {
                    $('#myModal').modal('show');
                    $('#des').html(popup.name);
                }
            }
        });
}
</script>

<?php } ?>

<div id="myModal" class="modal fade" role="dialog" style="background-color: transparent;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" onclick="popupremove()">&times;</button>
        <h4 class="modal-title">New Prescription Request</h4>
      </div>
      <div class="modal-body" id="des"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="popupremove()">Close</button>
      </div>
    </div>

  </div>
</div>
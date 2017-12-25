<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Medical Repill</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="SHORTCUT ICON" href="//repillrx.com/wp-content/uploads/2016/11/favicon.ico" type="image/png" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>assest/css/theme-default.css">
        <!-- EOF CSS INCLUDE -->        
                                
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="<?php echo base_url('index.php/admin/login');?>">Admin</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="<?php echo base_url();?>image/default.png" alt="John Doe"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                              <img src="<?php echo base_url();?>image/default.png" alt="John Doe"/>
                          </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $this->session->userdata('name'); ?></div>
                            </div>
                         </div>                                                                        
                    </li>
                    <li class="xn-title">Navigation</li>
                    <li class="active">
                        <a href="<?php echo base_url('index.php/admin/login');?>"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
                    </li>                    
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Users</span></a>
                        <ul>
                            <li><a href="<?php echo site_url('user/insert_user');?>">Add Users</a></li>
							<li><a href="<?php echo site_url('user/userlist');?>">Get UserList</a></li>
                        </ul>
                    </li>
                                    
                    
                    <li class="xn-openable">
                        <a href="tables.php"><span class="fa fa-table"></span> <span class="xn-text">Pharmasist</span></a>
                        <ul>                            
                           <li><a href="<?php echo site_url('pharmasist/add_pharmasist');?>"><span class="fa fa-sort-alpha-desc"></span>Add Pharmasist</a></li>
						   <li><a href="<?php echo site_url('pharmasist/get_pharmasist');?>"><span class="fa fa-sort-alpha-desc"></span>Get Pharmasistlist</a></li>
                        </ul>
                    </li> 
                    <li class="xn-envlop">
                        <a href="<?php echo site_url('admin/change_password');?>"><span class="fa fa-unlock-alt"></span><span class="xn-text">Change Password</span></a>
                    </li>                                                             
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->


            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                    <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li>   
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                  <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                </li>  
                    <!-- END SIGN OUT -->
                    
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>                    
                    <li class="active">Dashboard</li>
                </ul>
                <!-- END BREADCRUMB -->                       
        <!-- PAGE CONTENT WRAPPER -->
		
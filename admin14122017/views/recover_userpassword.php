<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
    <style>
        span{
            color:red;
            font-size: 16px;
        }
    </style>
        <!-- META SECTION -->
        <title>Recover Password</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="SHORTCUT ICON" href="<?php echo base_url('assest/favicon.png');?>" type="image/png" />
        <!-- END META SECTION -->      
        <!-- CSS INCLUDE --> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>     
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>assest/css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
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
    <body>
        
        <div class="login-container">
            <div class="login-box animated fadeInDown">
            <?php if(isset($success) && $success==1) { ?>
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $message;?>
            </div>
            <?php } else if(isset($error) && $error==1) { ?>
                <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $message;?>
            </div>
            <?php } ?>
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Forget</strong> Password</div>
                    <form class="form-horizontal" method="post" action="<?php echo site_url("admin/recover_userpassword?email=$email");?>">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="hidden" name="email" value="<?php echo $email; ?>">  
                            <input type="text" name="new_password" class="form-control" placeholder="Enter New Password" minlength="8" required /> 
                            <span><?php echo form_error('new_password');?></span> 
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">  
                            <input type="text" name="confirm_password" class="form-control" placeholder="Enter Confirm Password" minlength="8" required /> 
                            <span><?php echo form_error('confirm_password');?></span> 
                    </div>
                    </div>
                        <div class="col-md-6 pull-right">
                            <input type="submit" name="recover" value="Submit" class="btn btn-info btn-block">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>







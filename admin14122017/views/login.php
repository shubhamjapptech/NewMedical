
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
        <title>Dashboard Login</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="SHORTCUT ICON" href="<?php echo base_url('assest/favicon.png');?>" type="image/png" />
        <!-- END META SECTION -->      
        <!-- CSS INCLUDE --> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assest/css/theme-default.css'); ?>"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
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
                <div class="login-logo"><img src="<?php echo base_url('assest/Icon.png'); ?>" style="border-radius:15%;"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Welcome</strong>, Please login</div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="email" class="form-control" placeholder="email"/>   
                            <span><?php echo form_error('email');?></span>                        
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name="password" class="form-control" placeholder="Password"/> 
                            <span><?php echo form_error('password');?></span>                           
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="<?php echo site_url('admin/forget_password');?>" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                        <div class="col-md-6">
                            <input type="submit" name="login" value="LogIn" class="btn btn-info btn-block">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-right">
                        <a target="blank" href="http://repillrx.com/about-us" >About</a> |
                        <a target="blank" href="http://repillrx.com/privacy-policy">Privacy</a> |
                        <a target="blank" href="http://repillrx.com/support/contact">Contact Us</a>
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>
</html>







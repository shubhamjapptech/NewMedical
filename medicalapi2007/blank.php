<?php 
if(isset($_FILES['insurance_image']) && $_FILES['insurance_image']!='')
{
    $insurancename  = $randno.$_FILES['insurance_image']['name'];
    $s  = $_FILES['insurance_image']['tmp_name'];
    $nn = preg_replace('/\s*/m', '',$insurancename);
    $d  = '../../medical/image/'.$nn;
    if(move_uploaded_file($s,$d))
    {
        echo "success";
    }
    else
    {
        echo "not";
    }
}   
die();
?>
<?php include('header.php'); ?>                   

                

                <!-- PAGE CONTENT WRAPPER -->

                <div class="page-content-wrap">

                

                    <div class="row">

                        <div class="col-md-12">



                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h3 class="panel-title">Panel Title</h3>

                                </div>

                                <div class="panel-body">

                                    Panel body

                                </div>

                            </div>



                        </div>

                    </div>

                

                </div>

                <!-- END PAGE CONTENT WRAPPER -->                

            </div>            

            <!-- END PAGE CONTENT -->

        </div>

        <!-- END PAGE CONTAINER -->

<?php include('footer.php'); ?>














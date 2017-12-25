<?php $data['page']='Goodrx'; $data['title']='GoodRx'; $this->load->view('layout/header',$data);?> 

<style>
    #goodrx_search_widget .w-footer
    {
        display: none !important;
    }
    .form-group-separated .form-group
    {
        border-bottom:none!important;
    }
</style>

<!--script>
    var _grxdn = "lipitor";
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src="//s3.amazonaws.com/assets.goodrx.com/static/widgets/search.min.js";
        s.parentNode.insertBefore(g,s)}(document,"script"));
</script>

<div id="goodrx_search_widget"> </div-->

<div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>GoodRx</strong></h3>
                                       
                                </div>
                                <div class="container-fluid">
                                <form action="https://www.goodrx.com" method="GET" target="_blank">

                                <div class="panel-body form-group-separated">                                   
                            <?php if(isset($error)&& $error==1) { ?>
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php }  if(isset($success)&& $success==1){?>
                            <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $message;?>
                            </div>
                            <?php }?>
                                <div class="form-group">                                 
                                    <label class="col-md-3 col-xs-12 control-label">Drug Name</label>
                                    <div class="col-md-9 col-xs-12">
                                        <input type="text" name="drug-name" id="drug-name" value="" class="w-drug-name form-control"/>
                                    </div>                                               
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-md-3 col-xs-12 control-label">Zip Code</label>
                                    <div class="col-md-9 col-xs-12">
                                        <input type="text" id="w-location" name="location" value="" class="w-location form-control" size="6" maxlength="5"/>
                                    </div>
                                    <input type="hidden" name="modify_location" value="1">        
                                    <input type="hidden" name="widget" value="1"> 
                                    <input type="hidden" name="w" value="search-widget"> 
                                    <input type="hidden" name="ref" value="http://18.221.70.138/medical/index.php/User/GoodRx">                          
                                </div>
                                <div class="panel-footer">    
                                    <input type="submit" name="submit" value="Go" class="btn btn-success pull-right" style="width:100%; max-width:300px; margin-top:5px">
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>                    

        </div>

<?php $this->load->view('layout/footer');?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <script type="text/javascript" src="jquery-1.11.2.js"></script>
    <script type="text/javascript" src="bootstrap.js"></script>
    <style type="text/css">
      .my-img a {
        display: inline-block;
        margin: 10px;
        border: 2px solid #CCC;
      }
      .my-img a:hover {
        border: 2px solid #45AFFF;
      }    
      .modal-lg {
        width: 86%;
      }
      .modal-body {
        overflow: auto;
        max-height: auto;
      }
    </style>
</head>
<body>

<div class="container">
  <h2>Modal Example</h2>
  <!-- Trigger the modal with a button -->
  <div class="row">
    <div class="col-xs-12 my-img">
      <a href="#" id="link1" data-toggle="modal" data-target="#myModal">
        <img src="1.png" id="img1" class="img-responsive" width="250px">
      </a>
      <a href="#" id="link1" data-toggle="modal" data-target="#myModal">
        <img src="2.png" id="img2" class="img-responsive" width="250px">
      </a>
      <a href="#" id="link1" data-toggle="modal" data-target="#myModal">
        <img src="3.png" id="img3" class="img-responsive" width="250px">
      </a>
      <a href="#" id="link1" data-toggle="modal" data-target="#myModal">
        <img src="4.png" id="img4" class="img-responsive" width="250px">
      </a>          
  </div>  

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">your image title here (can be dynamic) </h4>
        </div>
        <div class="modal-body" id="showImg">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

</div>
<script type="text/javascript">
      $(document).ready(function() {
        $('img').on('click', function() {
          $("#showImg").empty();
          var image = $(this).attr("src");
          $("#showImg").append("<img class='img-responsive' src='" + image + "' />")
          //alert(image);
        })
      });
</script>

</body>
</html>
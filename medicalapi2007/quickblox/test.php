<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://cdn.digits.com/1/sdk.js" id="digits-sdk" async></script><!-- TWITTER_DIGITS SDK -->
  <script src="quickblox.min.js"></script>
  <script src="config.js"></script>
  <script src="changeuser.js"></script>
<script>
var QBApp = {
    appId: 51783,
  authKey: 'LOGryCnBU6rODVe',
  authSecret: 'y7KFHxDSuW4pGJU'
};

$(document).ready(function()
{
  QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret);
  QB.createSession(function(err,result){
    console.log('Session create callback', err, result);
    var old_password='adminxyz12';
    var password ='adminxyz';
    var params = { 'login':'adminxyz@gmail.com', 'password':'adminxyz12'};
    QB.login(params, function(err, user){
      console.log('callback', err, user);
      if (user) {
      $('#output_place').val(JSON.stringify(user));
      QB.users.update(parseInt(23809010), {old_password:old_password,password:password}, function(err, user){
      if (user) {
        //$('#output_place').val(user);
        $('#output_place1').val(JSON.stringify(user));
      }
      else
      {
        $('#output_place1').val(JSON.stringify(err));
      }
        $("#progressModal").modal("hide");
        $("html, body").animate({ scrollTop: 0 }, "slow");
      });      
    }
    else  
    {
        $('#output_place').val(JSON.stringify(err));
    }
    $("#progressModal").modal("hide");
    $("html, body").animate({ scrollTop: 0 }, "slow");
    });
    
  });
});
</script>
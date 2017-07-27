// Init QuickBlox application here
//
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
    var params = { 'login':'adminxyz@gmail.com', 'password':'adminxyz12'};
    QB.login(params, function(err, user){
      console.log('callback', err, user);
      if (user) {
      $('#output_place').val(JSON.stringify(user));
      QB.users.update(parseInt(23809010), {old_password:'adminxyz12',password:'adminxyz'}, function(err, user){
      if (user) {
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
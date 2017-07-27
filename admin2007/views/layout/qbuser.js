// Init QuickBlox application here
//
QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret);

$(document).ready(function() {
  QB.createSession(function(err,result){
    console.log('Session create callback', err, result);
  });

  // Login user
  //
  $('#sign_in').on('click', function() {
    var login = $('#usr_sgn_n_lgn').val();
    var password = $('#usr_sgn_n_pwd').val();
    var params = { 'login': login, 'password': password};
    QB.login(params, function(err, user){
      if (user) {
        $('#output_place').val(JSON.stringify(user));
      } else  {
        $('#output_place').val(JSON.stringify(err));
      }

      $("#progressModal").modal("hide");

      $("html, body").animate({scrollTop:0},"slow");
    });
  });
  // Update user
  //
  $('#update').on('click', function() {
    var user_id = $('#usr_upd_id').val();
    // var user_fullname = $('#usr_upd_full_name').val();
    // var user_email = $('#usr_upd_email').val();
    var user_oldpassword = $('#old_password').val();
    var user_password = $('#usr_upd_password').val();
    QB.users.update(parseInt(user_id), {old_password: user_oldpassword,password: user_password}, function(err, user){
      if (user) {
        $('#output_place').val(JSON.stringify(user));
      }
       else  {
        $('#output_place').val(JSON.stringify(err));
      }

      $("#progressModal").modal("hide");

      $("html, body").animate({ scrollTop: 0 }, "slow");
    });
  });

  // Delete user

  $('#delete_by').on('click', function() {
    var user_id = $('#delete_by').val();
    params = parseInt(user_id);
    QB.users.delete(params, function(err, user){
      if (user) {
        $('#output_place').val(JSON.stringify(user));
      } else  {
        $('#output_place').val(JSON.stringify(err));
      }

      $("#progressModal").modal("hide");

      $("html, body").animate({ scrollTop: 0 }, "slow");
    });
  });

});
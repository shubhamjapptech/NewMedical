var QBApp = 
{
  	appId: 51783,
	authKey: 'LOGryCnBU6rODVe',
	authSecret: 'y7KFHxDSuW4pGJU'
};
$(document).ready(function() {
	QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret);
	QB.createSession(function(err,result)
	{
    	console.log('Session create callback', err, result);
  	});
});
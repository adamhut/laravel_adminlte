var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

var redis = require('redis');

server.listen(8890);

io.on('connection', function(socket){
	console.log('Client connect');

	var redisClient = redis.createClient({host : '192.168.1.135', port : 6379});
	redisClient.auth('Bacera255106',function(err,reply) {
	 	console.log(reply);
	});
	redisClient.subscribe('message');
	redisClient.subscribe('user_image_uploaded');

	redisClient.on("message" , function(channel, message){
		//console.log('new event '+ channel+ message);
		socket.emit(channel, message);
	});
	/*
	redisClient.on("user_image_uploaded" , function(channel, message){
		//console.log('new event '+ channel+ message);
		socket.emit(channel, message);
	});
	*/


	redisClient.on("disconnect" , function(){
		redisClient.quit();

	});
});
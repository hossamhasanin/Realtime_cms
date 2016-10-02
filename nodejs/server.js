var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

var redis = require('redis');

 

server.listen(8890);

io.on('connection', function (socket) {

 

  console.log("client connected");

  var redisClient = redis.createClient();

  redisClient.subscribe('postes');
  redisClient.subscribe('message');
  redisClient.subscribe('online_users');
 

  redisClient.on("message", function(channel, data) {

    console.log("new message add in queue "+ data['message'] + " channel " + channel);

    socket.emit(channel, data);

  });

 

  socket.on('disconnect', function() {

    redisClient.quit();

  });

 

});
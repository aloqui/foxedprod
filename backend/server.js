var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(3000, 'localhost', function() {
    console.log('Server running at http://localhost:3000/');
});


io.on('connection', function(socket) {
    console.log('Client connected.');
    var redisClient = redis.createClient();

    redisClient.subscribe('message');
    redisClient.subscribe('favoriteReply');
    redisClient.subscribe('notify');
    redisClient.subscribe('removeNotification');
    redisClient.subscribe('addThread');

    redisClient.on('message', function(channel, message) {
        console.log('New event sent');
        socket.emit(channel, message)
    })
    redisClient.on('favoriteReply', function(channel, message) {
        console.log('Favorited: ' + channel + message);
        socket.emit(channel, message)
    })
    redisClient.on('notify', function(channel, notification) {
        console.log('New Notification: ' + channel + notification);
        socket.emit(channel, notification)
    })
    redisClient.on('removeNotification', function(channel, message) {
        console.log('Seen Notification: ' + channel + message);
        socket.emit(channel, message)
    })

    redisClient.on('disconnect', function() {
        console.log('Client disconnected.');
        redisClient.quit();
    })
    redisClient.on('addThread', function(channel, message) {
        console.log("----");
        console.log('Thread Added');
        socket.emit(channel, message)
    })
})
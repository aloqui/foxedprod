var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');


io.on('connection', function (socket) {
    console.log('Client connected.');
    var redisClient = redis.createClient();

    redisClient.subscribe('message');
    redisClient.subscribe('favoriteReply');
    redisClient.subscribe('notify');

    redisClient.on('message', function (channel, message) {
        console.log('new event' + channel + message);
        socket.emit(channel, message)
    })
    redisClient.on('favoriteReply', function (channel, message) {
        console.log('Favorited: ' + channel + message);
        socket.emit(channel, message)
    })
    redisClient.on('notify', function (channel, notification) {
        console.log('New Notification: ' + channel + notification);
        socket.emit(channel, notification)
    })

    redisClient.on('disconnect', function () {
        console.log('Client disconnected.');
        redisClient.quit();
    })
})
server.listen(3000, function () {
    console.log('listening on *:3000');
});
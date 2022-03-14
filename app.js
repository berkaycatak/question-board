/*var fs = require('fs');

var options = {
  key: fs.readFileSync('sorutahtasi.com.key'),
  cert: fs.readFileSync('sorutahtasi.com.crt')
};

const server = require('http').createServer(options);
const io = require('socket.io')(server);

io.on('connection', function () {
  console.log("birileri bağlandı");
});

server.listen(5222);
*/

var fs = require('fs');
var https = require('https');

var express = require('express');
var app = express();

var options = {
  key: fs.readFileSync('./server.pem'),
  cert: fs.readFileSync('./sorutahtasi.com.crt')
};
var serverPort = 5222;

var server = https.createServer(options, app);
var io = require('socket.io')(server);


io.on('connection', function(socket) {
    console.log('new connection');

    socket.on('send-questions', function(data) {
        io.emit('event-' + data["event_id"], data);
    });

    socket.on('send-vote', function(data) {
        io.emit('vote-event-' + data["event_id"], data);
    });

});

server.listen(serverPort, function() {
  console.log('server up and running at %s port', serverPort);
});

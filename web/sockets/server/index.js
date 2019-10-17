var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

io.on('connection', function(socket){
    socket.on("subscribe", (chat)=> {
        socket.join(chat);
        //console.log("User connected is " + chat + " " + io.sockets.adapter.rooms[chat].length);
    });

    //отправляем в тот сокет, который подписан на data.id_chat
    socket.on("new_message", (data)=> {
        socket.to("chat"+data.id_chat).emit("new_message", data);
    });
});

http.listen(3001, function(){
    console.log('listening on *:3001');
});
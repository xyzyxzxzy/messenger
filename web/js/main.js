$(document).ready(function () {

    //return all list with chats, and get his id.
    //subscribe all this chats on socket
    if (document.querySelectorAll(".inbox_chat > .chat_list").length >= 1) {
        var socket = io('http://localhost:3001');
        [].forEach.call(document.querySelectorAll(".inbox_chat > .chat_list"), (i) => {
            socket.emit("subscribe", "chat" + i.id);
        });

        socket.on("new_message", (data)=> {
            var chat = searchChatLastMess(document.querySelectorAll(".inbox_chat > .chat_list"), data.id_chat);
            if ($(chat.prevObject[0]).hasClass('active_chat')) {
                $(chat).html(data.message);
                $('.msg_history').append(data.tmp_message);
            } else
                $(chat).html(data.message);
        });
    }

    //return obj chat of the chat list on index page, when was sended last message.
    function searchChatLastMess(arr, item, left = 0, right = arr.length) {
        if (arr == 0)
            return 0;
        else if (left > right)
            return NaN;
        else if (arr.length == 1)
            return $(arr[0]).find('.chat_ib > p');

        var mid = Math.round((left + right) / 2);
        if (arr[mid].id == item)
            return $(arr[mid]).find('.chat_ib > p');
        return arr[mid] > item ? searchChatLastMess(arr, item, left, right - 1)
            : searchChatLastMess(arr, item, left + 1, right);
    }

    //send message
    $("#sendMessage").click(function (e) {
        e.preventDefault();

        $.ajax({
                url: '?r=site/message',
                type: 'post',
                dataType: 'json',
                data: $("#send-message-form").serialize() + '&' + 'id_room' + '=' + $("#sendMessage").val()
            })
            .done(function(response) {
                if($(".msg_history").has("p.msg_empty_history")){
                    $(".msg_history").find("p.msg_empty_history").remove();
                    $(".msg_history").append(response.message);
                } else $(".msg_history").append(response.message);
                $(".write_msg").val('');
                var chats = searchChatLastMess(document.querySelectorAll('.chat_list'), $("#sendMessage").val());
                $(chats).html(response.lastMessage.message);
                socket.emit("new_message", response.lastMessage);
            })
            .fail(function() {
                console.log("Error when was sends message.");
            });
    })

    //get history chat by id
    $(".chat_list").click(function (e) {

        $.ajax({
            url: '?chat='+this.id,
            type: 'get',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.length > 1) {
                    $(".inbox_chat").find(".active_chat").removeClass("active_chat");
                    $(e.currentTarget).addClass('active_chat');
                    $(".msg_history").html('');
                    for(var i = 0; i < response[0].length; i++)
                        $(".msg_history").append(response[0][i]);
                    $("#sendMessage").val(e.currentTarget.id);
                } else {
                    $(".inbox_chat").find(".active_chat").removeClass("active_chat");
                    $(e.currentTarget).addClass('active_chat');
                    $(".msg_history").html('');
                    $(".msg_history").append(response.empty_his);
                    $("#sendMessage").val(e.currentTarget.id);
                }
            })
            .fail(function() {
                console.log("Error when was louded.");
            });
    })

    //create new chat between users
    $(document).on("click", ".incoming_msg_img > p", function (e) {
        var id_participant = e.currentTarget.id;

        $.ajax({
                url: '?r=site/createcaht',
                type: 'post',
                dataType: 'json',
                data: 'id_participant' + '=' + id_participant
            })
            .done(function(response) {
               console.log(response);
            })
            .fail(function() {
                console.log("Error create chat.");
            });
    })
})
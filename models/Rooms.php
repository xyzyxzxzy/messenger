<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;




class Rooms extends ActiveRecord
{
    public $id_room;
    public $name_room;
    public $type_user;
    public $id_author_room;

    //get all chats current user, with last message in chat
    public static function getRoomsUser($userId) {
        $sql = "SELECT r.id_room, r.name_room, m.id_author_message, m.message AS `lastMessage` FROM rooms AS r 
            LEFT JOIN participants AS p ON p.id_room = r.id_room
            LEFT JOIN messages AS m ON m.id_room = p.id_room AND m.id_message = (SELECT MAX(messages.id_message) FROM messages WHERE messages.id_room = r.id_room)
            WHERE p.id_user = '$userId' 
            GROUP BY r.id_room";

        return Rooms::findBySql($sql)->asArray()->all();
    }

    //get history messages
    public static function getMessagesRoomByIdRoom($idRoom) {
        $sql = "SELECT r.id_room, id_message, u.login, id_author_message, message FROM messages 
            INNER JOIN rooms AS r ON r.id_room = messages.id_room 
            INNER JOIN users AS u ON u.id_user = messages.id_author_message
            WHERE messages.id_room = '$idRoom' ORDER BY id_message";

        return !empty(Rooms::findBySql($sql)->asArray()->all()) ? Rooms::findBySql($sql)->asArray()->all() : ['id_room' => $idRoom] ;
    }

    public static function getMessageHistiryWithDis($history, $id_user){
        if(isset($history[0]['message'])) {
           $messages = array();
           for ($i = 0; $i < count($history); $i++) {
               if ($history[$i]['id_author_message'] == $id_user) {
                   $messages[] = "
                <div class='outgoing_msg'>
                    <div class='sent_msg'>
                        <p>" . $history[$i]['message'] . "</p>
                    </div>
                </div>";
               } else {
                   $messages[] = "
                    <div class='incoming_msg'>
                    <div class='incoming_msg_img'> 
                        <img src='https://ptetutorials.com/images/user-profile.png' alt='sunil'>
                         <p id=" . $history[$i]['id_author_message'] . ">" . $history[$i]['login'] . "</p>
                    </div>
                    <div class='received_msg'>
                        <div class='received_withd_msg'>
                            <p>" . $history[$i]['message'] . "</p>
                        </div>
                    </div>
                </div>";
               }
           }
           $data['id_room'] = $history[0]["id_room"];

           return [$messages, $data];
       }
        $data['empty_his'] = "<p class='msg_empty_history'>История сообщений пуста.</p>";
       return  $data;
    }
    
    public static function createChat($id_user, $id_participant) {
       Yii::$app->db->createCommand("INSERT INTO rooms (type_user, id_author_room) 
                VALUES (1, $id_user)")->execute();
        $id_new_chat = Yii::$app->db->getLastInsertID();

        return Participants::SetParticipant($id_new_chat, [$id_user, $id_participant]) ? 'true' : 'false';
    }
}
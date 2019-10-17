<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;




class Messages extends ActiveRecord
{
    public $id_message;
    public $id_room;
    public $id_author_message;
    public $message;


    public static function SetMessage($id_room, $message, $id_author) {

        if (!empty($message)) {
            return Yii::$app->db->createCommand("INSERT INTO messages (id_room, id_author_message, message) 
                VALUES ($id_room, $id_author, '$message')")->execute() ? ['id_room' => $id_room,
                'message' =>
                    "<div class='outgoing_msg'>
                       <div class='sent_msg'>
                            <p>" . $message . "</p>
                       </div>
                    </div>",
                'lastMessage' => [
                    'id_chat' => $id_room,
                    'id_author_message' => $id_author,
                    'user_name' => Yii::$app->request->cookies->getValue('login'),
                    'message' => $message,
                    'tmp_message' => 
                        "<div class='incoming_msg'>
                            <div class='incoming_msg_img'>
                                <img src='https://ptetutorials.com/images/user-profile.png' alt='sunil'>
                                <p id='" . $id_author ."'>". Yii::$app->request->cookies->getValue('login') ."</p>
                            </div>
                            <div class='received_msg'>
                                <div class='received_withd_msg'>
                                    <p>" . $message . "</p>
                                </div>
                            </div>
                        </div>"
                ]
            ]
                : ['sendedMessage' => 'error'];
        }

        return ['sendedMessage' => 'error'];
    }


}
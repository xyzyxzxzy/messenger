<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;




class Participants extends ActiveRecord
{
    public $id_participant;
    public $id_room;
    public $id_user;


    public static function SetParticipant($id_room, $id_participants) {
       for($i = 0; $i < count($id_participants); $i++) {
           Yii::$app->db->createCommand("INSERT INTO participants (id_room, id_user) 
            VALUES ($id_room, $id_participants[$i])")->execute();
       }
        return true;
    }


}
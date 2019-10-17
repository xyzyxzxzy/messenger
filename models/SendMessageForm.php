<?php

namespace app\models;

use Yii;
use yii\base\Model;


class SendMessageForm extends Model
{
    public $message;
    
    public function rules()
    {
        return [
            [['message'], 'required']
        ];
    }

    public static function SendMessage($id_room, $message) {

        return Messages::SetMessage($id_room, $message, Yii::$app->request->cookies->getValue('id'));
    }
}

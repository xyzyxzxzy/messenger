<?php

namespace app\models;

use yii\db\ActiveRecord;




class User extends ActiveRecord
{
    public $id;
    public $login;
    public $password;
    public $hash;


    public static function tableName()
    {
        
        return 'users';
    }
    
}
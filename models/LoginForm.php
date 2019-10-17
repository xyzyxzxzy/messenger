<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user = false;


    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }


    public function login()
    {
        if (!empty($this->username) && !empty($this->password)) {
            $user = $this->getUser();
            if ($user){
                if ($user['password'] == $this->password){
                    Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'hash',
                        'value' => $user['hash']
                    ]));
                    Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'login',
                        'value' => $user['login']
                    ]));
                    Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'id',
                        'value' => $user['id_user']
                    ]));
                    
                    return true;
                }
            }
        }

        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->select('*')->where(['login' => $this->username])->asArray()->one();
        }

        return $this->_user;
    }
}

<?php

namespace app\controllers;

use app\models\SendMessageForm;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Rooms;

class SiteController extends Controller
{
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex(){
        if (!Yii::$app->request->cookies->has('hash'))
            return Yii::$app->getResponse()->redirect('?r=site/login');

        $model = new SendMessageForm();
        if($model->load(Yii::$app->request->post())){
            return  SendMessageForm::SendMessage(Yii::$app->request->post()['send-message'], Yii::$app->request->post()['SendMessageForm']['message']);
        }

        //get history chat by id (ajax request)
        if (Yii::$app->request->isAjax) {
            if(Yii::$app->request->get()['chat']){
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    return Rooms::getMessageHistiryWithDis(Rooms::getMessagesRoomByIdRoom((int)Yii::$app->request->get()['chat']), Yii::$app->request->cookies->getValue('id'));
            }
        }
        
        $rooms = Rooms::getRoomsUser(Yii::$app->request->cookies->getValue('id'));
        return $this->render('index', ['data' => [
                'rooms' => $rooms,
                'firstRoomsOnTheLoad' => Rooms::getMessagesRoomByIdRoom(Yii::$app->request->get()['chat'] ? (int)Yii::$app->request->get()['chat'] : $rooms[0]['id_room']),
                'message' => $model
        ]]);
    }

    //send message
    public function actionMessage() {
        $model = new SendMessageForm();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()))
                return SendMessageForm::SendMessage(Yii::$app->request->post()['id_room'], Yii::$app->request->post()['SendMessageForm']['message']);
        }
    }
    
    //create new chat
    public function actionCreatecaht() {
        if (Yii::$app->request->isPost){
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                return Rooms::createChat(Yii::$app->request->cookies->getValue('id'), Yii::$app->request->post('id_participant'));
            }
        }
    }
    
    public function actionLogin()
    {
        if (Yii::$app->request->cookies->has('hash')) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionLogout()
    {
        Yii::$app->response->cookies->remove('hash');
        Yii::$app->response->cookies->remove('login');
        Yii::$app->response->cookies->remove('id');

        return $this->goHome();
    }
}
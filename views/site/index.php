<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Чаты';
?>

    <h3 class=" text-center">Сообщения</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Чаты</h4>
                    </div>
                </div>
                <div class="inbox_chat">
                    <?for($i = 0; $i < count($data['rooms']); $i++):?>
                        <div class="chat_list
                        <?if(Yii::$app->request->get('chat') && $data['rooms'][$i]['id_room'] == Yii::$app->request->get('chat')):?>
                            active_chat
                        <? elseif(!Yii::$app->request->get('chat') && $i < 1): ?>
                            active_chat
                        <?endif;?>"
                             id="<?=$data['rooms'][$i]['id_room']?>">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                </div>
                                <div class="chat_ib">
                                    <h5><?=$data['rooms'][$i]['name_room']?> <span class="chat_date">Dec 25</span></h5>
                                    <p><?if(!empty($data['rooms'][$i]['lastMessage'])):?><?=$data['rooms'][$i]['lastMessage']?> <?else:?> История сообщений пуста. <?endif;?></p>
                                </div>
                            </div>
                        </div>
                    <?endfor;?>

                </div>
            </div>
            <div class="mesgs">
                    <div class="msg_history">
                        
                        <?if(isset($data['firstRoomsOnTheLoad'][0]['message'])):?>
                            <?for($i = 0; $i < count($data['firstRoomsOnTheLoad']); $i++):?>
                                <?if((int)$data['firstRoomsOnTheLoad'][$i]['id_author_message'] == Yii::$app->request->cookies->getValue('id')):?>
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                            <p><?=$data['firstRoomsOnTheLoad'][$i]['message']?></p>
                                        </div>
                                    </div>
                                <?else:?>
                                    <div class="incoming_msg">
                                        <div class="incoming_msg_img">
                                            <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                            <p id="<?=$data['firstRoomsOnTheLoad'][$i]['id_author_message']?>" ><?=$data['firstRoomsOnTheLoad'][$i]['login']?></p>
                                        </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <p><?=$data['firstRoomsOnTheLoad'][$i]['message']?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?endif;?>
                            <?endfor;?>
                        <?else:?>
                            <p class="msg_empty_history">История сообщений пуста.</p>
                        <?endif;?>

                    </div>
                    <div class="type_msg">
                            <? $form = ActiveForm::begin([
                                'id' => 'send-message-form',
                            ])?>
                                <div class="input_msg_write">
                                    <?=$form->field($data['message'], 'message')->textInput(['placeholder' => 'Введите сообщение', 'class' => 'write_msg'])->label('')?>
                                    <?= Html::submitButton('<i class="fa fa-paper-plane-o" aria-hidden="true"></i>', ['class' => 'msg_send_btn', 'id' => 'sendMessage', 'name' => 'send-message', 'value' => $data['firstRoomsOnTheLoad'][0]['id_room']])?>
                                </div>
                            <? ActiveForm::end(); ?>
                    </div>
            </div>
        </div>
    </div>


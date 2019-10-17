<?php
namespace app\assets;

use yii\web\AssetBundle;


class SocketAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'sockets/node_modules/socket.io-client/dist/socket.io.js'
    ];
}

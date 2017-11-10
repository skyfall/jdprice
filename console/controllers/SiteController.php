<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午9:04
 */

namespace console\controllers;


use api\controllers\UserController;
use api\modelsfrom\AddUserFrom;
use yii\console\Controller;

class SiteController extends Controller
{
    public function actionTestadduser(){
        $AddUserFrom = new AddUserFrom();
        $AddUserFrom->app_id = 'app_id';
        $AddUserFrom->openid = 'openid';
        $AddUserFrom->nickname = 'nickname';
        $AddUserFrom->subscribe = 1;
        $AddUserFrom->subscribe_time = time();
        $userController = new UserController();
        $err = [];
        if ($userController->addUser($AddUserFrom,$err)){
            return "OK";
        }
        var_dump($err);
    }

}
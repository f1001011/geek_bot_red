<?php

namespace app\service;

use app\facade\BotFacade;
use app\traits\RedBotTrait;
use app\traits\TelegramTrait;

class BotRedSendService extends BaseService
{
    use TelegramTrait;
    use RedBotTrait;
    public function send($crowd,$messageId=0){
        $list = $this->sendRrdBot($crowd);
        if ($messageId > 0){
            BotFacade::editMessageText($crowd, $messageId,'主菜单', $list);
        }else{
            BotFacade::sendWebhook($crowd,'主菜单',$list);
        }
        return true;
    }

    public function verifyUser($tgUser){
        //组装数据
        //验证 hash

        $this->saveTelegramUserData($tgUser);
        return true;
    }

    //获取tg用户账号
    public function getUserInfo($tgId)
    {
        $user = $this->getTgUser($tgId);
        if (empty($user)){
            return [];
        }
        //验证用户信息是否存在 (平台是否有信息，可以直接注册和直接返回用户不存在)
        list($userInfo) = $this->verifyUserData($user['id'], $user);
        return $userInfo;
    }
}
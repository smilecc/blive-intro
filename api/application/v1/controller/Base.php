<?php

namespace app\v1\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function _initialize ()
    {
        if (input('?user_token')) {
            $this->autoLogin(input('user_token'));
        }
    }

    public function autoLogin ($userToken)
    {
        $userInfo = json_decode(base64_decode($userToken), true);
        if ($userInfo == null) return false;
        if (array_key_exists('id', $userInfo) == false || array_key_exists('token', $userInfo) == false) return false;

        if (model('UserSalt')->checkLogin($userInfo['id'], $userInfo['token'])) {
            $GLOBALS['userId'] = $userInfo['id'];
        }
    }
}

<?php

namespace app\v1\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function _initialize ()
    {
        if (headers_sent() === false) {
			header('Access-Control-Allow-Origin:*');
			header('Access-Control-Expose-Headers:Content-Type, X-SMS-Session');
			header('Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept');
        }
        
        if (request()->isOptions()) {
            exit;
        }

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

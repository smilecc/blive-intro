<?php

namespace app\v1\controller;

use think\Controller;
use think\Request;

class User extends Base
{
    public function login ()
    {
        $account = input('post.account');
        $password = input('post.password');

        return logic('User')->login($account, $password);
    }

    public function register ()
    {
        $username = input('post.username');
        $email = input('post.email');
        $password = input('post.password');

        return logic('User')->register($username, $email, $password);
    }

    public function set_cookie ()
    {
        $cookie = input('post.cookie');
        
        return logic('User')->saveCookie($cookie);
    }

    public function info ()
    {
        return logic('User')->getUserInfo();
    }
}

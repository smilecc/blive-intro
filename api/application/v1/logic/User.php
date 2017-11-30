<?php

namespace app\v1\logic;

use think\Model;

class User extends Model
{
    public function login ($account, $password)
    {
        $user = model('User')->findAccount($account);
        if ($user == null) {
            return result(0, '用户不存在');
        }

        $userSaltDb = model('UserSalt');
        $salt = $userSaltDb->findRegister($user['id']);
        if ($salt == null) {
            return result(0, '用户不存在');
        }

        if (sha1($password . $salt) == $user['password']) {
            // 创建UserToken
            $salt = $userSaltDb->buildSalt($user['id'], $userSaltDb::TYPE_LOGIN);
            $tokenArr = [
                'id' => $user['id'],
                'token' => $salt
            ];
            
            return result(1, '登录成功', [
                'token' => base64_encode(json_encode($tokenArr))
            ]);
        } else {
            return result(0, '密码错误');
        }
    }

    public function register ($username, $email, $password)
    {
        // 判断合法性
        if (strlen($username) < 3) {
            return result(-2, '用户名长度请大于3位');
        }
        if (!preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $email)) {
            return result(-2, '请输入正确的电子邮箱');
        }
        if (strlen($password) < 6) {
            return result(-2, '请输入大于6位的密码');
        }

        $registerResult = model('User')->createAccount($username, $email, $password);
        if (checkResult($registerResult)) {
            // 制作 userToken
            $userId = $registerResult['user_id'];
            $userSaltDb = model('UserSalt');
            $salt = $userSaltDb->buildSalt($userId, $userSaltDb::TYPE_LOGIN);

            $tokenArr = [
                'id' => $userId,
                'token' => $salt
            ];

            return result(1, '注册成功', [
                'token' => base64_encode(json_encode($tokenArr))
            ]);
        } else {
            return $registerResult;
        }
    }

    public function saveCookie ($cookie)
    {
        if (isLogin()) {
            try {
                if ((new \Blive\User($cookie))->checkUser()) {
                    model('BilibiliCookie')->saveCookie($GLOBALS['userId'], $cookie);
                    return result(1, '保存成功');
                } else {
                    return result(0, 'Cookie 无效');
                }
            } catch (\Exception $e) {
                throw $e;
                return result(0, '保存失败，系统错误');
            }
        } else {
            return result(0, '请登录后再进行操作');
        }
    }

    public function getUserInfo ()
    {
        if (isLogin()) {
            $user = model('User')->where('id', $GLOBALS['userId'])->find();

            if ($user == null) {
                return result(0, '用户信息无效');
            } else {
                $cookie = model('BilibiliCookie')->getCookie($GLOBALS['userId']);
                $imageList = model('UserImage')->getImage($GLOBALS['userId']);

                return result(1, '', [
                    'user' => [
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'register_time' => $user['created_time'],
                        'cookie' => $cookie,
                        'image_list' => $imageList
                    ]
                ]);
            }
        } else {
            return result(0, '请登录后再进行操作');
        }
    }
}

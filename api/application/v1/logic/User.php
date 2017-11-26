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

        return model('User')->createAccount($username, $email, $password);
    }
}

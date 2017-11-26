<?php

namespace app\v1\model;

use think\Model;

class User extends Model
{
    public function findAccount ($account)
    {
        $user = $this->where('username', $account)->find();
        if ($user == null) {
            $user = $this->where('email', $account)->find();
            return $user;
        } else {
            return $user;
        }
    }

    public function createAccount ($username, $email, $password)
    {
        try {
            // 判断账户是否重复
            if ($this->where('username', $username)->count() > 0) {
                return result(-1, '用户名已被使用');
            }
            if ($this->where('email', $email)->count() > 0) {
                return result(-1, '邮箱已被使用');
            }
        

            $user_id = $this->insertGetId([
                'username' => $username,
                'email' => $email,
                'password' => ''
            ]);
            
            // 密码加盐
            $userSaltDb = model('UserSalt');
            $random = $userSaltDb->buildSalt($user_id, $userSaltDb::TYPE_REGISTER);
            $password = $password . $random;
            $this->where('id', $user_id)->update([ 'password' => sha1($password) ]);
            
            return result(1, '注册成功');
        } catch (\Exception $e) {
            trace($e, 'ERROR');
            return result(0, '系统错误');
        }
    }

}

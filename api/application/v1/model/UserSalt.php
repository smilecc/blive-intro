<?php

namespace app\v1\model;

use think\Model;

class UserSalt extends Model
{
    const TYPE_REGISTER = 0;
    const TYPE_LOGIN = 1;

    public function buildSalt ($user_id, $type=self::TYPE_LOGIN)
    {
        $random =  md5(rand(1000, 999999) . time() . rand(1000, 999999));
        $random = substr($random, rand(0, 15), 10);

        if (self::TYPE_REGISTER === $type) {
            if ($this->where('user_id', $user_id)->count() > 0) {
                throw new Exception("用户已经存在Type为REGISTER的Salt", 1);
            }
        }

        $this->insert([
            'user_id' => $user_id,
            'random' => $random,
            'type' => $type
        ]);
        
        return $random;
    }

    public function findRegister ($user_id) {
        $salt = $this->where([
            'user_id' => $user_id,
            'type' => self::TYPE_REGISTER
        ])->find();

        if ($salt == null) {
            return null;
        } else {
            return $salt['random'];
        }
    }

    public function checkLogin ($user_id, $random) {
        $salt = $this->where([
            'user_id' => $user_id,
            'type' => self::TYPE_LOGIN,
            'random' => $random
        ])->find();

        if ($salt == null) {
            return false;
        } else {
            return true;
        }
    }
}

<?php

namespace app\v1\model;

use think\Model;

class BilibiliCookie extends Model
{
    public function saveCookie ($userId, $cookie)
    {
        $userCookie = $this->where('user_id', $userId)->find();
        if ($userCookie == null) {
            $this->insert([
                'user_id' => $userId,
                'cookie' => $cookie
            ]);
        } else {
            $this->where('id', $userCookie['id'])->update([
                'cookie' => $cookie,
                'state' => 0
            ]);
        }
        return true;
    }
}

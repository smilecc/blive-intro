<?php

namespace app\v1\model;

use think\Model;

class BilibiliRoom extends Model
{
    public function record ($room, $userId)
    {
        if ($this->where('url', $room)->count() == 0) {
            $this->insert([
                'url' => $room,
                'user_id' => $userId
            ]);
        }

        return true;
    }
}

<?php

namespace app\v1\controller;

use think\Controller;
use think\Request;

class Bilibili extends Base
{
    public function set_introduce ()
    {
        $content = input('post.content');
        
        return logic('Bilibili')->setIntroduce($content);
    }

    public function get_roomid ()
    {
        return logic('Bilibili')->getRoomId();
    }

    public function record_room ()
    {
        $room = input('room');

        return logic('Bilibili')->recordRoom($room);
    }
}

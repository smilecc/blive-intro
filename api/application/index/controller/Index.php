<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Index extends Controller
{
    public function index()
    {
        return result(1, 'Hello world');
    }

    public function test ()
    {
        $blive = new \Blive\User('');
        $roomid = $blive->getRoomId();
        $blive->setIntroduce($roomid, '<p>hello world!!!!!</p>');
    }
}

<?php

namespace app\v1\logic;

use think\Model;

class Bilibili extends Model
{
    public function setIntroduce ($content)
    {
        if (isLogin()) {
            $userid = $GLOBALS['userId'];

            $cookie = model('BilibiliCookie')->getCookie($userid);
            if (empty($cookie)) {
                return result(-1, '请设置Cookie后再进行操作');
            } else {
                $bliveUser = new \Blive\User($cookie);
                $roomid = $bliveUser->getRoomId();
                if ($roomid == false) {
                    return result(-2, 'Cookie 失效，无法获取直播间ID');
                }

                $result = $bliveUser->setIntroduce($roomid, $content);
                if ($result) {
                    return result(1, '设置成功，<a href="http://live.bilibili.com/' . $roomid . '" target="_blank">点击此处可以查看</a>');
                } else {
                    return result(0, '设置失败，无法设置简介');
                }
            }
        } else {
            return result(0, '请登录后再进行操作');
        }
    }

    public function getRoomId ()
    {
        if (isLogin()) {
            $userid = $GLOBALS['userId'];

            $cookie = model('BilibiliCookie')->getCookie($userid);
            $bliveUser = new \Blive\User($cookie);

            $roomid = $bliveUser->getRoomId();
            if ($roomid == false) {
                return result(0, 'Cookie 失效，无法获取直播间ID');
            } else {
                return result(1, '', [
                    'roomid' => $roomid,
                    'url' => 'http://live.bilibili.com/' . $roomid
                ]);
            }
        } else {
            return result(0, '请登录后再进行操作');
        }
    }

    public function recordRoom ($room)
    {
        if (isLogin()) {
            $userId = $GLOBALS['userId'];
        } else {
            $userId = null;
        }

        try {
            model('BilibiliRoom')->record($room, $userId);
            return result(1, 'ok');
        } catch (\Exception $e) {
            return result(0, 'error');
        }
    }
}

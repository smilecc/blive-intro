<?php
namespace Blive;

use Gaoming13\HttpCurl\HttpCurl;

class User {
    protected $cookie = '';
    protected $defaultHeaders = [
        'Accept:application/json, text/plain, */*',
        'Accept-Language:zh-CN,zh;q=0.9',
        'Cache-Control:no-cache',
        'Connection:keep-alive',
        'Host:api.live.bilibili.com',
        'Origin:http://link.bilibili.com',
        'Pragma:no-cache',
        'Referer:http://link.bilibili.com/p/center/index',
        'User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36',
        'X-FirePHP-Version:0.0.6'
    ];

    public function __construct($cookie)
    {
        $this->setCookie($cookie);
    }

    public function getCookie ()
    {
        return $this->cookie;
    }

    public function setCookie ($cookie)
    {
        $this->cookie = $cookie;
    }

    public function getRoomId ()
    {
        $header = array_merge($this->defaultHeaders, [
            'Cookie:'.$this->cookie
        ]);
        list($body) = HttpCurl::request('http://api.live.bilibili.com/i/api/liveinfo', 'get', [], $header);

        $result = json_decode($body, true);
        trace($result, 'debug');
        
        if ($result == null) {
            return false;
        } else {
            return $result['data']['roomid'];
        }
    }

    public function setIntroduce ($roomid, $desc)
    {
        $header = array_merge($this->defaultHeaders, [
            'Cookie:'.$this->cookie
        ]);

        // 获取 csrf_token
        $csrfToken = '';
        $cookieArr = explode(';', $this->cookie);
        foreach ($cookieArr as $key => $value) {
            if (empty($value)) continue;
            $cookie = explode('=', $value);
            if (count($cookie) != 2) continue;

            if ($cookie[0] == 'bili_jct') {
                $csrfToken = $cookie[1];
                break;
            }
        }
        
        // 提交数据
        list($body) = HttpCurl::request('http://api.live.bilibili.com/room/v1/Room/update', 'post', [
            'room_id' => $roomid,
            'description' => $desc,
            'csrf_token' => $csrfToken
        ], $header);

        // 解析数据
        $result = json_decode($body, true);
        if ($result == null) {
            return false;
        } else {
            return ($result['code'] == 0);
        }
    }

    public function checkUser ()
    {
        $header = array_merge($this->defaultHeaders, [
            'Cookie:'.$this->cookie
        ]);
        
        list($body) = HttpCurl::request('http://api.live.bilibili.com/User/getUserInfo', 'get', [
            'ts' => time() * 1000
        ], $header);
        
        $result = json_decode($body, true);
        if ($result == null) {
            return false;
        } else {
            if (array_key_exists('code', $result) && $result['code'] == 'REPONSE_OK') {
                return true;
            } else {
                return false;
            }
        }
    }
}

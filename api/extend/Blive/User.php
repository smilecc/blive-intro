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
        trace($header, 'debug');
        trace($body, 'debug');
    }

    public function setIntroduce ()
    {

    }
}

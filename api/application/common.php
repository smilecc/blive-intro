<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function logic ($logicName)
{
    return \think\Loader::model($logicName, 'logic');
}

function result ($code, $msg, $options=[])
{
    $result = [
        'code' => intval($code),
        'msg' => $msg,
    ];
    return array_merge($result, $options);
}

function isLogin ()
{
    return array_key_exists('userId', $GLOBALS);
}

function checkResult ($result)
{
    if (array_key_exists('code', $result)) {
        if ($result['code'] == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

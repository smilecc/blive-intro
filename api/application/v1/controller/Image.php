<?php

namespace app\v1\controller;

use think\Controller;
use think\Request;

class Image extends Controller
{
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

        $cosClient = new \Qcloud\Cos\Client([
            'region' => 'ap-shanghai',
            'credentials' => [
                'appId' => config('qcloud.app_id'),
                'secretId' => config('qcloud.secret_id'),
                'secretKey' => config('qcloud.secret_key')
            ]
        ]);
        
        if ($file->validate(['size' => 500000, 'ext' => 'jpg,png,gif'])->check()) {
            $userid = 1;
            $hash = $file->hash();
            $ext =  pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
            $result = $cosClient->putObject(array(
                'Bucket' => 'bintro',
                'Key' => "image/{$userid}_{$hash}.{$ext}",
                'Body' => fopen($file->getInfo('tmp_name'), 'r+')
            ));

            trace($result);
            return result(1, '上传成功', [
                'url' => $result['ObjectURL']
            ]);
        } else {
            return result(0, $file->getError());
        }
    }
}

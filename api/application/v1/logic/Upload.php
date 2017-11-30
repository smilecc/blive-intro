<?php

namespace app\v1\logic;

use think\Model;

class Upload extends Model
{
    public function saveCOS (\think\File $file, $filename)
    {
        if (isLogin()) {

            if (empty($filename)) {
                return result(0, '文件名称不能为空');
            }

            try {
                $cosApi = new \QCloud\Cos\Api([
                    'app_id' => config('qcloud.app_id'),
                    'secret_id' => config('qcloud.secret_id'),
                    'secret_key' => config('qcloud.secret_key'),
                    'region' => 'sh',
                    'timeout' => 60
                ]);
                
                if ($file->validate(['size' => 500000, 'ext' => 'jpg,png,gif'])->check()) {
                    $userid = $GLOBALS['userId'];
                    $hash = $file->hash();
                    $ext =  pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
                    
                    $srcPath = $file->getInfo('tmp_name');
                    $dstPath = "image/{$userid}_{$hash}.{$ext}";

                    $result = $cosApi->upload('bintro', $srcPath, $dstPath);
                    $filesize = $file->getSize();

                    if ($result['code'] == 0) {
                        return model('UserImage')->saveImage($GLOBALS['userId'], $filename, $result['data']['access_url'], $filesize);
                    } else {
                        return result(0, '上传失败');
                    }

                } else {
                    return result(0, $file->getError());
                }

            } catch (\Exception $e) {
                return result(0, '上传失败，系统错误');
            }

        } else {
            return result(0, '请登录后再进行操作');
        }
    }
}

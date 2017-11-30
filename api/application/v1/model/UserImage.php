<?php

namespace app\v1\model;

use think\Model;

class UserImage extends Model
{
    public function saveImage ($userId, $filename, $url, $filesize)
    {
        $imageId = $this->insertGetId([
            'user_id' => $userId,
            'filename' => $filename,
            'url' => $url,
            'filesize' => $filesize
        ]);

        return result(1, '上传成功', [
            'image_id' => $imageId,
            'url' => $url
        ]);
    }
}

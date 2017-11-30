<?php

namespace app\v1\controller;

use think\Controller;
use think\Request;

class Image extends Base
{
    public function upload ()
    {
        $file = request()->file('image');
        $filename = input('filename');

        return logic('Upload')->saveCOS($file, $filename);
    }
}

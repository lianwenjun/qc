<?php

class CClient
{
    //临时文件APK移动到正式文件
    public function renameApkFromTmp($tmpFile) {
        $file = public_path() . $tmpFile;
        $newFile = str_replace('client/tmp', 'client', $file);
        //检测是否存在文件
        if (!file_exists($file)) {
            return $tmpFile;
        }
        if (rename($file, $newFile)) {
             return str_replace('client/tmp', 'client', $tmpFile);
        }
        return $tmpFile;
    }
    //检测输入的数据
    public function isValid($input, $type = 'create') {
        $rules = [
            'create' => [
                'download_link' => 'required',
                'title' => 'required|in:天天游戏中心,游戏中心',
                'md5' => 'required',
                'size_int' => 'required|integer',
                'version' => 'required',
                'version_code' => 'required',
            ],
            'update' => [
                'download_link' => 'required',
                'title' => 'required|in:天天游戏中心,游戏中心',
                'md5' => 'required',
                'size_int' => 'required|integer',
                'version' => 'required',
                'version_code' => 'required',
            ],
        ];
        //返回消息没了
        return Validator::make(
            $input,
            $rules[$type]
        );
    }
    //新建的数据
    public function create() {
        $fields = [
            'download_link',
            'title',
            'md5',
            'size_int',
            'changes',
            'version',
            'version_code',
            'release',
        ];
        $data = [];
        foreach ($fields as $key) {
            $data[$key] = Input::get($key, '');
        }
        if ($data['title'] == '天天游戏中心') {
            $data['release'] = 1;
        }
        //文件复制
        $data['download_link'] = $this->renameApkFromTmp($data['download_link']);
        $app = Client::create($data);
        return $app;
    }
    //修改的数据
    public function update($app) {
        $fields = [
            'download_link',
            'title',
            'md5',
            'size_int',
            'changes',
            'version',
            'version_code',
        ];
        foreach ($fields as $key) {
            $app->$key = Input::get($key, $app->$key);
        }
        //
        $app->download_link = $this->renameApkFromTmp($app->download_link);;
        $app->save();
        return $app;
    }
}
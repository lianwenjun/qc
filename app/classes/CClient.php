<?php

class CClient
{
    //临时文件APK移动到正式文件
    public function renameApkFromTmp($tmpFile, $newLink = null) {
        $file = public_path() . $tmpFile;
        if (!$newLink){
            $newFile = str_replace('client/tmp', 'client', $file);
        } else {
            $newFile = public_path() . $newLink;
        }
        //检测是否存在文件
        if (!file_exists($file)) {
            return $tmpFile;
        }
        if (rename($file, $newFile)) {
            return $newLink ? $newLink : str_replace('client/tmp', 'client', $tmpFile);
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
        $new_link = '';
        if ($data['title'] == '天天游戏中心') {
            $data['release'] = 1;
            $new_link = '/client/GameCenter.apk';
        }
        //文件复制
        $data['download_link'] = $this->renameApkFromTmp($data['download_link'], $new_link);
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
        $new_link = '';
        if ($app->title == '天天游戏中心') {
            $new_link = '/client/GameCenter.apk';
        }

        $app->download_link = $this->renameApkFromTmp($app->download_link, $new_link);
        $app->save();
        return $app;
    }
}
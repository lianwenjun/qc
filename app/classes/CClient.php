<?php

class CClient
{
    /**
     * 临时文件APK移动到正式文件
     * 
     * @param $tmpFile string 临时APK的路径
     * @param $newLink string 正式的APK的路径
     *
     * @return string
     */
    public function renameApkFromTmp($tmpFile, $newLink = null) {
        $file = public_path() . $tmpFile;
        if (!$newLink){
            $newFile = str_replace('client/tmp', 'client', $file);
        } else {
            $newFile = public_path() . $newLink;
        }
        // 检测是否存在文件
        if (!file_exists($file)) {
            return $tmpFile;
        }
        if (rename($file, $newFile)) {
            return $newLink ? $newLink : str_replace('client/tmp', 'client', $tmpFile);
        }
        
        return $tmpFile;
    }

    /**
     * 检测输入的数据
     * 
     * @param $input array 输入数据
     * @param $type string 选择过滤类型
     *
     * @return Validator
     */
    public function isValid($input, $type = 'create') {
        $rules = [
            'create' => [
                'download_link' => 'required',
                'title' => 'required',
                'md5' => 'required',
                'size_int' => 'required|integer',
                'version' => 'required',
                'version_code' => 'required',
                'release' => 'required'
            ],
            'update' => [
                'download_link' => 'required',
                'title' => 'required',
                'md5' => 'required',
                'size_int' => 'required|integer',
                'version' => 'required',
                'version_code' => 'required',
                'release' => 'required'
            ],
        ];
        
        return Validator::make(
            $input,
            $rules[$type]
        );
    }

    /**
     * 新增client
     * 
     * @param 
     *
     * @return obj
     */
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
        if ($data['release'] == '1') {
            $new_link = '/client/GameCenter.apk';
        }
        if ($data['release'] == '')
            $data['release'] = 0;
        //文件复制
        $data['download_link'] = $this->renameApkFromTmp($data['download_link'], $new_link);
        $app = Client::create($data);
        return $app;
    }

    /**
     * 更新client
     * 
     * @param 
     *
     * @return obj
     */
    public function update($app) {
        $fields = [
            'download_link',
            'title',
            'md5',
            'size_int',
            'changes',
            'version',
            'version_code',
            'release'
        ];
        foreach ($fields as $key) {
            $app->$key = Input::get($key, $app->$key);
        }
        $new_link = '';
        if ($app->release == '1') {
            $new_link = '/client/GameCenter.apk';
        }

        if ($app->release == '')
            $app->release = 0;

        $app->download_link = $this->renameApkFromTmp($app->download_link, $new_link);
        $app->save();
        return $app;
    }
}
<?php

class Admin_AdsController extends \Admin_BaseController {

    protected $type = '';
    protected $location = '';
    protected $indexRoute = '';
    /**
     * 下架游戏位广告
     * DELETE /admin/appads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function unstock($id)
    {
        $ad = Ads::whereType($this->type)->isStock()->find($id);
        if (!$ad) {
            return Redirect::route($this->indexRoute)->with('msg', '亲，#'.$id.'不存在');
        }
        $ad->is_stock = 'no';
        if ($ad->save()){

            // 记录操作日志
            $status = [
                'app' => [
                    'yes' => '广告位管理-首页游戏位管理',
                    'no' => '广告位管理-排行游戏位管理',
                ],
                'banner' => [
                    'yes' => '广告位管理-首页图片位管理',
                    'no' => '广告位管理-编辑精选管理',
                ],
            ];
            $ads = Ads::find($id);
            $type = $ads->type;
            $is_top = $ads->is_top;
            $logData['action_field'] = $status[$type][$is_top];
            $logData['description'] = '下架了广告 广告ID为' . $id;
            Base::dolog($logData);
            
            return Redirect::route($this->indexRoute)->with('msg', '亲，#'.$id.'下架成功');
        }
        return Redirect::route($this->indexRoute)->with('msg', '亲，#'.$id.'下架失败了');
    }

    /**
     * 删除游戏位广告
     * DELETE /admin/appads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //单条查询
        $ad = Ads::whereType($this->type)->find($id);
        $msg = '#' . $id . '删除失败';
        if (!$ad) {
            return Redirect::route($this->indexRoute)->with('msg', '#' . $id . '不存在');
        }
        $type = $ad->type;
        $is_top = $ad->is_top;
        if ($ad->delete()){
            $msg = '#' . $id . '删除成功';

            // 记录操作日志
            $status = [
                'app' => [
                    'yes' => '广告位管理-首页游戏位管理',
                    'no' => '广告位管理-排行游戏位管理',
                ],
                'banner' => [
                    'yes' => '广告位管理-首页图片位管理',
                    'no' => '广告位管理-编辑精选管理',
                ],
            ];
            $logData['action_field'] = $status[$type][$is_top];
            $logData['description'] = '删除了广告 广告ID为' . $id;
            Base::dolog($logData);
            
        }
        return Redirect::route($this->indexRoute)->with('msg', $msg);
    }
    
    /**
    * 上传图片
    * 返回图片字段 result : {data, path, fullPath}
    */
    public function upload(){
        return (new CUpload)->instance('image', 'ads')->upload();
    }

}
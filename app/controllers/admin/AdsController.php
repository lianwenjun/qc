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
        if ($ad->delete()){
            $msg = '#' . $id . '删除成功';
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
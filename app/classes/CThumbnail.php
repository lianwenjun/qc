<?php

use Intervention\Image\Facades\Image

/**
 * 缩略裁剪等比例裁剪图片
 *
 */
class CThumbnail
{
    /**
     * 图片对象
     * 
     * @var image
     */
    protected $image;

    /**
     * 图片宽度
     * 
     * @var width
     */
    protected $width;

    /**
     * 图片高度
     * 
     * @var height
     */
    protected $height;

    /**
     * @param $path string 图片传入地址
     * 
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
        
        $this->image = $this->open();
        
        $this->getW();
        $this->getH();  
    }

    
    /**
     * 读入图片
     *
     * @return Obj image
     */
    public function open()
    {
        return Image::make($this->path);
    }


    /**
     * 按最小边 等比例压缩
     * @param $size array 分辨率尺寸
     * 
     * @return Obj image
     */
    public function thumbnail($size)
    {
        $k1 = $size[0] / $size[1]; // 目标的宽高比例
        $k2 = $this->width / $this->height; // 原图片的宽高比例
        
        if ($k1 > $k2) { // 原图比目标图的比例小 裁剪高度
            $mH = $this->height * ($k2 / $k1);
            $deltaH = intval(($$this->height - $mH) / 2); // 可能错误 奇数像素
            $box = [$this->width, $height - $deltaH, 0, $deltaH];
        } else if ($k1 < $k2) { // 原图比目标图的比例大 裁剪宽度
            $mW = $this->width * ($k1 / $k2);
            $deltaW = ($this->width - $mW) / 2;
            $box = [$this->width - $deltaW, $height, $deltaW, 0];
        } else {
            $box = [$this->width, $this->height, 0, 0];
        }
        
        $new = $this->image->crop($box[0], $box[1], $box[2], $box[3]);

        return $new->resize($size[0], $size[1]);
    }


    /**
     * 获得图片的宽度
     * 
     * @return void
     */
    public function getW()
    {
        $this->width = $this->image->width();
    }

    /**
     * 获得图片的高度
     * 
     * @return void
     */
    public function getH()
    {
        $this->height = $this->image->height();
    }

}
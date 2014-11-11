<?php

/**
 * 平台游戏数据抓取基础类
 *
 * @author RavenLee
 */
abstract class CGame_Base
{
    /**
     * 生成请求参数数据
     *
     */
    abstract protected function createPost();

    /**
     * 执行请求
     *
     */
    abstract protected function request();

    /**
     * 全量获取游戏数据
     *
     */
    abstract public function all();

    /**
     * 增量获取游戏数据
     *
     */
    abstract public function append();

    /**
     * 转换游戏数据格式以适应数据库存储
     *
     * @param $info 从平台获取的原始游戏数据
     */
    abstract protected function transform($info);

    /**
     * 数据入库
     *
     * @param $format 调整格式后的游戏数据
     */
    abstract protected function store($format);
}
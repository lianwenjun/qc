<?php

class PackagesTest extends TestCase
{

    // 测试豌豆荚数据
    public function testWdjRefresh()
    {
        $this->assertTrue(Packages::refresh('com.halfbrick.fruitninjafree', 'wdj'));
    }

    // 测试豌豆荚数据(这个包是不存在的)
    public function testWdjRefresh2()
    {
        $this->assertFalse(Packages::refresh('com.halfbrick.fruitninjafree123', 'wdj'));
    }

    // 测试应用宝数据
    public function testYybRefresh()
    {
        $this->assertTrue(Packages::refresh('com.halfbrick.fruitninjafree', 'yyb'));
    }

    // 测试应用宝数据(这个包是不存在的)
    public function testYybRefresh2()
    {
        $this->assertFalse(Packages::refresh('com.halfbrick.fruitninjafree111', 'yyb'));
    }

    // 测试整个列表
    public function testRefreshFromApps()
    {
        $this->assertTrue(Packages::refreshListFromApps());
    }

}
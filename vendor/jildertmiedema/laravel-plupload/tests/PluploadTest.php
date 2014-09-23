<?php

use Mockery as m;

use JildertMiedema\LaravelPlupload\Plupload;

class PluploadTest extends PHPUnit_Framework_TestCase {
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetDefaultView()
    {
        $config = m::mock('Illuminate\Config\Repository');

        $config ->shouldReceive('get')->with('laravel-plupload::plupload.view')->once()->andReturn('default-view');

        $plupload = new Plupload($config);

        $this->assertEquals('default-view', $plupload->getDefaultView());
    }

}
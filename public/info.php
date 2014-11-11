<?php

print_r(pathinfo('ddd.apk'));

$str = "application: label='心情调节器' icon='res/drawable-hdpi/logo.png'";
preg_match('/^application: label=\'.+\' icon=\'(.+)\'$/', $str, $matches);
print_r($matches);

echo json_encode($matches, JSON_UNESCAPED_UNICODE);

$str = "application-label:'Network debug assistant'";
preg_match('/^application-label:\'(.+)\'$/', $str, $matches);
print_r($matches);


$str = "package: name='com.fontlose.tcpudp' versionCode='6' versionName='1.50'";
preg_match('/^package: name=\'(.+)\' versionCode=\'(\d+)\' versionName=\'(.+)\'$/', $str, $matches);
print_r($matches);


$data = [
        ['id' => 1, 'title' => 'xxx'],
        ['id' => 2, 'titile' => 'ffff']
    ];

$t = ['id' => 2, 'title' => 'xxx'];

var_dump(in_array($t, $data));


$key = 'dfsdfsd_at';
var_dump(substr($key, -3) == '_at');

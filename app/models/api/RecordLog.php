<?php

class Api_RecordLog extends \Eloquent {
    protected $fillable = ['app_id', 'uuid', 'type', 'imei', 'os_version', 'ip', 'status'];
    protected $table = 'record_logs';
}
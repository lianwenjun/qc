<?php

class Api_AppDownloadLogs extends \Eloquent {
    protected $fillable = ['app_id', 'account_id', 'ip', 'status'];
    protected $connection = 'logs';
    public function __construct($table = '')
    {
        parent::__construct();
        $this->setTable($table);
    }
}
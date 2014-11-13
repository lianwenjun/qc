<?php

class Api_AppDownloadLogs extends \Eloquent {
    protected $fillable = ['app_id', 'account_id', 'ip', 'status'];
    protected $connection = 'logs';
    protected $logTable;
    public function __construct($table = '')
    {
        parent::__construct();
        //查找最近小于500W条的表
        $limit = Config::get('logsLimit.download', 5000000);
        $this->logTable = Api_LogTables::ofCount($limit)->first();
        $this->setTable($this->logTable->name);
    }
    //记录加1
    public function addCount() {
        if (is_null($this->logTable->used_at)) {
            $this->UpdateUsedAt();
        }
        return Api_LogTables::whereId($this->logTable->id)
                ->addCount();
    }
    public function UpdateUsedAt() {
        return Api_LogTables::whereId($this->logTable->id)
                ->update(['used_at' => date('Y-m-d H:i:s', time())]);
    }
}
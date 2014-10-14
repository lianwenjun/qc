<?php

class Admin_BaseController extends \Controller {
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'admin.layout';
    protected $userId = 0;
    protected $pagesize = 20;
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }
    /**
    * 设置用户ID
    */
    public function __construct()
    {
        if (Sentry::check()) {
            $this->userId = Sentry::getUser()->id;
        }
    }
}
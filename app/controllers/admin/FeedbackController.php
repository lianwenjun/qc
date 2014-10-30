<?php

class Admin_FeedbackController extends \Admin_BaseController {

    /**
     * 应用反馈首页
     * GET /admin/feedback
     *
     * @return Response
     */
    public function index()
    {
        $model = new Feedbacks();
        $lists = $model->lists(Input::all());
        return View::make('admin.feedback.index')->with('lists', $lists);
    }

}
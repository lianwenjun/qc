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
        $feedbacks = new Feedbacks();
        $lists = $feedbacks->lists(Input::all())
                                        ->orderBy('created_at', 'desc')
                                        ->paginate($this->pagesize);
                                        
        return View::make('admin.feedback.index')->with('lists', $lists);
    }

}
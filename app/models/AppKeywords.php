<?php

class AppKeywords extends \Eloquent {

    protected $table      = 'app_keywords';
    protected $dates      = ['deleted_at'];
    protected $guarded    = ['id'];

}
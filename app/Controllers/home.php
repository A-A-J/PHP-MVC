<?php

class home extends controller{
    public function __construct(){
        $this->userModel = $this->modal('users');
    }

    public function index(){
        return $this->view('home/index');
    }

    public function about(){;
        return $this->view('home/about');
    }
}
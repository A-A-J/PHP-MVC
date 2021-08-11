<?php

class members extends controller{
    public function __construct(){
        $this->userModel = $this->modal('users');
        $this->userModels = $this->userModel->getUsers();
    }

    public function index(){
        // $data = $this->userModels;
        $data = json_decode(json_encode($this->userModels), true);
        return $this->view('members/index', $data, ' | List Members');
    }
}
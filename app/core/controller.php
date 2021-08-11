<?php 
class controller extends api{
    public function modal($modal){
        //Require model file
        require_once '../app/models/' . $modal . '.php';
        //Instantiate modal
        return new $modal();
    }

    //Load the view (checks for the file)
    public function view($view, $data=[], $title=null){

        if(file_exists('../app/views/' . $view . '.html')){
            
            $tpl = $this->template();

            $tpl->assign("title", $title );

            $tpl->assign("languages", new Phrases());

            $tpl->assign("Lang", (new Phrases())->phrases );

            $tpl->assign("print", $data );

            $tpl->assign("view", $view );

            $tpl->draw('index');
        }else{
            die("view does not exists");
            exit;
        }
    }
}
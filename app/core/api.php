<?php
use Rain\Tpl;
class api{
    
    protected $controller   = 'home';
    protected $method       = 'index';
    protected $params       = [];
    
    public function __construct(){

        // status displaynone page php in file templates
        define('displaynone', TRUE);

        //start session
        ob_start();
        session_start();
        session_regenerate_id();
        $url = $this->getUrl();

        //lool in 'controllers' fot first value, ucwords will capitalize first letter
        if(!empty($url[0]) && file_exists('../app/Controllers/'. ucwords($url[0]). '.php')){
            // will set a new controller
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }
        
        //require the controller
        require_once '../app/Controllers/'. $this->controller .'.php';
        $this->controller = new $this->controller;

        // Check for second part of url
        if(isset($url[1])){
            // Check to see if method exists in controller
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
            //Checking for a sheet followed by "$url[0]" inside the folder "app/controllers"
            if(!file_exists('../app/Controllers/'.$url[0].'.php')){
                die('The page you are looking for is not in our records!');
                exit;
            }
            
            getInject($_GET['url']);

            return $url;
        }
    }

    public function template(){
        $tpl = new Tpl;
        
        // configure
        $config = array(
            "base_url"      => null,
            "tpl_dir"       => "../app/views/",
            "cache_dir"     => "../cache/",
            "debug"         => true // set to false to improve the speed
        );

        $tpl::configure( $config );

        $this->template = $tpl;
        return $this->template;
    }

    public function __call($method, $params){
        die ('not Method ['.$method.']');
        exit;
    }

}
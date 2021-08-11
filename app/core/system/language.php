<?php

class Phrases{
    public $lang = DEFULT_LANGUAGE;

    public function __construct() {
        if(!empty($_COOKIE['system_Language'])){
            $this->lang = $_COOKIE['system_Language'];
        }
        $this->load_phrases();
        $this->ChangeLanguage();
    }

    public function load_phrases() {
        $xml = new DomDocument('1.0');
        $lang_path=(dirname(dirname(dirname(__FILE__)))."\languages\\".$this->lang.".xml");
        $xml->load($lang_path);
        $page = $xml->getElementsByTagName('phrasegroup');
        for($i = 0; $i < 1; $i++) {
            $page = $xml->getElementsByTagName('phrasegroup')->item($i);
            foreach($page->getElementsByTagName('phrase') as $phrase) {
                $phrase_name = $phrase->getAttribute('name');
                $phrases[$phrase_name] = $phrase->firstChild->nodeValue;
                $phrases[$phrase_name] = str_replace('\n','<br/>',$phrases[$phrase_name]);
            }
        }
        $this->phrases = $phrases;
    }

    public function html($attributes){
        $xml = simplexml_load_file(dirname(dirname(dirname(__FILE__)))."\languages\\".$this->lang.".xml");
        return $xml->attributes()->$attributes;
    }

    public function ChangeLanguage(){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['Lang']) {
            if(!in_array($_POST['Lang'], $this->list())){
                header('Location:'.APP_URL);
                exit;
            }else{
                setcookie("system_Language" , $_POST['Lang'] , time() + 60*60*24*7, "/");
                echo 'Language changed successfully '.$_POST['Lang'].' <br>';
                header('Location:'.APP_URL);
                exit;
            }
        }
    }

    public function list(){
        $file_language  = scandir("../app/languages");
        $cl =  str_replace(".xml", "", $file_language);
        return str_replace(".", '', $cl);
    }
}
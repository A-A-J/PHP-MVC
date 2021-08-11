<?php
namespace Error;
use Whoops\Run;
class Msg {
    public static function errors(){
        $whoops = new Run;
        $whoops->pushHandler(new \Whoops\Handler\PlainTextHandler);
        $whoops->register();
    }
}
Msg::errors();
<?php
class App{
    const VERSION_CODE = "2";

    public static function getVersion(){
        return "Versión ".self::VERSION_CODE;
    }
}

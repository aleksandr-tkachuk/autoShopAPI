<?php

if(!function_exists("LibLoader")){
    function LibLoader($class){
        $class = strtolower($class);
        $filePath = __DIR__."/".$class.".php";
        if(is_file($filePath) && !class_exists($filePath)){
            include $filePath;
        }
    }
}
if(!function_exists("LibControllers")){
    function LibControllers($class){
        $class = ucfirst($class);
        $filePath = __DIR__."/../controllers/".$class.".php";
        if(is_file($filePath) && !class_exists($filePath)){
            include $filePath;
        }
    }
}
if(!function_exists("LibModels")){
    function LibModels($class){
        $class = ucfirst($class);
        $filePath = __DIR__."/../models/".$class.".php";
        if(is_file($filePath) && !class_exists($filePath)){
            include $filePath;
        }
    }
}

spl_autoload_register("LibLoader");
spl_autoload_register("LibControllers");
spl_autoload_register("LibModels");
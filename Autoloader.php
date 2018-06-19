<?php
    
    spl_autoload_register(function ($classNameWithNamespace)
    {
        $pathToFile = __DIR__.'/Classes/'.str_replace('\\', DIRECTORY_SEPARATOR, $classNameWithNamespace).'.php';
        if (file_exists($pathToFile)) {
            require_once "$pathToFile";
        }
    }
    );
    
    
    /**
     * Created by PhpStorm.
     * User: konstantin
     * Date: 16.06.2018
     * Time: 12:34
     */
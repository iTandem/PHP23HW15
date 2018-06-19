<?php
    
    use \Controller\Index;
    
    class ControllerFactory
    {
        private $pdo;
        
        public function __construct(\PDO $pdo)
        {
            $this->pdo = $pdo;
        }
        
        public function createController($file)
        {
            $viewName = pathinfo($file)['filename'];
            
            $controllerName = "\Controller\\" . ucfirst($viewName) . 'Controller';
            
            return new $controllerName($this->pdo);
        }
    }
    
    /**
     * Created by PhpStorm.
     * User: konstantin
     * Date: 16.06.2018
     * Time: 12:39
     */
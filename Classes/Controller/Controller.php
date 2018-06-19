<?php
    
    namespace Controller;
    
    use Db;
    
    class Controller
    {
        protected $allowedActions = ['alter', 'drop'];
        protected $db;
        
        public function __construct(\PDO $pdo)
        {
            $this->db = new Db($pdo);
        }
        
        public function getDb()
        {
            return $this->db;
        }
    }
    
    
    
    
    
    
    
    /**
     * Created by PhpStorm.
     * User: konstantin
     * Date: 16.06.2018
     * Time: 12:47
     */
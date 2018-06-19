<?php
    
    namespace Controller;
    
    use \Controller\Controller;
    
    class IndexController extends Controller
    {
        
        public function __construct($pdo)
        {
            parent::__construct($pdo);
            
            $droppedTable = $_POST['drop'] ?? '';
            $renamedTable = $_POST['rename'] ?? '';
            $newName = $_POST['new_name'] ?? '';
            
            if ($droppedTable) {
                $this->db->dropTable($droppedTable);
            }
            if ($renamedTable && $newName) {
                $this->db->renameTable($renamedTable, $newName);
            }
        }
    }
    
    
    /**
     * Created by PhpStorm.
     * User: konstantin
     * Date: 16.06.2018
     * Time: 13:40
     */
<?php
    
    class Db
    {
        private $allowedTypes = [
            'Numeric' => ['TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'BIGINT', 'DECIMAL', 'DEC', 'NUMERIC', 'FIXED', 'FLOAT', 'DOUBLE'],
            'String' => ['CHAR', 'VARCHAR', 'TINYTEXT', 'TEXT', 'MEDIUMTEXT', 'LONGTEXT', 'BINARY', 'VARBINARY'],
            'Date/Time' => ['DATE', 'DATETIME', 'TIMESTAMP', 'TIME', 'YEAR'],
            'Large Object' => ['TINYBLOB', 'BLOB', 'MEDIUMBLOB']
        ];
        private $charset = 'utf8';
        private $engine = 'InnoDB';
        private $pdo;
        
        private function checkAllowedTypes($type)
        {
            $types = call_user_func_array('array_merge', $this->allowedTypes);
            
            if (!in_array($type, $types))
                return;
        }
        
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }
        
        public function getAllowedTypes()
        {
            return $this->allowedTypes;
        }
        
        public function showTables()
        {
            $query = "SHOW TABLES;";
            
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute();
            
            return $prepquery->fetchAll();
        }
        
        public function describe($table)
        {
            // $table = $this->pdo->quote($table);
            $query = "DESCRIBE `$table`";
            
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute();
            
            return $prepquery->fetchAll();
        }
        
        
        public function createTable($table, $columns)
        {
            $query = "CREATE TABLE `$table` (";
            $key = 0;
            
            foreach ($columns as $index => $column) {
                
                $query .= $column['name'] . ' ' .
                    $column['type'] .
                    ($column['value'] ? '(' . $column['value'] . ') ' : ' ') .
                    ($column['nullable'] ? ' ' : 'NOT NULL');
                if (!$key && $column['key']) {
                    $key = $column['name'];
                    $query .= ' AUTO_INCREMENT';
                }
                if ($index < count($columns) - 1)
                    $query .= ', ';
            }
            
            if ($key) {
                $query .= ", PRIMARY KEY(`$key`)";
            }
            
            $query .= ') ENGINE=' . $this->engine . ' DEFAULT CHARSET=' . $this->charset . ';';
            
            $prepquery = $this->pdo->prepare($query);
            try {
                $prepquery->execute();
            } catch (PDOException $e) {
            }
        }
        
        public function dropTable($table)
        {
            $query = "DROP TABLE IF EXISTS `$table`;";
            
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute();
        }
        
        public function renameTable($table, $newName)
        {
            $query = "ALTER TABLE `$table` RENAME `$newName`;";
            
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute();
        }
        
        public function addColumn($table, $column, $type, $value, $nullable)
        {
            $this->checkAllowedTypes($type);
            
            $null = $nullable ? 'NULL' : 'NOT NULL';
            if ($value) {
                $type .= "($value)";
            }
            
            $query = "ALTER TABLE `$table`
            ADD `$column` $type $null
        ;";
            
            $prepquery = $this->pdo->prepare($query);
            
            try {
                $prepquery->execute();
            } catch (PDOException $e) {
            }
        }
        
        public function dropColumn($table, $column)
        {
            $query = "ALTER TABLE `$table` DROP COLUMN `$column`;";
            
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute();
        }
        
        public function renameColumn($table, $column, $newName)
        {
            foreach ($this->describe($table) as $col) {
                if ($col['Field'] == $column) {
                    $type = $col['Type'];
                    break;
                }
            }
            
            $query = "ALTER TABLE `$table`
            CHANGE `$column` `$newName` $type
        ;";
            
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute();
        }
        
        public function changeColumnType($table, $column, $newType, $value, $nullable)
        {
            $this->checkAllowedTypes($newType);
            
            $null = $nullable ? 'NULL' : 'NOT NULL';
            if ($value) {
                $newType .= "($value)";
            }
            
            $query = "ALTER TABLE $table
            MODIFY $column $newType $null
        ;";
            
            $prepquery = $this->pdo->prepare($query);
            
            try {
                $prepquery->execute();
            } catch (PDOException $e) {
            }
        }
        
    }
    /**
     * Created by PhpStorm.
     * User: konstantin
     * Date: 16.06.2018
     * Time: 12:38
     */
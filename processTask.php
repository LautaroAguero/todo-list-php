<?php
    require_once 'Task.php';
    class ProcessTask extends Task {
        private $subtasks;
    
        public function __construct($name, $subtasks) {
            parent::__construct($name, 'process');
            $this->subtasks = $subtasks;
        }
    
        public function getSubtasks() {
            return $this->subtasks;
        }
    }    
?>
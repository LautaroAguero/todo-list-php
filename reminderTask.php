<?php 
    require_once 'Task.php';
    class ReminderTask extends Task {
        private $reminderDescription;
        private $reminderDateTime;
    
        public function __construct($name, $reminderDescription, $reminderDateTime) {
            parent::__construct($name, 'reminder');
            $this->reminderDescription = $reminderDescription;
            $this->reminderDateTime = $reminderDateTime;
        }    
        
        public function getReminderDescription() {
            return $this->reminderDescription;
        }
    
        public function getReminderDateTime() {
            return $this->reminderDateTime;
        }
    }
?>
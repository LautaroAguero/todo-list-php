<?php
    require_once 'Task.php';
    class ContactTask extends Task {
        private $contactName;
        private $contactReason;
        private $contactPhone;
        private $contactEmail;

        public function __construct($name, $contactName, $contactReason, $contactPhone, $contactEmail) {
            parent::__construct($name, 'contact');
            $this->contactName = $contactName;
            $this->contactReason = $contactReason;
            $this->contactPhone = $contactPhone;
            $this->contactEmail = $contactEmail;
        }

        public function getContactName() {
            return $this->contactName;
        }
        
        public function getContactReason() {
            return $this->contactReason;
        }

        public function getContactPhone() {
            return $this->contactPhone;
        }

        public function getContactEmail() {
            return $this->contactEmail;
        }
        
    }
?>
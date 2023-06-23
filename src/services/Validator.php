<?php
   
    class Validator{
        private $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
        private $passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
        private $nameRegex = "/^[A-Za-zÀ-ÖØ-öø-ÿ '0-9-]{2,}$/";

        public function validateEmail($email) {
            if (preg_match($this->emailRegex, $email)) {
                return true;
            } else {
                return false;
            }
        }
        public function validateName($name) {
            if (preg_match($this->nameRegex, $name)) {
                return true;
            } else {
                return false;
            }
        }
        public function validatePassword($password) {
            if (preg_match($this->passwordRegex, $password)) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
<?php
   
    class Validator{
        private $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
        private $passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
        private $nameRegex = "/^[A-Za-zÀ-ÖØ-öø-ÿ '0-9-]{2,}$/";
        private $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

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

        public function validateImage($file) {
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $this->imageExtensions)) {
                return false; // File extension is not allowed
            }
    
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileMimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
    
            if (strpos($fileMimeType, 'image') !== 0) {
                return false; // File is not an image
            }
    
            return true;
        }

    }
?>
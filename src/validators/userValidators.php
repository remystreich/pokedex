<?php


class userValidator  {

    private $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    private $passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
    private $nameRegex = "/^[A-Za-zÀ-ÖØ-öø-ÿ '0-9-]{2,}$/";
    private $errors = array();
    private $user;
  

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    public function validateEmail() {

       

        if (preg_match($this->emailRegex, $this->user->getEmail())) {
            return true;
        } else {
            $this->errors['email'] = "Email invalide";
        }
    }
    public function validateName() {
        if (preg_match($this->nameRegex, $this->user->getName() )) {
            return true;
        } else {
            $this->errors['name'] = "Nom invalide";
        }
    }
    public function validatePassword() {
        if ($this->user->getPassword()) {
            if (preg_match($this->passwordRegex, $this->user->getPassword())) {
                return true;
            } else {
                $this->errors['password2'] = "Mot de passe invalide";
            }
        }

    }

    public function validateUser() {
        $this->validateEmail();
        $this->validateName();
        $this->validatePassword();
        return $this->errors;
    }
} 
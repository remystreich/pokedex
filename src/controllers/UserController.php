<?php
require_once './src/services/Validator.php';


class UserController { 
    private $userRepository;
    public $errors=array();

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function register($data){
        $validator = new Validator();
        if ($data['password']!== $data['confirmPassword']) {
            $errors['password1'] = "Les mots de passe doivent être identiques";
        }
        if ($validator->validateEmail($data['email'])==false) {
            $errors['email'] = "Email invalide";
        }
        if ($validator->validateName($data['name'])==false) {
            $errors['name'] = "Nom invalide";
        }
        if ($validator->validatePassword($data['password'])==false) {
            $errors['password2'] = "Mot de passe invalide";
        }
        if ($this->userRepository->emailVeryfy($data['email'])){
            $errors['email2'] = "Cette adresse mail existe déjà";
        }
        if ($errors){
            include_once './views/register.php';
        }else{
            $user = new UserModel($data['name'],$data['password'],$data['email']);
            $user = $this->userRepository->save($user);
            header("Location: ".Config::$absolutepath."/login");
        }
    }

    public function login($data){
        try {
            $user = $this->userRepository->login($data);
            $_SESSION['userId']= $user;
            header("Location: ".Config::$absolutepath."/dashboard");
        } catch (Exception $e) {
            include_once './views/login.php';
        }
    }


    public function authGuard(){
       
            if ($this->userRepository->getUser($_SESSION['userId'])) {
                return true;
            }else {
                
                header("Location: ".Config::$absolutepath."/login");
                exit(); 
            }
        
    }

    public function updateUser(){
        
    }
}
?>
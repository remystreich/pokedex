<?php



class UserController { 
    private $userRepository;
    public $errors=array();

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function register($data){
        $user = new UserModel($data['name'],$data['password'],$data['email']);
        $validator = new userValidator($user);
        $errors=  $validator->validateUser();
        
        if ($data['password']!== $data['confirmPassword']) {
            $errors['password1'] = "Les mots de passe doivent être identiques";
        }
        
        if ($this->userRepository->emailVeryfy($data['email'])){
            $errors['email2'] = "Cette adresse mail existe déjà";
        }

        if ($errors){
            include_once './views/register.php';

        }else{
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
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

    public function updateUser($data){
        //créer objet upload à partir d'une instance de PokeModel
        $update = new UserModel($data['name'], $_SESSION['password'], $data['email']);
        $validator = new userValidator($update);
        $errors=  $validator->validateUser();
        
        $user= $this->userRepository->getUser($_SESSION['userId']);
        

        if (isset($data['password']) && $data['password']!== $data['confirmPassword']) {
            $errors['password1'] = "Les mots de passe doivent être identiques";
        }
        
        if ($data['email']!==$user['email'] && $this->userRepository->emailVeryfy($data['email'])){
            $errors['email2'] = "Cette adresse mail existe déjà";
        }

        if ($errors){
            $version = 'user';
            include_once './views/update.php';

        }else{
            //si pas d'erreurs de formulaire
            
            // Enregistrer le Pokémon dans la base de données
            $update = $this->userRepository->update($update);
            
            header("Location:  ".Config::$absolutepath."/dashboard");
        }
    }
}
?>
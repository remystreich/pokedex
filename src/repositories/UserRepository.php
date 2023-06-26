<?php
include_once('./database.php');
class UserRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function emailVeryfy($email)
    {
        $sthCheckEmail = $this->db->getConnection()->prepare("SELECT COUNT(*) AS count FROM user WHERE email = :email");
        $sthCheckEmail->bindParam(':email', $email);
        $sthCheckEmail->execute();
        $result = $sthCheckEmail->fetch(PDO::FETCH_ASSOC);
        if ($result['count'] > 0) {
            return true;
        }
    }

    public function save(UserModel $user)
    {
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();    
        $query = "INSERT INTO user (name, email, password) VALUE (:name, :email, :password)";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(":name", $name);
        $state->bindParam(":email", $email);
        $state->bindParam(":password", $password);
        $state->execute();
        $userData = $state->fetch(PDO::FETCH_ASSOC);
        return $userData;
    }

    public function login($data){
        $email= $data['email'];
        $password = $data['password'];
        $sql = "SELECT * FROM User WHERE email = :email";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])){  //vérifier si compare array n'est pas vide, il se remplit si il y a une correspondance avce le form
           return $user['id'];
        }
        else {
            throw new Exception("Erreur d'authentification");
        }
    }

   

    public function getUser($id)
    {
        $query = "SELECT * FROM user  WHERE  id = :id ";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(":id", $id);
        $state->execute();
        $user = $state->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}

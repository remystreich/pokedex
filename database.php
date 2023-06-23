<?php
require_once './config.php';
class Database{

    private $conn;

    public function __construct() {
        $host = Config::$host;
        $dbname = Config::$database;
        $username = Config::$username;
        $password = Config::$password;

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Échec de la connexion à la base de données : " . $e->getMessage());
        }
    }
    public function getConnection() {
        return $this->conn;
    }
    public function executeQuery($query) {
        return $this->conn->query($query);
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
?>

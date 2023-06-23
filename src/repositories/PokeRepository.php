<?php
include_once('./database.php');
class PokeRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function save(PokeModel $pokemon) {
        $name = $pokemon->getName();
        $type = $pokemon->getType();
        $userId = $pokemon->getUserId();
        $image = $pokemon->getImage();
        
        $query = "INSERT INTO pokemon (name, type, user_id, image) VALUE (:name, :type, :user_id, :image)";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(":name", $name);
        $state->bindParam(":type", $type);
        $state->bindParam(":user_id", $userId);
        $state->bindParam(":image", $image);
        $state->execute();
        $pokemonData = $state->fetch(PDO::FETCH_ASSOC);
        return $pokemonData;
    }
}

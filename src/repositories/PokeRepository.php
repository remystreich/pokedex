<?php
include_once('./database.php');
class PokeRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function save(PokeModel $pokemon)
    {
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

    public function getPokemons()
    {
        $query = "SELECT * FROM pokemon p WHERE  p.user_id = :userId";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(":userId", $_SESSION["userId"]);
        $state->execute();
        $pokemonData = $state->fetchAll(PDO::FETCH_ASSOC);
        return $pokemonData;
    }


    private function getPhotoPath($id){
        $query = "SELECT image FROM pokemon WHERE id = :id";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(':id', $id);
        $state->execute();
        $photoPath = $state->fetch(PDO::FETCH_ASSOC);
        return $photoPath['image'];

    }

    public function delete($id)
    {
        $photoPath = './assets/' . $this->getPhotoPath($id);
        unlink($photoPath);
        // Préparation de la requête DELETE avec une clause WHERE pour l'ID
        $query = "DELETE FROM pokemon WHERE id = :id";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(':id', $id);
        $state->execute();
    }

    public function update($id, PokeModel $pokemon ){

    }
}

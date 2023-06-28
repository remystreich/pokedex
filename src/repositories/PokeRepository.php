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
        $pokedexId = $pokemon->getPokedexId();

        $query = "INSERT INTO Pokemon (name, type, user_id, image, pokedex_id) VALUE (:name, :type, :user_id, :image, :pokedex_id)";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(":name", $name);
        $state->bindParam(":type", $type);
        $state->bindParam(":user_id", $userId);
        $state->bindParam(":image", $image);
        $state->bindParam(":pokedex_id", $pokedexId);
        $state->execute();
        $pokemonData = $state->fetch(PDO::FETCH_ASSOC);
        return $pokemonData;
    }

    public function getPokemons()
    {
        $query = "SELECT * FROM Pokemon p WHERE  p.user_id = :userId";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(":userId", $_SESSION["userId"]);
        $state->execute();
        $pokemonData = $state->fetchAll(PDO::FETCH_ASSOC);
        return $pokemonData;
    }

    public function getPokemon($id)
    {
        $query = "SELECT * FROM Pokemon  WHERE  user_id = :userId and id = :id";
        $state = $this->db->getConnection()->prepare($query);
        $state->bindParam(":userId", $_SESSION["userId"]);
        $state->bindParam(":id", $id);
        $state->execute();
        $pokemonData = $state->fetch(PDO::FETCH_ASSOC);
        return $pokemonData;
    }


    private function getPhotoPath($id){
        $query = "SELECT image FROM Pokemon WHERE id = :id";
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


    // public function update($id, PokeModel $pokemon  ){
    //     $photoPath = './assets/' . $this->getPhotoPath($id);
    //     unlink($photoPath);

    //     $name = $pokemon->getName();
    //     $type = $pokemon->getType();
    //     $image = $pokemon->getImage();

        
    //     $query = "UPDATE pokemon SET name = :name, type = :type, image = :image WHERE id = :id";
    //     $state = $this->db->getConnection()->prepare($query);
    //     $state->bindParam(":name", $name);
    //     $state->bindParam(":type", $type);
    //     $state->bindParam(":image", $image);
    //     $state->bindParam(":id", $id);
        
    //     $isUpdated = $state->execute();
        
    // // Retourner le résultat de la mise à jour (true si réussi, false sinon)
    // return $isUpdated;


    // }
    public function update($id, PokeModel $pokemon = null) {
       
        if ($pokemon !== null) {
            $query = "UPDATE Pokemon SET";
            $values = [];
            if ($pokemon->getName() !== null) {
                $query .= " name = :name,";
                $values[':name'] = $pokemon->getName();
            }
            
            if ($pokemon->getType() !== null) {
                $query .= " type = :type,";
                $values[':type'] = $pokemon->getType();
            }
            
            if ($pokemon->getImage() !== null) {
              
                $photoPath = './assets/' . $this->getPhotoPath($id);
                unlink($photoPath);
                $query .= " image = :image,";
                $values[':image'] = $pokemon->getImage();
            }
            if ($pokemon->getPokedexId() !== null) {
                $query .= " pokedex_id = :pokedex_id,";
                $values[':pokedex_id'] = $pokemon->getPokedexId();
            }
            
            // Supprimer la virgule finale de la requête
            $query = rtrim($query, ",");
            
            $query .= " WHERE id = :id";
            $values[':id'] = $id;
            
            $state = $this->db->getConnection()->prepare($query);
            
            foreach ($values as $param => $value) {
                $state->bindValue($param, $value);
            }
            
            $isUpdated = $state->execute();
        } else {
            // Aucune mise à jour à effectuer
            $isUpdated = false;
        }
        
        return $isUpdated;
    }
    
}

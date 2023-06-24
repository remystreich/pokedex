<?php
class PokeModel {
    private $id;
    private $name;
    private $type;
    private $user_id;
    private $image;
    private $pokedexId;

    public function __construct($name , $type, $user_id, $image = null, $pokedexId = null) {
        $this->name = $name;
        $this->type = $type;
        $this->user_id = $user_id;
        $this->image = $image;
        $this->pokedexId = $pokedexId;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getImage() {
        return $this->image;
    }
    public function getPokedexId() {
        return $this->pokedexId;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
    public function setImage($image) {
        $this->image = $image;
    }
    public function setPokedexId($pokedexId) {
        $this->pokedexId = $pokedexId;
    }

}
?>
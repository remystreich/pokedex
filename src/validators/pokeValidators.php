<?php


class pokeValidator  {

    private $nameRegex = "/^[A-Za-zÀ-ÖØ-öø-ÿ '0-9-]{2,}$/";
    private $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    private $errors = array();
    private $pokemon;
  

    public function __construct(PokeModel $pokemon)
    {
        $this->pokemon = $pokemon;
    }

  
    public function validateName() {
        if (preg_match($this->nameRegex, $this->pokemon->getName() )) {
            return true;
        } else {
            $this->errors['name'] = "Nom invalide";
        }
    }

    public function validateType() {
        if (preg_match($this->nameRegex, $this->pokemon->getType() )) {
            return true;
        } else {
            $this->errors['type'] = "Type invalide";
        }
    }

    public function validateImage() {
        $file = $this->pokemon->getImage();
        
       if ($file){
       
      
        if ( !array_key_exists('mime', $file) ) { 
            $this->errors['image'] = "Ce fichier n'est pas une image";
        }

       }

        return true;
    }


    public function validatePokemon() {
        $this->validateName();
        $this->validateType();
        $this->validateImage();
        return $this->errors;
    }
} 
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
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileMimeType = finfo_buffer($finfo, $file);
        finfo_close($finfo);
      
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
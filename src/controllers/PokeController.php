<?php
require_once './src/services/Validator.php';

class PokeController
{
    private $pokeRepository;
    public $errors = array();

    public function __construct()
    {
        $this->pokeRepository = new PokeRepository();
    }

    private function fetchAPI($data)
    {
        $apiUrl = 'https://pokebuildapi.fr/api/v1/pokemon/' . $data;
        try {
            // Effectuer la requête Fetch
            $response = file_get_contents($apiUrl);

            // Vérifier si la requête a réussi
            if ($response === false) {
                throw new Exception('Impossible de trouver ce pokémon');
            }

            // Convertir la réponse JSON en tableau associatif
            $result = json_decode($response, true);

            // Vérifier si la conversion JSON a réussi
            if ($result === null) {
                throw new Exception('Erreur de conversion JSON');
            }
            return $result;
        } catch (Exception $e) {
            // Gérer les exceptions
            include_once './views/catchPoke.php';
        }
    }

    public function catch($data)
    {
       
        try {
          
            $result = $this->fetchAPI($data['pokemon']);
            
            $image = $result['image'];
            $fileName = uniqid() . '.png';
            $uploadDirectory = './assets/uploads/';
            $filePath = $uploadDirectory . $fileName;

            // Télécharger l'image du Pokémon et l'enregistrer localement
            $imageData = file_get_contents($image);
            if ($imageData === false) {
                throw new Exception('Erreur lors du téléchargement de l\'image');
            }
            file_put_contents($filePath, $imageData);
            $filePathDb = 'uploads/' . $fileName;
            // Créer un objet PokeModel avec les données du Pokémon
            $pokemon = new PokeModel($result['name'], $result['apiTypes'][0]['name'], $_SESSION['userId'], $filePathDb, $result['pokedexId'] );

            // Enregistrer le Pokémon dans la base de données
            $pokemon = $this->pokeRepository->save($pokemon);
            $success = "Pokémon attrapé !";
            include_once './views/catchPoke.php';
        } catch (Exception $e) {
            // Gérer les exceptions
            include_once './views/catchPoke.php';
        }
    }

    public function displayPoke()
    {
        $pokemons = $this->pokeRepository->getPokemons();
        include_once './views/dashboard.php';
    }

    public function deletePoke($id)
    {
        $this->pokeRepository->delete($id);
        $this->displayPoke();
    }

    public function evoPoke($id, $pokedexId)
    {
        try {
            //Chercher l'evolution du pokemon
            $result = $this->fetchAPI($pokedexId);

            //Si pas d'evolution
            if (count($result['apiEvolutions']) == 0) {
                throw new Exception('Ce pokémon ne peut pas évoluer');
            }
            
            //récupérer l'evolution du pokemon
            $evolution = $this->fetchAPI($result['apiEvolutions'][0]['pokedexId']);


            // Télécharger l'image du Pokémon et l'enregistrer localement
            $image = $evolution['image'];
            $fileName = uniqid() . '.png';
            $uploadDirectory = './assets/uploads/';
            $filePath = $uploadDirectory . $fileName;
            $imageData = file_get_contents($image);
            if ($imageData === false) {
                throw new Exception('Erreur lors du téléchargement de l\'image');
            }
            file_put_contents($filePath, $imageData);

            //setter le chemin à enregistrer en bdd
            $filePathDb = 'uploads/' . $fileName;

            // Créer un objet PokeModel avec les données du Pokémon
            $evolution = new PokeModel($evolution['name'], $evolution['apiTypes'][0]['name'], $_SESSION['userId'], $filePathDb, $evolution['pokedexId'] );

            // Enregistrer le Pokémon dans la base de données
            $evolution = $this->pokeRepository->update($id, $evolution);
            $pokemons = $this->pokeRepository->getPokemons();
            include_once './views/dashboard.php';
        } catch (Exception $e) {
            // Gérer les exceptions
            $pokemons = $this->pokeRepository->getPokemons();
            include_once './views/dashboard.php';
        }
    }


    public function updatePoke($id ,$data){
        $validator = new Validator();
       
        if ($data['name']){
            
            $name = $data['name'];
            if ($validator->validateName($name)==false) {
                $errors['name'] = "Nom invalide";
            }

        }
        if ($data['type']) {
            $type = $data['type'];
            if ($validator->validateName($type)==false) {
                $errors['type'] = "Type invalide";
            }
        }
        if (!empty($_FILES['image']['tmp_name'])) {
            $image = $_FILES['image'];
            $type = explode('/', $image['type'])[1];
            if ($validator->validateImage($image)==false) {
                $errors['image'] = "Fichier invalide";
            }
            $fileName = uniqid() . '.png';
            $uploadDirectory = './assets/uploads/';
            $filePath = $uploadDirectory . $fileName;
            $imageData= file_get_contents($image['tmp_name']) ;
            file_put_contents($filePath, $imageData);
            //setter le chemin à enregistrer en bdd
            $filePathDb = 'uploads/' . $fileName;

        }
        if ($errors){
            include_once './views/update.php';
        }else{
            
            $update = new PokeModel($name, $type, $_SESSION['userId'], $filePathDb);
           
            // Enregistrer le Pokémon dans la base de données
            $update = $this->pokeRepository->update($id, $update);
            
            header("Location:  ".Config::$absolutepath."/dashboard");
        }
    }
}

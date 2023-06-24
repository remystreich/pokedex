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

    public function catch($data)
    {

        $apiUrl = 'https://pokebuildapi.fr/api/v1/pokemon/' . $data['pokemon'];
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
            $filePathDb = 'uploads/'.$fileName;
            // Créer un objet PokeModel avec les données du Pokémon
            $pokemon = new PokeModel($result['name'], $result['apiTypes'][0]['name'], $_SESSION['userId'], $filePathDb);

            // Enregistrer le Pokémon dans la base de données
            $pokemon = $this->pokeRepository->save($pokemon);
            $success = "Pokémon attrapé !";
            include_once './views/catchPoke.php';
        } catch (Exception $e) {
            // Gérer les exceptions
            include_once './views/catchPoke.php';
        }
    }

    public function displayPoke(){
        $pokemons = $this->pokeRepository->getPokemons();
        include_once './views/dashboard.php';
        
    }

    public function deletePoke($id){
        $this->pokeRepository->delete($id);
        $this->displayPoke();
        
    }

    public function evoPoke($id, $name){
        
        $apiUrl = 'https://pokebuildapi.fr/api/v1/pokemon/' . $name;
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
            if (count($result['apiEvolutions']) == 0 ){
                throw new Exception('Ce pokémon ne peut pas évoluer');
            }
            

            // Télécharger l'image du Pokémon et l'enregistrer localement
            $image = $result['image'];
            $fileName = uniqid() . '.png';
            $uploadDirectory = './assets/uploads/';
            $filePath = $uploadDirectory . $fileName;
            $imageData = file_get_contents($image);
            if ($imageData === false) {
                throw new Exception('Erreur lors du téléchargement de l\'image');
            }
            file_put_contents($filePath, $imageData);


            // Créer un objet PokeModel avec les données du Pokémon
            $evolution = new PokeModel($result['name'], $result['apiTypes'][0]['name'], $_SESSION['userId'], $filePath);

            // Enregistrer le Pokémon dans la base de données
            $evolution = $this->pokeRepository->update($id, $evolution);
            
            include_once './views/dashboard.php';
        } catch (Exception $e) {
            // Gérer les exceptions
            $this->displayPoke();
        }


        
    }

}
